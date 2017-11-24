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
use Drupal\node\Entity\Node;



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

    $nodes = CategorizedArticleController::get_cat_articles($category);
    $node_listing = '';
    //print '<pre>';print_r($nodes);print '</pre>';
    foreach($nodes as $node) {
      $node_list_data = CategorizedArticleController::cat_article_listing($node);
      $node_listing .= \Drupal::service('renderer')->render($node_list_data);
      //print '<pre>';print($node_listing);print '</pre>';
    }
      //$node_list_data = \Drupal::service('renderer')->render($node_listing);
    return [
      '#theme' => 'categorized_article_main',
      '#category_name' => $name,
      '#category_linked' => $link,
      //'#categorized_article_listing' => 'Listing here...',
      '#categorized_article_listing' => $node_listing,
      //'variables' => ['category_name' => 'cat2', 'category_linked' => 'More Cat2', 'categorized_article_listing' => 'Listing here2' ],
      //'#test_var' => t('Test Value'),
    ];/**/
  }

  public function get_cat_articles($category) {

    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'news_article');
    $query->condition('status', 1);
    $query->condition('field_news_articles_terms', $category);
    $query->sort('field_post_date', DESC);
    $query->range(0,10);
    $result = $query->execute();
    $nids = array_values($result);
    //print '<pre>';print_r($nids);print '</pre>';
    // Get a node storage object.
    //$node_storage = \Drupal::entityManager()->getStorage('node');
    $nodes_data = Node::loadMultiple($nids);
    //print '<pre>';print_r($nodes_data);print '</pre>';
    /*
    foeach($nodes as $node) {
      //do something
      print '<pre>';print_r($node);print '</pre>';
    }/**/
    return $nodes_data;

  }

  public function cat_article_listing($node) {

    //print '<pre>';print_r($node);print '</pre>';
    //print $node->get('title')->value;
    $title = $node->get('title')->value;
    return [
      '#theme' => 'categorized_article_listing',
      '#title' => $title,

    ];

  }
}
