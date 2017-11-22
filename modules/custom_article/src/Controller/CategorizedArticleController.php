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
use Drupal\Core\Entity\Query;

class CategorizedArticleController extends ControllerBase {

  public function cat_article_main($category) {


    $term = Term::load($category);
    $name = $term->getName();
    $tlink = $term->url();

    $host = \Drupal::request()->getHost();
    global $base_url;

    $catlink = 'http://'.$host.$tlink;

    /*
    //get the alias of term
    $aliasManager = \Drupal::service('path.alias_manager');
    // The second argument to getAliasByPath is a language code such as "en" or LanguageInterface::DEFAULT_LANGUAGE.
    $more_url = $aliasManager->getAliasByPath('/taxonomy/term/' . $category);
    /**/

    //creating the Link
    //$url = Url::fromRoute('<front>', [], ['attributes' => ['class' => ['foo', 'bar']]]);
    $url = Url::fromUri($catlink);
    $url->setUrlGenerator($this->urlGenerator);
    $link = Link::fromTextAndUrl('More '.$name, $url)->toString();
    /**/

    /*
    //another method to create link
    $url2 = Url::fromUri($catlink);
    $external_link = \Drupal::l(t('More '.$name), $url2);
    /**/

    return [
      '#theme' => 'categorized_article_main',
      '#category_name' => $name,
      '#category_linked' => $link,
      '#categorized_article_listing' => 'Listing here...',
      'variables' => ['category_name' => 'cat2', 'category_linked' => 'More Cat2', 'categorized_article_listing' => 'Listing here' ],
      //'#test_var' => t('Test Value'),
    ];/**/
  }

  public function cat_article_listing($category) {

    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'news_article');
    $query->condition('status', 1);
    $query->condition('field_news_articles_terms', $category);
    $query->sort('field_post_date', DESC);
    $query->range(0,10);
    $nids = $query->execute();

    $nodes = entity_load_multiple('node', $nids);
    foeach($nodes as $node) {
      //do something
    }

  }
}
