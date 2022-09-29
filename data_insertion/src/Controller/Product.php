<?php
namespace Drupal\data_insertion\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\commerce\commerce_product;
use Drupal\commerce;
use Drupal\commerce_cart;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\commerce_cart\CartProviderInterface;
use Drupal\commerce_cart\CartManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Product {
  public function create() {

    $type = "default";
    $price = "10$"; 
    return array(
      '#markup' => $price 
    );
  }
}