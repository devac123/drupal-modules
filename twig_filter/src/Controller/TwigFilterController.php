<?php

namespace Drupal\twig_filter\Controller;
use Drupal\Core\Controller\ControllerBase;

class TwigFilterController extends ControllerBase {
  public function firstfilter() {
   
      $ret =  array(
         '#theme' =>'twig_filter_test_page',
         '#params' => 'data'
      );

      return  $ret;
  }
}