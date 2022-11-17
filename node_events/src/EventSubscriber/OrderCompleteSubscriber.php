<?php

namespace Drupal\orderplace\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\user\Entity\UserInterface;
use Drupal\user\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\group\Entity\Group;
use Drupal\group\Entity\GroupContent;
use Drupal\group\Entity\GroupInterface;
use Drupal\group\Entity\Storage\GroupRoleStorageInterface;
/**
 * Class OrderCompleteSubscriber.
 *
 * @package Drupal\MY_MODULE
 */
class OrderCompleteSubscriber implements EventSubscriberInterface {

 
  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   */
  public $account;


  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
   
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['commerce_order.place.post_transition'] = ['orderCompleteHandler'];

    return $events;
  }

  /**
   * This method is called whenever the commerce_order.place.post_transition event is
   * dispatched.
   *
   * @param WorkflowTransitionEvent $event
   */
    public function orderCompleteHandler(WorkflowTransitionEvent $event) {
      /* @var \Drupal\commerce_order\Entity\OrderInterface $order */
      $order = $event->getEntity();
      $uid_value = $order->get('uid')->getValue();

      $gids = [];
      foreach ($order->getItems() as $order_item) {
        /* @var \Drupal\commerce_product\Entity\ProductVariation $product_variation */
        $product_variation = $order_item->getPurchasedEntity();
        $product = $product_variation->getProduct();
        $group_value = $product->get('field_book')->getValue();
        foreach ($group_value as $group) {
          $gids[] = $group['target_id'];
        }
      }
      $gid = 1;
      // $group->addMember($user, ['group_roles' => ['podrazdelenie-admin']]);
      /* @var \Drupal\user\Entity\User $account */
      $account = User::load($uid_value[0]['target_id']);
      
      // dd($account);
      $group = \Drupal::entityTypeManager()->getStorage('group')->load(1);
      
        /* @var \Drupal\group\Entity\Group $group */
        // $values = ['group_roles' => 'content_editors' . '-' . 'book_users'];
        // $roles = array('book_users');
        $values = ['group_roles' => ['book_users']];
        // dd($values);
        $group->addMember($account,$values);
        // og_group('node',$gid, $values);
        $group->save();
        // $account = $account->get('uid')->value;
        // $account1=int($account);
        // $membership = $account1->getGroupContent();
        // $membership->group_roles[] = 'book_users';
        // $membership->save();

      
    }
    
}


    
/**
 * Submit callback for user_register form.
 */


// $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
// $group = \Drupal::entityTypeManager()->getStorage('group')->load(127);
// $group->addMember($user, ['group_roles' => ['podrazdelenie-admin']]);
// $group->save();