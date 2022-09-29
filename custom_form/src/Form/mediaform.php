<?php

namespace Drupal\custom_form\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
// use Drupal\media_entity\Entity\Media;
use Drupal\media\Entity\Media; 

class mediaform extends FormBase 
{
    public function getFormId() {
        return 'form_id';
    }
    
    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config('custom_form.settings');
      $form['file'] = [
        '#type' => 'managed_file',
        '#allowed_bundles' => ['image'],
        '#title' => 'My image',
        '#name' => 'my_custom_file',
        '#description' => $this->t('my file description'),
        '#default_value' => $config->get('my_file'),
        '#upload_location' => 'public://mediafile'
      ];
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Upload'),
        );
        return $form;
      }
      public function submitForm(array &$form, FormStateInterface $form_state) 
      {
        $image=$form_state->getvalue(['file']);
        $fid=$image[0];
        $file = File::load($fid);
        $image_uri = ImageStyle::load('thumbnail')->buildUrl($file->getFileUri());
        $media = Media::create([
          'bundle'=> 'image',
          'uid' => \Drupal::currentUser()->id(),
          "thumbnail" => [
            "target_id" => $image[0],
            "alt" => $file->getFilename(),
          ],
          '	field_media' => [
          'target_id' => $image[0],
          ],
        ]);
        $media->setName('newimages')
          ->setPublished(TRUE)
          ->save();
        $image=$form_state->getvalue(['file']);
          $node = Node::create([
            'type'  => 'testing',
            'title' => 'check-image',
            'body' => 'here is my node body',
            'field_test_imh' =>  $image,
          ]);
          $node->save();
      }
}

?>