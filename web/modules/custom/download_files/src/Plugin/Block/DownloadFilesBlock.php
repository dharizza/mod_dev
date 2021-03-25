<?php

namespace Drupal\download_files\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a download files block block.
 *
 * @Block(
 *   id = "download_files_block",
 *   admin_label = @Translation("Download Files Block"),
 *   category = @Translation("Training")
 * )
 */
class DownloadFilesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // $form_builder = \Drupal::formBuilder();
    // $form = $form_builder->getForm('\Drupal\download_files\Form\DownloadFilesform');
    $form = \Drupal::formBuilder()->getForm('\Drupal\download_files\Form\DownloadFilesform');
    $form['intro_text'] = [
      '#type' => 'markup',
      '#markup' => '<small>Test block</small>',
      '#weight' => 99,
    ];
    $form['#title'] = $this->t('Get your files here!');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access download files form');
  }

}
