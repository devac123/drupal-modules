<?php 

namespace Drupal\cart_product_limit\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ProductCartLimitEntity;
use Drupal\Core\Entity\Entity;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\URL;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\cart_product_limit\Entity\CartProductLimit;
use Drupal\Core\Render;


/**
 * An example controller.
 */
class CartProductLimitRouter extends ControllerBase {

  /**
   * Returns a render-able array for a test page.
   */
  public function build() {
    //Render Product List Bulider 
    return \Drupal::entityTypeManager()->getListBuilder('cart_product_limit')->render();
  }
}
?>
