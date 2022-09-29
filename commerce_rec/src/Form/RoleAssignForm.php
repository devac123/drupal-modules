<?php
namespace Drupal\commerce_rec\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_rec\Entity\CommerceRec;
use \Drupal\user\Entity\User;
use \Drupal\node\Entity\Node;
use Drupal\Core\Form\ConfigFormBase; 
use Drupal\commerce_product\Entity\ProductVariationType;

include(strval($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF'])).'/modules/custom/commerce_rec/usefulFunctions.php');

class RoleAssignForm extends ConfigFormBase {
    public function getFormId() {
        return 'assign_role';
      }
    /**  
   * {@inheritdoc}  
   */  
    protected function getEditableConfigNames() {  
      return [  
        'commerce_rec.admin-settings',  
      ];  
    } 
    public function buildForm(array $form, FormStateInterface $form_state) {

      /* ******************* Listing of Variation type and its role ******************** */
      // table html;
      $vaiation_role = '<table>
                            <thead>
                                <th>product variation type</th>
                                <th>Role</th>
                            </thead>
                            <tbody>
                            variation_type$
                            </tbody>
                        </table>';
        // load all the variationtype                        
        $product_variation_types = \Drupal::entityTypeManager()->getStorage('commerce_product_variation_type')->loadMultiple();
         $var_type = "";
        
        foreach ($product_variation_types as $key => $value) {
          /* find role according to the Variation Type  from commerce_rec database custom entity type*/
          $ent = \Drupal::entityTypeManager()->getStorage('commerce_rec')->loadByProperties(
            ['variation_type' => strtolower($key)]);
          $ro = null;  

          foreach($ent as $vt=>$ro){
             $ro = $ro->role->value;
          }  
          if($ro == null){
            $var_type .= '<tr><td>'. $key .'</td>'.'<td>'. '-' .'</td>'.'</tr>';
          }
          else{
            $var_type .= '<tr><td>'. $key .'</td>'.'<td>'. $ro .'</td>'.'</tr>';
          }
        }
        
        
        $Variation_role = str_replace("variation_type$",$var_type,$vaiation_role);

        // form fields

        // ************* get role ****************
        $roles = \Drupal\user\Entity\Role::loadMultiple();
        $role_option = [];
        foreach ($roles as $role) {
           array_push($role_option,ucfirst($role->id()));
        }
        $form['role'] =[
          '#type' => 'select',
          '#title' => $this->t('Role'),
          '#options' => $role_option, 
        ];
        // ************* get variation_type****************
        $variation_type = [];
        
        foreach ($product_variation_types as $key => $value) {
          array_push($variation_type,ucfirst($key));
        }
         $form['variation_type'] =[
          '#type' => 'select',
          '#title' => $this->t('PRODUCT VARIATION TYPE'),
          '#options' => $variation_type, 
         ];
      
        // ************* get variation_type****************
        $form['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit')
        ];
         
       

          $form['variation_type_role_listing'] =[
            '#markup' => $Variation_role
          ];
          return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      $key = $form_state->getValue('variation_type');
      $val = $form['variation_type']['#options'][$key];

      $role_key = $form_state->getValue('role');
      $role_value = $form['role']['#options'][$role_key];

        $data = \Drupal::entityTypeManager()->getStorage('commerce_rec')->loadByProperties(
          ['variation_type' => strtolower($val)]);
        if(count($data) == 0){
          $new= \Drupal::entityTypeManager()->getStorage('commerce_rec')->create(
            array(
              'variation_type' => strtolower($val),
              'role' => $role_value
            )
          ); //works
          $new->save(); 
        }
        else{
          $ent = \Drupal::entityTypeManager()->getStorage('commerce_rec')->loadByProperties(
            ['variation_type' => strtolower($val)]);
            foreach($ent as $key => $val){
              $evid = $val->id();
              $val->role->value = $role_value;
              $val->save();
            }
          }
    }


}
?>