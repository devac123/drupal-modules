<?php

namespace Drupal\student_registration\Controller; 

use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Query;
use Drupal\Core\Database\Connection;
/**
 * Route controller for search.
 */
class SearchController extends ControllerBase {
    
    public function insertCustom(){
      // $qt = new \stdClass();
      // $qt->query = array('setting1'=> value1, 'setting2'=> value2);
      // dd(\Drupal::request()->query->all());
      // dd();
      $str = "";
      
      foreach($_GET as $key=>$val){
          $str .=$key;
          $str .="=";
          $str .=$val;
      }
      // dd($str);
        $connection = \Drupal::service('database');
        $query = $connection->insert('search_data')->fields([
          'uid' => \Drupal::currentUser()->id(),
          'name' => \Drupal::currentUser()->getDisplayName(),
          'current_path' => \Drupal::request()->getPathInfo(),
          'search_data'=> $str ,
        ])->execute();
    }

}