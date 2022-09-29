<?php
namespace Drupal\checkout_pane\Plugin\Commerce\CheckoutPane;

use Drupal\checkout_pane\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

class CustomMessagePane extends CheckoutPaneBase {

    /**
     * {@inheritdoc}
     */
    public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
        $pane_form['message'] = [
          '#markup' => $this->t('This is my custom message.'),
        ];
        return $pane_form;
      }
  }