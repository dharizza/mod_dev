<?php

namespace Drupal\training_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Class for HelloController.
 */
class HelloController extends ControllerBase {

  /**
   * Returns output for hello world page.
   */
  public function hi() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello World!'),
    ];
  }

  /**
   * Returns output for hello world page.
   */
  public function hiSomeone($name) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello :name!', [':name' => $name]),
    ];
  }

  public function title($name) {
    return 'Page for ' . $name;
  }

  /**
   * Returns output for hello world page.
   */
  public function hiSomeoneNode($name, $nid) {
    $output = [];
    if (is_numeric($nid)) {
      $node = Node::load($nid);
      if ($node) {
        $title = $node->getTitle();
        $output = $this->t('Hello :name! The title of the node is :title', [':name' => $name, ':title' => $title]);
      }
      else {
        $output = $this->t('Hey :name! That nid does not exists!', [':name' => $name]);
      }
    }
    else {
      $output = $this->t('Hey :name! That nid should be a number!', [':name' => $name]);
    }
    return [
      '#type' => 'markup',
      '#markup' => $output,
    ];
  }

}
