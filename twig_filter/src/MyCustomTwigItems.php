<?php

namespace Drupal\twig_filter;

/**
 * Class MyCustomTwigItems.
 */
class MyCustomTwigItems extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('field_respectful_label', [$this, 'getRespectfulFieldLabel']),
    ];
  }

  /**
   * Twig filter callback: Only return a field's label if not hidden.
   *
   * @param array $build
   *   Render array of a field.
   *
   * @return string
   *   The label of a field. If $build is not a render array of a field, NULL is
   *   returned.
   */
  public function getRespectfulFieldLabel(array $build) {
    // Only proceed if this is a renderable field array.
    if (isset($build['#theme']) && $build['#theme'] == 'field') {

      // Find out the label value.
      $disrespectful_label = isset($build['#title']) ? $build['#title'] : NULL;

      // Find out the visibility status of the label.
      $display_label = isset($build['#label_display']) ? ($build['#label_display'] != 'hidden') : FALSE;

      return ($disrespectful_label && $display_label) ? $disrespectful_label : NULL;
    }
    return NULL;
  }

}