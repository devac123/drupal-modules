<?php

namespace Drupal\commerce_cart_product;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the commerce_cart_product entity.
 *
 * @see \Drupal\commerce_cart_product\Entity\CommerceCustomEntity.
 */
class CustomAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\commerce_cart_product\Entity\CommerceCustomEntityInterface $entity */

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view published commerce_cart_product entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit commerce_cart_product entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete commerce_cart_product entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add commerce_cart_product entities');
  }


}
