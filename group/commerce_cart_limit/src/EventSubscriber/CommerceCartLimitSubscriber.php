<?php

namespace Drupal\commerce_cart_limit\EventSubscriber;

use Drupal\commerce_cart\Event\CartEvents;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_order\Event\OrderEvents;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartOrderItemUpdateEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\commerce_order\Entity\OrderItem;

/**
 * Commerce cart limit event subscriber.
 */
class CommerceCartLimitSubscriber implements EventSubscriberInterface {


  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {
    return [
      CartEvents::CART_ENTITY_ADD => ['CartItemAdd'],
      CartEvents::CART_ORDER_ITEM_UPDATE => ['CartItemUpdate']
    ];
  }
  /**
   * Add a related product automatically
   *
   * @param \Drupal\commerce_cart\Event\CartEntityAddEvent $event
   *   The cart add event.
   *
   * @throws \Drupal\Core\TypedData\Exception\ReadOnlyException
   */

  public function CartItemAdd(CartEntityAddEvent $event) {
    $cart = $event->getCart();
    $item = $event->getOrderItem();
    $product_entity = $item->getPurchasedEntityId();
    $cart_items = $cart->getItems();
    
    foreach ($cart_items as $quantity) {
      $qty = $quantity->getQuantity();
      $final_qty = explode(".",$qty);
      if ((int)$final_qty[0] > 1) {  
          $quantity->setQuantity((int)$final_qty[0] - 1);
          $cart_save = $cart->save();
        }
    }
   
    // $query = \Drupal::database()->select('commerce_custom_entity', 'c');
    // $query->fields('c');
    // $query->condition('c.product_variation', $product_entity, '=');
    // // $query->condition('c.cart_limit', $total_items, '>');
    // $full_name = $query->execute()->fetchObject();
    // \Drupal::logger('full_name')->warning('<pre><code>' . print_r($full_name, TRUE) . '</code></pre>');
      // if ($full_name) {
      //   //$cart_items = $result['cart_limit'];
      // }
    }

    public function CartItemUpdate(CartOrderItemUpdateEvent $event){
      $cart = $event->getCart();
      $item = $event->getOrderItem();
      $product_entity = $item->getPurchasedEntityId();
      $cart_items = $cart->getItems();
      foreach ($cart_items as $quantity) {
        $qty = $quantity->getQuantity();
        $final_qty = explode(".",$qty);
        if ((int)$final_qty[0] > 1) {  
          $quantity->setQuantity((int)$final_qty[0] - 1);
          $cart_save = $cart->save();
          $messenger = \Drupal::messenger();
          $messenger->addMessage('Item is already there', $messenger::TYPE_WARNING);
          }
      }
      
    }  
   
 
  }

 


