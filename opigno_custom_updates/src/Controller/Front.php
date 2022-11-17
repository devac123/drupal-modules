<?php
namespace Drupal\opigno_custom_updates\Controller;
class Front{
    
    public function frontpage() {
      $current_user = \Drupal::currentUser();
        $output = [
          '#cache' => [
            'contexts' => [
              'user.roles',
            ],
          ],
        ];
        if ($current_user->isAuthenticated()) {
       
          $output[] = $this->userDashboard();
          return $output;
        }
         else{
            $page = "/home";
            
           }
          $output  = "fjdgkd";
         }
      }
}

// C:\laragon\www\drupal-9.4.5\modules\custom\opigno_custom_updates\opigno_custom_updates.routing.yml