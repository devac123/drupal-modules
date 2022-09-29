<?php

namespace Drupal\twig_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
     * Provides a 'MymoduleExampleBlock' block.
     *
     * @Block(
     *   id = "Twig Block",
     *   admin_label = @Translation("Twig Block"),
     *   category = @Translation("custom")
     * )
    */

class twigBlock extends BlockBase
{
    public function build(){
        return array(
            '#markup' => "this id a put request",
            '#theme'=>"custom",
            '#params' => 'get params'
          );
    }
}


