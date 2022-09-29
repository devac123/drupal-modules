<?php

namespace Drupal\custom_workingcouple\EventSubscriber;

use Drupal\commerce_cart\CartManagerInterface;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartEvents;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\user\Entity\User;
use Drupal\commerce_order\Entity\Order;
use Drupal\state_machine\Event\WorkflowTransitionEvent;

/**
 * Cart Event Subscriber.
 */
class CartEventSubscriber implements EventSubscriberInterface {

    // public function __construct(MessengerInterface $messenger, CartManagerInterface $cart_manager) {
    //     $this->messenger = $messenger;
    //     $this->cartManager = $cart_manager;
    // }


  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // $events = [
    //     CartEvents::CART_ENTITY_ADD => [['addToCart', 100]]
    //   ];
    $events['commerce_order.place.post_transition'] = ['orderCompleteHandler'];
    return $events;
  }

  /**
   * Add a related product automatically
   *
   * @param \Drupal\commerce_cart\Event\CartEntityAddEvent $event
   *   The cart add event.
   *
   * @throws \Drupal\Core\TypedData\Exception\ReadOnlyException
   */

    // public function addToCart(CartEntityAddEvent $event) {

    //     // \Drupal::logger('some_channel_name')->warning('<pre><code>' . print_r(helo, TRUE) . '</code></pre>');
        
    //     $cart = $event->getCart();
    //     // if(!empty($cart)){
        
    //         $added_order_item = $event->getOrderItem();
    //         $cart_items = $cart->getItems();
            
    //         foreach ($cart_items as $cart_item) {
                
    //             if ($cart_item->id() != $added_order_item->id()) {
    //                 $cart->removeItem($cart_item);
    //                 $cart_item->delete();
    //             }else{
    //                 // \Drupal::messenger()->addMessage(t("Sorry, there is a subscription in your cart already. You can only purchase one subscription."), 'error');
    //             }
            
    //         }

    //         $quantity = $cart_items[0]->getQuantity();
    //         if ($quantity > 1) {
    //             $cart_items[0]->setQuantity(1);
    //         }

    //         $cart->save();
    //     // }

    // }

    public function orderCompleteHandler(WorkflowTransitionEvent $event){
        // $cur_entity = $event->getEntity();
        // $cur_value = $cur_entity->get("uid")->getValue();

        // \Drupal::logger('cur_value')->notice('<pre><code>' . print_r($cur_value, TRUE) . '</code></pre>');

        // $user_id = $cur_value[0]['target_id'];
        // $cur_user = User::load($user_id);
        // \Drupal::logger('cur_user')->notice('<pre><code>' . print_r($cur_user, TRUE) . '</code></pre>');
        // $cur_user->addRole('paid_access_level');
        // $cur_user->removeRole('free_access_level');
        // $cur_user->save();
        $stripe = new \Stripe\StripeClient(
          'sk_test_51LdSp2SB6w3qfhwfl99z9tj22iSJ8HORVHs4bhU7YBACwGMKAlzROucglw0u9fcwiFSBMDuYgIIds8K7QVZ7hbqq00YgSVB7LR'
        );

        $payment_method = $stripe->paymentMethods->create([
          'type' => 'card',
          'card' => [
              'number' => $card_number,
              'exp_month' => $expiry_date[0],
              'exp_year' => $expiry_date[1],
              'cvc' => $code_cvv,
          ],
      ]);
      $customer = $stripe->customers->create([
          "email" => $form_state['storage']['submitted'][4],
          "payment_method" => $payment_method->id
      ]);
      // Charge the customer through the Payment Intents
      $charge = $stripe->paymentIntents->create([
          "customer" => $customer->id,
          'amount' => $amount,
          'currency' => $currency,
          "confirm" => true,
          "payment_method" => $payment_method->id,
          "setup_future_usage" => "off_session",
          'payment_method_types' => ['card'],
          "description" => $reciept_description,
          "payment_method_options[card][request_three_d_secure]" => "any",
          "return_url" =>   "https://careershifters.biz/processing-stripe-payment/" . $form['#node']->nid . "/one-time?mail=". $form_state['storage']['submitted'][4]
      ]);
        dd($createCustomer);
    }

}
