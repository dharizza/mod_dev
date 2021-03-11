<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
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
        $url = Url::fromRoute('entity.node.canonical', ['node' => $nid]);
        $internal_link = Link::fromTextAndUrl($title, $url)->toString();
        $output = $this->t('Hello :name! The node is @link', [':name' => $name, '@link' => $internal_link]);
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
