<?php

namespace Drupal\custom_view_filter\Plugin\views\argument;

use Drupal\Core\Database\Query\Condition;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Plugin\views\argument\IndexTidDepth;
use Drupal\taxonomy\Plugin\views\argument\IndexTid;

/**
 * Argument handler for products with taxonomy terms with depth.
 *
 * Normally taxonomy terms with depth contextual filter can be used
 * only for content. This handler can be used for Drupal commerce products.
 *
 * Handler expects reference field name, gets reference table and column and
 * builds sub query on that table. That is why handler does not need special
 * relation table like taxonomy_index.
 *
 * @ingroup views_argument_handlers
 *
 * @ViewsArgument("node_taxonomy_name")
 */
class ContextualFilterHandler extends IndexTid {
  public function titleQuery() {
    // \Drupal::logger('my_module')->notice(json_encode($this->value));
    
    $titles = [];
    $terms = Term::loadMultiple($this->value);
    foreach ($terms as $term) {
      dd($ter);
      // $titles[] = \Drupal::service('entity.repository')->getTranslationFromContext($term)->label();
    }
    
    return $titles;
  }
}
