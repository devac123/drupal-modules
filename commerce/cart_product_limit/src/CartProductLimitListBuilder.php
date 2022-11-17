<?php

namespace Drupal\cart_product_limit;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RedirectDestinationInterface;
use Drupal\ph_business\BusinessService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\cart_product_limit\Entity\ProductVariation;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Defines a class to build a listing of cart_product_limit entities.
 *
 * @ingroup cart_product_limit
 */
class CartProductLimitListBuilder extends EntityListBuilder {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The redirect destination service.
   *
   * @var \Drupal\Core\Routing\RedirectDestinationInterface
   */
  protected $redirectDestination;

  /**
   * Constructs a new PhAccountListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Routing\RedirectDestinationInterface $redirect_destination
   *   The redirect destination service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter, RedirectDestinationInterface $redirect_destination) {
    parent::__construct($entity_type, $storage);
    $this->dateFormatter = $date_formatter;
    $this->redirectDestination = $redirect_destination;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter'),
      $container->get('redirect.destination'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    // $build['description'] = array(
    //   '#markup' => $this->t('Content Entity Example implements a Inventory model. These contacts are fieldable entities. You can manage the fields on the <a href="@adminlink">Inventory admin page</a>.', array(
    //     '@adminlink' => \Drupal::urlGenerator()
    //       ->generateFromRoute('cart_product_limit.settings'),
    //   )),
    // );
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the inventory list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and 'insert' and 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ProductID');
    $header['product_variation'] = $this->t('Product Name');
    $header['cart_limit'] = $this->t('Product Cart Limit ');
    $header['user_id'] = $this->t('User Name');
    $header['operations'] = $this->t('Operations');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\cart_product_limit\Entity\CartProductLimit */
    $row['id'] = $entity->id();
    $product_variation_id = $entity->product_variation->target_id;
    $product = \Drupal\commerce_product\Entity\ProductVariation::load($product_variation_id);
    $entity_user = $entity->user_id->target_id;
    $account = \Drupal\user\Entity\User::load($entity_user);
    $username = $account->name->value;
    $row['product_variation'] = $product->title->value.' '.$product->sku->value;
    $row['cart_limit'] = $entity->cart_limit->value;
    $row['user_id'] = $username;
    $row['edit'] =  \Drupal\Core\Render\Markup::create('<a class="button--add-to-cart button button--warning js-form-submit form-submit btn-primary btn" href="https://localhost/admin/content/cart_product_limit/'.$row['id'].'/'.$product_variation_id.'/update">Edit</a>');
    $row['delete'] =  \Drupal\Core\Render\Markup::create('<a class="button--add-to-cart button button--danger js-form-submit form-submit btn-primary btn" href="http://localhost/admin/content/cart_product_limit/'.$row['id'].'/delete">Delete</a>');  
    return $row + parent::buildRow($entity);
  }
}