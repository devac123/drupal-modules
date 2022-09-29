<?php

namespace Drupal\twig_word_count_extension\TwigExtension;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigWordCountExtension extends \Twig_Extension  {
  /**
   * This is the same name we used on the services.yml file
   */
  public function getName() {
    return 'twig_word_count_extension.twig_extension';
  }

  // Basic definition of the filter. You can have multiple filters of course.
  public function getFilters() {
    return [
      new Twig_SimpleFilter('word_count', [$this, 'wordCountFilter']),
      new Twig_SimpleFilter('word_length', [$this, 'wordLength']),
      new Twig_SimpleFilter('strtrim', [$this, 'strtrim']),
    ];
  }
  // The actual implementation of the filter.
  public function wordCountFilter($context) {
    if(is_string($context)) {
      $context = str_word_count($context);
    }
    return $context;
  }

  public function wordLength($var){
    $ret = '';
      
      if(is_string($var)){
        $ret =  strlen($var);  
      }
      if(is_array($var))
      {
        $ret = count($var);
      }

    return $ret;  

  }

  

}