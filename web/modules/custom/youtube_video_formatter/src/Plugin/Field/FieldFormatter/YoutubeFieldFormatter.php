<?php

namespace Drupal\youtube_video_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'youtube_video_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_video_formatter",
 *   module = "youtube_video_formatter",
 *   label = @Translation("Youtube Video"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class YoutubeFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'youtube_video',
        '#youtube_id' => $item->value,
        '#width' => $this->getSettings('width'),
      ];
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'width' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['width'] = [
      '#type' => 'number',
      '#title' => 'Video Width',
      '#default_value' => 560,
      '#required' => TRUE,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = 'The width is ' . $this->getSetting('width');

    return $summary;
  }


}
