<?php
namespace Drupal\cart_product_limit\EventSubscriber;

use Drupal\commerce_cart\Event\CartEvents;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_order\Event\OrderEvents;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartOrderItemUpdateEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\commerce_order\Entity\Order;


/**
 * Cart Product Limit event subscriber
 */
class CommerceCartProductLimitSubscriber implements EventSubscriberInterface {
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

  // Check product limit will adding the product into the cart 
  // first need to set the one time purchase product cart limit 

  public function CartItemAdd(CartEntityAddEvent $event) {
    $query = \Drupal::database()->select('product_cart_limit_entity', 'pc');
    $query->fields('pc', ['cart_limit','product_variation']);
    $cart_data = $query->execute()->fetchAll();
    $cart = $event->getCart();
    $item = $event->getOrderItem();
    $cart_items = $cart->getItems();
    $product_entity = $item->getPurchasedEntityId();
    for($i=0; $i<count($cart_data); $i++){
      if($product_entity === $cart_data[$i]->product_variation){
        $cart_items = $cart->getItems();
        foreach ($cart_items as $quantity) {
          $qty = $quantity->getQuantity();
          $final_qty = explode(".",$qty);
          if ((int)$final_qty[0] > $cart_data[$i]->cart_limit) {  
            $quantity->setQuantity($cart_data[$i]->cart_limit);
            $cart_save = $cart->save();
            $messenger = \Drupal::messenger();
            return \Drupal::messenger()->addMessage('OverLimit!!Please order under or equal to the limit! ', $messenger::TYPE_WARNING);
          }
        }
      }
    }
  }

  // Check product limit will update the product in the cart 
  // first need to set the one time purchase product cart limit
  public function CartItemUpdate(CartOrderItemUpdateEvent $event){
    $query = \Drupal::database()->select('product_cart_limit_entity', 'pc');
    $query->fields('pc', ['cart_limit','product_variation']);
    $cart_data = $query->execute()->fetchAll();
    $cart = $event->getCart();
    $item = $event->getOrderItem();
    $product_entity = $item->getPurchasedEntityId();
    for($i=0; $i<count($cart_data); $i++){
      if($product_entity === $cart_data[$i]->product_variation){
      $cart_items = $cart->getItems();
        foreach ($cart_items as $quantity) {
          $qty = $quantity->getQuantity();
          $final_qty = explode(".",$qty);
          if ((int)$final_qty[0]){
            if ((int)$final_qty[0] > $cart_data[$i]->cart_limit) {  
              $quantity->setQuantity($cart_data[$i]->cart_limit);
              $cart_save = $cart->save();
              $messenger = \Drupal::messenger();
              return \Drupal::messenger()->addMessage('OverLimit!!Please order under or equal to the limit! ', $messenger::TYPE_WARNING);
            }}else{
              \Drupal::messenger()->addWarning(t('Can update only single product is already in use!!!'));
            }
          }
        }
      }
    }  
  }

  
 
