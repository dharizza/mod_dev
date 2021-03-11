<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HelloControler.
 */
class HelloController extends ControllerBase {

  /**
   * Returns output for hello world.
   */
  public function hello($name) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello :name!', [':name' => $name]),
    ];
  }

}
