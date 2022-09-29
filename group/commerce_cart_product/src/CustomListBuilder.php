<?php

namespace Drupal\commerce_cart_product;

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

/**
 * Defines a class to build a listing of commerce_cart_product entities.
 *
 * @ingroup commerce_cart_product
 */
class CustomListBuilder extends EntityListBuilder {

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
   */




  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implementations.
   */
  public function render() {
    $build['description'] = array(
      '#markup' => $this->t('Content Entity Example implements a Inventory model. These contacts are fieldable entities. You can manage the fields on the <a href="@adminlink">Inventory admin page</a>.', array(
        '@adminlink' => \Drupal::urlGenerator()
          ->generateFromRoute('commerce_cart_product.settings'),
      )),
    );
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the inventory list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and inserts the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['id'] = $this->t('ContactID');
    $header['product_variation'] = $this->t('product Variation');
    $header['cart_limit'] = $this->t('Product Cart Limit ');
    $header['user_id'] = $this->t('User Name');
    
   
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\commerce_cart_product\Entity\CommerceCustomEntity */
    $row['id'] = $entity->id();
    $row['product_variation'] = $entity->product_variation->value;
    //$row['product_variation'] = $entity->link();
    $row['cart_limit'] = $entity->cart_limit->value;
    $row['user_id'] = $entity->user_id->value;
    return $row + parent::buildRow($entity);
  }


  // public function buildHeader() {
  //   $header['id'] = $this->t('ID');
  //   $header['account_id'] = $this->t('Account');
  //   $header['cash_amount'] = $this->t('Cash amount');
  //   $header['transaction_from'] = $this->t('From');
  //   $header['transaction_to'] = $this->t('To');
  //   $header['transaction_type'] = $this->t('Type');
  //   $header['shares_amount'] = $this->t('Shares amount');
  //   $header['share_round'] = $this->t('Share round');
  //   $header['author'] = [
  //     'data' => $this->t('Owner'),
  //     'class' => [RESPONSIVE_PRIORITY_LOW],
  //   ];
  //   return $header + parent::buildHeader();
  // }

  /**
   * {@inheritdoc}
   */
  // public function buildRow(EntityInterface $entity) {
  //   /** @var \Drupal\commerce_cart_product\Entity\PhTransaction $entity */
  //   $row['id'] = Link::createFromRoute(
  //     $entity->label(),
  //     'entity.commerce_cart_product.edit_form',
  //     ['commerce_cart_product' => $entity->id(), 'destination' => 'admin/content/commerce_cart_product']
  //   );
  //   $account_id = reset($entity->get('account_id')->getValue());
  //   $row['account_id'] = $account_id['target_id'];
  //   $row['cash_amount'] = $entity->get('cash_amount')->value;
  //   $transaction_from = reset($entity->get('transaction_from')->getValue());
  //   $row['transaction_from'] = $transaction_from['target_id'];
  //   $transaction_to = reset($entity->get('transaction_to')->getValue());
  //   $row['transaction_to'] = $transaction_to['target_id'];
  //   $row['transaction_type'] = BusinessService::TRANSACTION_TYPE[$entity->get('transaction_type')->value];
  //   $row['shares_amount'] = $entity->get('shares_amount')->value;
  //   $row['share_round'] = $entity->get('share_round')->target_id;
  //   $row['author']['data'] = [
  //     '#theme' => 'username',
  //     '#account' => $entity->getOwner(),
  //   ];
  //   return $row + parent::buildRow($entity);
  // }

}
