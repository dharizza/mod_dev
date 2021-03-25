<?php

namespace Drupal\download_files\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Download Files settings for this site.
 */
class DownloadFilesConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'download_files_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['download_files.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('File types to include in the download files form'),
      '#default_value' => $this->config('download_files.settings')->get('types'),
      '#options' => $this->getFileTypes(),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Helper function to get list of file types.
   */
  public function getFileTypes() {
    $query = \Drupal::database()
      ->select('file_managed', 'f')
      ->fields('f', ['filemime'])
      ->execute()
      ->fetchAll();

    $types = [];
    foreach ($query as $file) {
      $types[$file->filemime] = $file->filemime;
    }
    return $types;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('download_files.settings')
      ->set('types', $form_state->getValue('file_types'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
