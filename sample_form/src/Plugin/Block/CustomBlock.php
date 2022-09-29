<?php

    namespace Drupal\sample_form\Plugin\Block;

    use Drupal\Core\Block\BlockBase;

    /**
     * Provides a 'CustomFormBlock' block.
     *
     * @Block(
     *   id = "sample_form",
     *   admin_label = @Translation("Custom Form Block"),
     *   category = @Translation("Custom")
     * )
    */
    class CustomBlock extends BlockBase {

        public function build(){

          $form = \Drupal::formBuilder()->getForm('Drupal\sample_form\Form\SimpleForm');
          return $form;
          
        }
   }
   