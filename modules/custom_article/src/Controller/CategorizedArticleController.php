<?php

/**
 * @file
 * Contains \Drupal\custom_article\Controller\CategorizedArticleController.
 */

namespace Drupal\custom_article\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Block\Plugin\Block;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Path\AliasManager;

class CategorizedArticleController extends ControllerBase {

  public function cat_article_main($category) {

    print_r($category);
    //return $category;
    $term = Term::load($category);
    $name = $term->getName();

    $aliasManager = \Drupal::service('path.alias_manager');
    // The second argument to getAliasByPath is a language code such as "en" or LanguageInterface::DEFAULT_LANGUAGE.
    $more_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $category);



    return [
      '#theme' => 'categorized_article_main',
      '#category_name' => $name,
      '#category_linked' => $more_url,
      '#categorized_article_listing' => 'Listing here',
      'variables' => ['category_name' => 'cat2', 'category_linked' => 'More Cat2', 'categorized_article_listing' => 'Listing here' ],
      //'#test_var' => t('Test Value'),
    ];/**/
  }
}
