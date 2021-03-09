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
  public function hello() {
    return [
      '#type' => 'markup',
      '#markup' => '<h2>Hello World!</h2>',
    ];
  }

}
