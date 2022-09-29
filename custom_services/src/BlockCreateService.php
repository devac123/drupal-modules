<?php

namespace Drupal\custom_services;


use Drupal\user\Entity;

class BlockCreateService{
     protected  $cls_var;

     public function _construct(){
        $this->cls_var = "return_value";
     }

     public function getValue(){
       $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()
         ->id());
        return "user";
     }

}
