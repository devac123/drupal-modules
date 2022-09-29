<?php

namespace Drupal\commerce_cart_product\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining commerce_cart_product entities.
 *
 * @ingroup commerce_cart_product
 */
interface CommerceCustomEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the commerce_cart_product creation timestamp.
   *
   * @return int
   *   Creation timestamp of the commerce_cart_product.
   */
  public function getCreatedTime();

  /**
   * Sets the commerce_cart_product creation timestamp.
   *
   * @param int $timestamp
   *   The commerce_cart_product creation timestamp.
   *
   * @return \Drupal\commerce_cart_product\Entity\CommerceCustomEntity
   *   The called commerce_cart_product entity.
   */
  public function setCreatedTime($timestamp);

}
