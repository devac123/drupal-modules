<?php


namespace Drupal\student_registration\Form;


use \Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\media\Entity\Media; 
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use  \Drupal\Core\File\FileSystemInterface;
use Drupal\user\Entity\User;

/**
 * An example controller.
 */

//dd($result);
class ExampleController extends ControllerBase
{
  
    /**
     * Returns a render-able array for a test page.
     */
    public function currentNodeID(NodeInterface $node)
    {
      $res = new JsonResponse([
        $node->id(),
        $node->label(),
        $node->get('field_name')->getValue(),
        $node->get('field_email')->getValue(),
        $node->get('field_phoneno')->getValue(),
        $node->get('field_profile')->getValue(),
        $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id()),
        $uid= $user->get('uid')->value,
        $name = $user->get('name')->value,
        $current_path = \Drupal::request()->getPathInfo(),  
        $key = \Drupal::request()->query->get('keys'),
        $keywords = \Drupal::request()->query->get('keys'),
        // $node = \Drupal::routeMatch()->getParameter('node'),
      ]);
      return $res;
    }
    }

    