<?php
namespace Drupal\cart_product_limit\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\user\Entity\User;
use Drupal\cart_product_limit\Entity\ProductVariation;
use Drupal\cart_product_limit\Entity\Product;
use Drupal\commerce_price\Price;
use Drupal\cart_product_limit\Entity\CartProductLimit;
use Drupal\Core\URL;
use \Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CommerceProductCartLimtForm
 * @package Drupal\cart_product_limit\Form
 */
class CommerceCartProductLimitForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'cart_limt_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state){
      $form['product_variation'] = array(
      '#type' => 'entity_autocomplete',
      '#target_type' => 'commerce_product_variation',
      '#title' => $this->t('Product Variation'),
      '#required' => 'true',);

      $form['limit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cart Limt'),
      '#required' => 'false',);
      
    $form['member'] = array(
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('Role'),
      '#required' => 'false',);    
      
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    $user_roles = \Drupal::entityTypeManager()->getStorage('user_role')->loadMultiple();
    $current_user_role = \Drupal::currentUser();
    $roles = $current_user_role->getRoles();
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){  
    //extract Entity_ID from the autocompleted
    // $article_id = EntityAutocomplete::extractEntityIdFromAutocompleteInput($form_state->getValue('product_variation'));
      $ProductEntityID = $form_state->getValue('product_variation');
      $cart_limit = $form_state->getValue('limit');
      $role = $form_state->getValue('member');
      $user = \Drupal::currentUser()->id();
  
      // select variations from table product_cart_limit_entity.
      $query = \Drupal::database()->select('product_cart_limit_entity', 'pc');
      $query->addField('pc', 'product_variation');
      $query->condition('pc.product_variation',  $ProductEntityID);
      $product_variaiton = $query->execute()->fetchCol();
      if(empty($product_variaiton)){
        CartProductLimit::create(array(
            'product_variation' => $ProductEntityID,
            'cart_limit' => $cart_limit,
            'user_id' => $role
          ))->save();
          $url = Url::fromUri("https://localhost/admin/content/cart_product_limit/add?destination=admin/content/cart_product_limit/add");
          $response = new RedirectResponse($url->toString());
          $response->send();
          \Drupal::messenger()->addStatus(t('Product add successfully!!!'));
        }else{
          \Drupal::messenger()->addWarning(t('Product is already in use!!!'));
        }
      }
    }
    
