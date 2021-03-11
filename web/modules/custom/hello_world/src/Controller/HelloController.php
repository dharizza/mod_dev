<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Class HelloControler.
 */
class HelloController extends ControllerBase {

  /**
   * Returns output for hello world.
   */
  public function hello($name, $nid = NULL) {
    $output = $this->t('Hello :name!', [':name' => $name]);
    if (!is_null($nid) && is_numeric($nid)) {
      $node = Node::load($nid);
      if ($node) {
        $title = $node->getTitle();
        $output = $this->t('Hello :name! The node title is :title', [':name' => $name, ':title' => $title]);
      }
      else {
        $output = $this->t('Hello :name! There is no node with ID :nid', [':name' => $name, ':nid' => $nid]);
      }
    }

    return [
      '#type' => 'markup',
      '#markup' => $output,
    ];
  }

}
