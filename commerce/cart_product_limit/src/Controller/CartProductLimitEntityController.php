<?php 

namespace Drupal\cart_product_limit\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ProductCartLimitEntity;
use Drupal\Core\Entity\Entity;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\URL;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\cart_product_limit\Entity\CartProductLimit;

/**
 * An CartProductLimitEntityController controller.
 */
class CartProductLimitEntityController extends ControllerBase {

  /**
   * Delete Product cart limit entity.
   */
  public static function delete($id) {
    $entity = \Drupal::entityTypeManager()->getStorage('cart_product_limit')->load($id);
    // if(isset($entity)){
    //   $entity->delete();
    // }
    // $url = Url::fromUri("http://localhost/drupal_0/web/admin/content/cart_product_limit/list");
    // $response = new RedirectResponse($url->toString());
    // $response->send();
    // return \Drupal::messenger()->addStatus('Product Deleted successfully!!!');
    return [];
   
  }


  public function test($id){
    $entity = \Drupal::entityTypeManager()->getStorage('cart_product_limit')->load($id);
    if(isset($entity)){
      $entity->delete();
      $url = Url::fromUri("https://localhost/admin/content/cart_product_limit/list");
      $response = new RedirectResponse($url->toString());
      $response->send();
      return \Drupal::messenger()->addStatus('Product Deleted successfully!!!');
    }else{
      return \Drupal::messenger()->addWarning('Something went wrong!!!');
    }

  }
}
?>
