<?php

/**
 * @file
 * Contains \Drupal\commerce_cart_product\Entity\CommerceCustmEntity.
 */

namespace Drupal\commerce_cart_product\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Entity\Product;

/**
 * Defines the ContentEntityExample entity.
 *
 * @ingroup commerce_cart_product
 *
 * @ContentEntityType(
 *   id = "commerce_cart_product",
 *   label = @Translation(" Commerce Cart Product"),
 *   render_cache = FALSE,
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\commerce_cart_product\CustomListBuilder",
 *     "views_data" = "Drupal\commerce_cart_product\Entity\CommerceCustomEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\commerce_cart_product\Form\CommerceCustomEntityForm",
 *       "add" = "Drupal\commerce_cart_product\Form\CommerceCustomEntityForm",
 *       "edit" = "Drupal\commerce_cart_product\Form\CommerceCustomEntityForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\commerce_cart_product\CustomHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\commerce_cart_product\CustomAccessControlHandler",
 *   },
 *   base_table = "commerce_cart_product",
 *   translatable = FALSE,
 *   admin_permission = "administer commerce_cart_product entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/commerce_cart_product/{commerce_cart_product}",
 *     "add-form" = "/admin/content/commerce_cart_product/add",
 *     "edit-form" = "/admin/content/commerce_cart_product/{commerce_cart_product}/edit",
 *     "delete-form" = "/admin/content/commerce_cart_product/{commerce_cart_product}/delete",
 *     "collection" = "/admin/content/commerce_cart_product",
 *   },
 *   field_ui_base_route = "commerce_cart_product.settings"
 * )
 */
class CommerceCustomEntity extends ContentEntityBase implements CommerceCustomEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);


     // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Commerce entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Commerce entity.'))
      ->setReadOnly(TRUE);

       // Name field for the contact.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.


  $fields['product_variation'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product Varivation'))
      ->setDescription(t('The Name of Product Varivation'))
      ->setSetting('target_type', 'commerce_product_variation')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['cart_limit'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Product Cart Limit '))
      ->setDescription(t('The Product Cart Limit entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
   
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User Name'))
      ->setDescription(t('The Name of the associated user.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of inventory entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;

  }

}
