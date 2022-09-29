<?php

namespace Drupal\custom_workingcouple\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * An example controller.
 */
class workingcouplesController extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function content() {
    // $data = array();
    // $response = \Drupal::httpClient()
    //         ->post('/v1/customers', [
    //         'timeout' => 10,
    //         'body' => json_encode($data, JSON_FORCE_OBJECT),
    //         'headers' => [
    //             'Accept' => 'application/json', 
    //             'Content-Type' => 'application/json'
    //         ],
    //         'curl' => [CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2],
    //         'cert' => '/api_ssl_certs/lls-api-auth_B64.crt',
    //         'ssl_key' => '/api_ssl_certs/lls-org-api-auth_tlls_net.key',
    //         ]);

    \Drupal::logger('response')->warning('<pre><code>' . print_r($response, TRUE) . '</code></pre>');
    }

}