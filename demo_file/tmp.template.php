<?php
global $theme;

define('PATH_CURRENT_THEME', base_path () . drupal_get_path ( 'theme', $theme ) . '/');
define('DEFAULT_NO_IMAGE', 'public://no-images.jpg');
include_once dirname(__FILE__) . "/inc/functions.inc";
function bookstore_css_alter(&$css) {
//    unset ( $css [drupal_get_path ( 'module', 'system' ) . '/system.theme.css'] );
//    unset ( $css [drupal_get_path ( 'module', 'system' ) . '/system.base.css'] );
}

function bookstore_preprocess_page(&$variables) {
    $scripts = drupal_add_js();
    $requestPath = request_path();
    $requestPath = explode('/', $requestPath);
    $status = drupal_get_http_header("status");
    if ($status == '403 Forbidden' || $status == '404 Not Found') {
        $variables['theme_hook_suggestions'][] = "page__403";
    }
    $arg = arg();
    if(isset($arg[0]) && $arg[0] == 'special-book') {
        // Build Breadcrumbs
        drupal_set_breadcrumb(array());
        drupal_set_title(t('Special gifts'));
        // Set Breadcrumbs
        drupal_set_breadcrumb($breadcrumb);
    }elseif(isset($variables['node']) && $variables['node']->type=='product') {
        $breadcrumb = array();
        $breadcrumb[] = l('Home', '<front>');
        $breadcrumb[] = t(' >> ' . $variables['node']->title);
        // Set Breadcrumbs
        drupal_set_breadcrumb($breadcrumb);
        drupal_set_title($variables['node']->title);

    }elseif(isset($arg[0]) && $arg[0] == 'books')  {
        if(isset($arg[1])) {
            $term_data = taxonomy_term_load($arg[1]);
            drupal_set_title($term_data->name);

        }else {
            $taxanomyTree = taxonomy_get_tree(2);
            $term_data = $taxanomyTree[0];
            drupal_set_title($term_data->name);
        }
        drupal_set_breadcrumb(array());

    }elseif(isset($arg[0]) && $arg[0] == 'user' && isset($arg[1]) && $arg[1] == 'login') {
        drupal_set_title(t('Login'));
        drupal_set_breadcrumb(array());

    }elseif(isset($arg[0]) && $arg[0] == 'user' && isset($arg[1]) && $arg[1] == 'register') {
        drupal_set_title(t('Register'));
        drupal_set_breadcrumb(array());

    }
    else{
        drupal_set_breadcrumb(array());

    }


}

function bookstore_pager($variables) {

    $tags = $variables['tags'];
    $element = $variables['element'];
    $parameters = $variables['parameters'];
    $quantity = $variables['quantity'];
    global $pager_page_array, $pager_total;
    // Calculate various markers within this pager piece:
    // Middle is used to "center" pages around the current page.
    $pager_middle = ceil($quantity / 2);
    // current is the page we are currently paged to
    $pager_current = $pager_page_array[$element] + 1;
    // first is the first page listed by this pager piece (re quantity)
    $pager_first = $pager_current - $pager_middle + 1;
    // last is the last page listed by this pager piece (re quantity)
    $pager_last = $pager_current + $quantity - $pager_middle;
    // max is the maximum page number
    $pager_max = $pager_total[$element];
    // End of marker calculations.
    // Prepare for generation loop.
    $i = $pager_first;
    if ($pager_last > $pager_max) {
        // Adjust "center" if at end of query.
        $i = $i + ($pager_max - $pager_last);
        $pager_last = $pager_max;
    }
    if ($i <= 0) {
        // Adjust "center" if at start of query.
        $pager_last = $pager_last + (1 - $i);
        $i = 1;
    }
    // End of generation loop preparation.
    $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« ')), 'element' => $element, 'parameters' => $parameters));
    $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t(' »')), 'element' => $element, 'parameters' => $parameters));
    $items[] = $li_first;
    if ($pager_total[$element] > 1) {
        // When there is more than one page, create the pager list.
        if ($i != $pager_max) {
            if ($i > 1) {
                $items[] = '…';
            }
            // Now generate the actual pager piece.
            for (; $i <= $pager_last && $i <= $pager_max; $i++) {
                if ($i < $pager_current) {
                    $items[] = theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters));
                }
                if ($i == $pager_current) {

                    $items[] = '<span class="current">'. $i . '</span>';
                }
                if ($i > $pager_current) {

                    $items[] = theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters));
                }
            }
            if ($i < $pager_max) {
                $items[] = '…';
            }
        }
        $items[] = $li_last;
        // End generation.
        $string_paging = '<div class="pagination">';
        if(!empty($items)) {
            foreach($items as $item) {
                $string_paging .= $item;
                }
        }
        $string_paging.='</div>';
        return $string_paging;
    }
}


function bookstore_preprocess_search_result(&$variables) {
    global $language;
    $node = $variables['result']['node'];
    if(isset($node->nid)){
        if($node->type=='product'){
            $n = node_load($variables['result']['node']->nid);
            if($n->language == $language->language)
                $variables['node'] = $n;
        }
    }
    else{
        $n = array();
    }
    $variables['node'] = $n;

}


function bookstore_preprocess_search_results(&$variables) {
    global $language;
    $variables['search_results'] = '';
    if (!empty($variables['module'])) {
        $variables['module'] = check_plain($variables['module']);
    }
    $search_count = array();
    foreach ($variables['results'] as $result) {
        if($result['node']->type=='product' && $result['node']->language == $language->language){
            $search_count[] = $result;
            $variables['search_results'] .= theme('search_result', array('result' => $result, 'module' => $variables['module']));
        }
    }
    $search_count = count($search_count);
    $variables['count'] = $search_count;
    $variables['pager'] = theme('pager', array('tags' => NULL));
    $variables['theme_hook_suggestions'][] = 'search_results__' . $variables['module'];

}