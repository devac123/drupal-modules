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
      $str = "";
      $role = \Drupal::currentUser()->getRoles();
      if($_GET){
        foreach($_GET as $key=>$val){
            $str .=$key;
            $str .="=";
            $str .=$val;
        }
      }
      if($str != ""){
        $connection = \Drupal::service('database');
        $query = $connection->insert('search_data')->fields([
          'uid' => \Drupal::currentUser()->id(),
          'name' => \Drupal::currentUser()->getDisplayName(),
          'current_path' => \Drupal::request()->getPathInfo(),
          'search_data'=> $str ,
        ])->execute();
      }
      elseif(in_array('administrator' ,$role))
        {
          dd("fob");
        }
      }
    }

