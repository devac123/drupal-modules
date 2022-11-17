<?php

namespace Drupal\cart_product_limit\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cart_product_limit\Entity\CartProductLimit;

/**
 * Class CartProductLimitSettingsForm.
 *
 * @ingroup cart_product_limit
 */
class CartProductLimitSettingsForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'cart_product_limit_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // dd($form_state->getValues());
    $ProductEntityID = $form_state->getValue('product_variation');
    $cart_limit = $form_state->getValue('limit');
    $role = $form_state->getValue('member');
    $user = \Drupal::currentUser()->id();

    // select variations from table product_cart_limit_entity.
    $query = \Drupal::database()->select('product_cart_limit_entity', 'pc');
    $query->addField('pc', 'product_variation');
    $query->condition('pc.product_variation',  $ProductEntityID);
    $product_variaiton = $query->execute()->fetchCol();
    // dd($product_variaiton);
    if(empty($product_variaiton)){
        CartProductLimit::create(array(
          'product_variation' => $ProductEntityID,
          'cart_limit' => $cart_limit,
          'user_id' => $role
        ))->save();
      }
    // Empty implementation of the abstract submit class.
  }

  /**
   * Defines the settings form for cart_product_limit entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['product_cart_limit_entity_settings']['#markup'] = 'Settings form for Commerce Custom Entity. Manage field settings here.';
    return $form;
  }

}
