<?php

namespace Drupal\my_checkout_pane\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "my_checkout_pane_custom_message",
 *   label = @Translation("Custom message"),
 * )
 */
class CustomMessagePane extends CheckoutPaneBase {

  /**
   * {@inheritdoc}
   */


  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
 
    $pane_form['comment'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Optional order comment'),
      '#size' => 60,
    ];

    return $pane_form;
  }
  
  public function submitPaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
    $entere_choice = $form_state->getvalue('my_checkout_pane_custom_message')['comment'];
    $this->order->field_order_comment->value = $entere_choice;
    $this->order->save();

    
  }

  public function buildPaneSummary() {

    if ($order_comment = $this->order->field_order_comment->value) {
      return [
        '#plain_text' => $order_comment,
      ];
    }
    return [];
  }


}