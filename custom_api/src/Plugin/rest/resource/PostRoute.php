<?php

namespace Drupal\custom_api\Plugin\rest\resource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "custom post api",
 *   label = @Translation("Custom Post API"),
 *   uri_paths = {
 *     "create" = "cust/postRoute"
 *   }
 * )
 */
class PostRoute extends ResourceBase {
  /**
   * Responds to GET requests.
   * Returns a list of bundles for specified entity.
   */

    public function post(){
        $response = ['message' => 'Hello, this is a post rest service'];
        return new ResourceResponse($response);
    }
}