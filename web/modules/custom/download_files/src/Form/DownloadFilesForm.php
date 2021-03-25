<?php

namespace Drupal\download_files\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Provides a Download Files form.
 */
class DownloadFilesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'download_files_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file'] = [
      '#type' => 'select',
      '#title' => $this->t('File name'),
      '#required' => TRUE,
      '#description' => $this->t('Select the file that you want to download.'),
      '#options' => $this->getFiles(),
    ];

    $form['pass_phrase'] = [
      '#type' => 'email',
      '#title' => $this->t('E-mail'),
      '#description' => $this->t('Type in your email to retrieve the file.'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Download'),
    ];

    return $form;
  }

  /**
   * Helper function to get list of files.
   */
  public function getFiles() {
    $config = \Drupal::config('download_files.settings');
    $values = $config->get('types');
    $query = \Drupal::database()
      ->select('file_managed', 'f')
      ->fields('f', ['filename', 'uri'])
      ->condition('filemime', $values, 'IN')
      ->execute()
      ->fetchAll();

    $files = [];
    foreach ($query as $file) {
      $files[$file->uri] = $file->filename;
    }
    return $files;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $pass_phrase = $form_state->getValue('pass_phrase');
    if (!strpos($pass_phrase, 'evolvingweb.ca')) {
      $form_state->setErrorByName('pass_phrase', $this->t('This is an invalid email. Try again.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $uri = $form_state->getValue('file');
    $response = new BinaryFileResponse($uri);
    $response->setContentDisposition('attachment');
    $form_state->setResponse($response);
  }

}
