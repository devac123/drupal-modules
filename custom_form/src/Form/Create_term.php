<?php
namespace Drupal\custom_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;


class Create_term extends FormBase 
{
    public function getFormId() {
        return 'form_id';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['tagtest'] = [
            '#type' => 'entity_autocomplete',
            '#target_type' => 'taxonomy_term',
            '#title' => 'Taxonomy Term',
            '#autocreate' => [
              'bundle' => 'brands_', // Required. The bundle name for the new entity.
            ],
          ];
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Save'),
        );
        return $form;
      }
      public function submitForm(array &$form, FormStateInterface $form_state) 
      {
        $tag = $form_state->getValue('tagtest');
        
        if (empty($tag)) {
        drupal_set_message("Tag is empty, nothing to do");
        }
        elseif (is_string($tag)) {
        drupal_set_message("A term selected, tid = $tag");
        }
        elseif (isset($tag['entity']) && ($tag['entity'] instanceof \Drupal\taxonomy\Entity\Term)) {
        $entity = $tag['entity'];
        $entity->save();
        // drupal_set_message("A new term : " . $entity->id() . " : " . $entity->label());
        }
    }
}
?>