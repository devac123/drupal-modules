<?php

namespace Drupal\custom_view_filter\Plugin\views\filter;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\ManyToOne;
use Drupal\views\ViewExecutable;
use Drupal\views\Views;

/**
 * Filters by phase or status of project.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("test_filter")
 */


class CustomViewFilter extends ManyToOne {
    protected $currentDisplay;

    /**
     * {@inheritdoc}
     */
    public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
      parent::init($view, $display, $options);
      $this->valueTitle = t('Custom Option Filter');
      $this->definition['options callback'] = [$this, 'generateOptions'];
      $this->currentDisplay = $view->current_display;
    }
  
    /**
     * Helper function that generates the options.
     *
     * @return array
     *   An array of states and their ids.
     */
    // public function generateOptions() {
    //   $states = workflow_get_workflow_state_names();
    //   // You can add your custom code here to add custom labels for state transitions.
    //   return $states;
    // }
  
    /**
     * Helper function that builds the query.
     */
    public function query() {
    if (!empty($this->value)) {
      $configuration = [
        'table' => 'node__field_phase',
        'field' => 'entity_id',
        'left_table' => 'node_field_data',
        'left_field' => 'nid',
        'operator' => '=',
      ];
      
      $join = Views::pluginManager('join')->createInstance('standard', $configuration);
      $this->query->addRelationship('node__field_phase', $join, 'node_field_data');
      $this->query->addWhere('AND', 'node__field_phase.field_phase_value', $this->value, 'IN');
    }
  }
   
}

