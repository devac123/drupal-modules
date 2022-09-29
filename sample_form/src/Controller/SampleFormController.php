<?php

namespace Drupal\sample_form\Controller;
use Drupal\Core\Controller\ControllerBase;


class SampleFormController {
  public function add() {
    return array(
        '#markup' => "this id a put request",
        '#theme'=>"Customform",
      );
  }
}