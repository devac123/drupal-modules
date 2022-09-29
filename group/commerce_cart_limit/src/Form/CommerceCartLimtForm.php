<?php

namespace Drupal\commerce_cart_limit\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\user\Entity\User;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_price\Price;

/**
 * Class CommerceCartLimtForm
 * @package Drupal\product_cart_limt\Form
 */
class CommerceCartLimtForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'cart_limt_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
      $form['product_variation'] = array(
      '#type' => 'entity_autocomplete',
      '#target_type' => 'commerce_product_variation',
      '#title' => $this->t('Product Varivation'),
      '#required' => 'true',);

      $form['limit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cart Limt'),
      '#required' => 'false',);
      
    $form['member'] = array(
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('Role'),
      '#required' => 'false',);    
      
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    $user_roles = \Drupal::entityTypeManager()->getStorage('user_role')->loadMultiple();
    $current_user_role = \Drupal::currentUser();
    $roles = $current_user_role->getRoles();
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $article_id = EntityAutocomplete::extractEntityIdFromAutocompleteInput($form_state->getValue('product_variation'));
    \Drupal::messenger()->addMessage('Article ID is ' . $article_id);
  }
}
