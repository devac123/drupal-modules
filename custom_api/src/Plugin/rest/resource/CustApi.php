<?php

namespace Drupal\custom_api\Plugin\rest\resource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "custom api",
 *   label = @Translation("Custom API"),
 *   uri_paths = {
 *     "canonical" = "cust/api",

 *   }
 * )
 */
class CustApi extends ResourceBase {
  /**
   * Responds to GET requests.
   * Returns a list of bundles for specified entity.
   */
    public function get() {
        $response = ['message' => 'Hello, this is a rest service'];
        return new ResourceResponse($response);
    }

}