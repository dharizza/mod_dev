<?php

namespace Drupal\download_files\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Provides a Download files form.
 */
class DownloadFilesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'download_files';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['file'] = [
      '#type' => 'select',
      '#title' => $this->t('File name'),
      '#description' => $this->t('Select the file that you want to download.'),
      '#required' => TRUE,
      '#options' => $this->getFiles(),
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

  public function getFiles() {
    // $query = \Drupal::database()->select('file_managed', 'f')
    //   ->fields('f', ['filename', 'uri'])
    //   ->execute()
    //   ->fetchAll();
    // $files = [];
    // foreach ($query as $file) {
    //   $files[$file->uri] = $file->filename;
    // }
    // return $files;
    $fids = \Drupal::entityQuery('file')
      ->condition('status', 1)
      ->execute();
    $files = \Drupal\file\Entity\File::loadMultiple($fids);
    $options = [];
    foreach ($files as $fid => $file) {
      $options[$file->getFileUri()] = $file->getFilename();
    }
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('name', $this->t('Message should be at least 10 characters.'));
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
