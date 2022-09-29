<?php

namespace Drupal\product_list\Controller;
use Drupal\Core\Controller\ControllerBase;

class ProductListController {
  public function getProducts($id) {
    $database = \Drupal::database();  //database connection 

    if($id != ''){
      $query = $database->query("SELECT * FROM {tb_products} WHERE nid = $id ");
      $result = $query->fetchAll();
      if(count($result)>0){
        $num_deleted = $database->delete('tb_products')
        ->condition('nid', $id)
        ->execute();
      }
      else{
        $this->messenger()->addStatus($this->t("Product not Available!!"));
      }
    }
    $query = $database->query("SELECT * FROM {tb_products}");
    $result = $query->fetchAll();
    
    return array(
      '#markup' => "this id a put request",
      '#theme'=>"product_list",
      '#params' => $result
    );
    }

    public function Cservice(){

      $our_service = \Drupal::service('custom_services.block_create');
      
      return array(
        '#markup' =>  $our_service->getValue(),
      );
    }



}



