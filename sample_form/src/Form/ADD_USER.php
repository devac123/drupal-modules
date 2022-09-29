<?php
namespace Drupal\sample_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\user\Entity\User;
use \Drupal\node\Entity\Node;


class ADD_USER extends FormBase {
    public function getFormId() {
        return 'Add_user';
      }
    
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['username'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Username'), 
            '#attributes' => array('id' => 'name-field', 
                                    'placeholder'=> 'Enter The Username',
                                    'class' => ['form-control']),
          ];
        $form['email'] = [
            '#type' => 'textfield',
            '#title' => $this->t('E-mail'), 
            '#attributes' => array('id' => 'email-field', 
                                    'placeholder'=> 'Enter Your Email',
                                    'class' => ['form-control']),
          ];
          $form['password'] =[
            '#type' => 'password',
            '#title' => $this->t('Password'), 
            '#attributes' => array('id' => 'password', 'placeholder'=> 'Enter The Password'),
          ];

          $form['role'] =[
            '#type' => 'select',
            '#title' => $this->t('Selct-Role'),
            '#options' => array(t('--- SELECT ---'), t('admin"'), t('authenticated user"'), t('content editor"'), t('ANONYMOUS USER"')), 
          ];
          
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit')
          ];

          return $form;
  
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('username')) < 4) {
            $form_state->setErrorByName('username', $this->t('username is too short.'));
          }
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {
        


        $username = $form_state->getValue('username');
        $email =    $form_state->getValue('email');
        $password = $form_state->getValue('password');
        
      

        $database = \Drupal::database();

        $query = $database->query("SELECT * FROM {users} inner join {users_field_data} on users.uid = users_field_data.uid WHERE  mail  = '$email'");
    
        $result = $query->fetchAll();

        if(count($result) < 1){
            $new_user = array(
                'name'=>$username,
                'pass'=>$password,
                'mail'=>$email,
                'status'=>1,
                'init'=> $email,
                'rols'=> array("DRUPAL_AUTHENTICATED_RID" => 'authenticated user',
                            3 => 'administrator',
                            )
                );
                
                 $user =  User::create($new_user)->save();
                
                 
              

                $this->messenger()->addStatus($this->t($form_state->getValue('username')));

              $uid = user_load_by_mail($email); // user load 
              $uid->addRole('administrator');
              $uid->save();
              
        }
        else{
            $this->messenger()->addStatus($this->t($form_state->getValue('username')));
        }


    }
}