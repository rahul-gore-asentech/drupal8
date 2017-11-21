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
use Drupal\Core\GeneratedUrl;
use Drupal\Core\Language\Language;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Utility\LinkGenerator;
use Drupal\Core\GeneratedLink;

class CategorizedArticleController extends ControllerBase {

  public function cat_article_main($category) {

    //print_r($category);
    //return $category;
    $term = Term::load($category);
    $name = $term->getName();
    //print($term->url());
    $tlink = $term->url();
    $host = \Drupal::request()->getHost();
    global $base_url;
    //print($base_url);
    $catlink = 'http://'.$host.$tlink;
    //print '<pre>';print_r($term);print '</pre>';
    $aliasManager = \Drupal::service('path.alias_manager');
    // The second argument to getAliasByPath is a language code such as "en" or LanguageInterface::DEFAULT_LANGUAGE.
    $more_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $category);

    /*
    $url = Url::fromRoute('<front>', [], ['attributes' => ['class' => ['foo', 'bar']]]);

    $url->setUrlGenerator($this->urlGenerator);

    $link = Link::fromTextAndUrl('text', $url)->toString();
    /**/

    $url2 = Url::fromUri($catlink);
    $external_link = \Drupal::l(t('More '.$name), $url2);

    print($external_link);

  //$internal_link = \Drupal::l(t('Book admin'), $url);



    return [
      '#theme' => 'categorized_article_main',
      '#category_name' => $name,
      '#category_linked' => $external_link,
      '#categorized_article_listing' => 'Listing here',
      'variables' => ['category_name' => 'cat2', 'category_linked' => 'More Cat2', 'categorized_article_listing' => 'Listing here' ],
      //'#test_var' => t('Test Value'),
    ];/**/
  }
}
