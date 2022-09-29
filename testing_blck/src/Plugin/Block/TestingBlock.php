<?php

namespace Drupal\testing_blck\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Information"),
 *   category = @Translation("Hello_World"),
 * )
 */
class TestingBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    
    return [
      '#markup' => 'allla hoakbar'
    //     '#theme' => 'custom-block',
    //     '#title' => 'custom-block',
    //     '#data' => [
    //     'Developed by' => 'parkash singh',
    //     'since'=>'2 May 1998'
    //       ]
     ];

    
    
  }

}