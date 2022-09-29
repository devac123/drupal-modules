<?php

namespace Drupal\data_insertion\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "product_create",
 *   label = @Translation("Product Create" ),
 *   uri_paths = {
 *     "canonical" = "/vb/product_create"
 *   }
 * )
 */
class ProductCreate extends ResourceBase {
  
  public function get() {
 
    $response = new stdClass();
    $response->title = "toy";
    return $response;
  }
}