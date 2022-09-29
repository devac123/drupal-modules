<?php

    namespace Drupal\footer_block\Plugin\Block;

    use Drupal\Core\Block\BlockBase;

    /**
     * Provides a 'MymoduleExampleBlock' block.
     *
     * @Block(
     *   id = "footer_block",
     *   admin_label = @Translation("Custom Block"),
     *   category = @Translation("custom")
     * )
    */
    class FooterBlock extends BlockBase {

     /**
      * {@inheritdoc}
     */
     public function build() {

    //   $form=array('alla'=> 'allla hoakbar');
        
       return array(
           '#markup' => 'footer_block' 
       );
     }
   }