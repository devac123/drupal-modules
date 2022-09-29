<?php

namespace Drupal\commerce_rec\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the commerce_rec entity.
 *
 * @ingroup commerce_rec
 *
 * @ContentEntityType(
 *   id = "commerce_rec",
 *   label = @Translation("commerce_rec"),
 *   base_table = "commerce_rec",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 * )
 */

class CommerceRec extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the commerce_rec entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the commerce_rec entity.'))
      ->setReadOnly(TRUE);

    $fields['variation_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('variation_type'))
      ->setDescription(t('The variation_type of the commerce_rec entity.'))
      ->setReadOnly(TRUE);

    $fields['role'] = BaseFieldDefinition::create('string')
      ->setLabel(t('role'))
      ->setDescription(t('The role of the commerce_rec entity.'))
      ->setReadOnly(TRUE);

    return $fields;
  }
}
?>