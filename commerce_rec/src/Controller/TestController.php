<?php

namespace Drupal\commerce_rec\Controller;


class TestController{

    public function deleteGroup($id = null){
        
        if(isset($_SERVER['HTTP_REFERER'])){
            $group = \Drupal::entityTypeManager()
              ->getStorage('group')->loadByProperties([ 
                'id' => $id,
              ]);
                if($group){
                    foreach ($group as $item) {
                        $item->delete();
                        header('Location: '.$_SERVER['HTTP_REFERER']);
                        exit;
                        }
                    }
                else
                {
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                    exit;
                }

        }
        header('Location: '.$GLOBALS['base_url']);
        exit;
        return;
        
    }

    public function node_activity(){
        

    
        return array(
            '#markup' => 'D'
        );
    }
}