<?php

namespace Drupal\commerce_cart_product\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Commerce Entity  entities.
 */
class CommerceCustomEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
