<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
global $base_url;
//get image of product
$field = field_info_fields();
if(!empty($node)):


$defaulUriImage = file_load($field['uc_product_image']['settings']['default_image'])->uri;
if(isset($node->uc_product_image['und'][0]['uri'])){
    $uriImage = $node->uc_product_image['und'][0]['uri'];
    if(file_exists($uriImage)){
        $urlImage = image_style_url('image_98_150', $uriImage);
    }else{
        $urlImage = image_style_url('image_98_150', DEFAULT_NO_IMAGE);
    }

}else{
    $urlImage = image_style_url('image_98_150', DEFAULT_NO_IMAGE);
}
?>
    <div class="feat_prod_box">
        <div class="prod_img"><a href="<?php print $base_url . '/' .  drupal_lookup_path('alias', "node/".$node->nid)?>"><img typeof="foaf:Image" src="<?php echo image_style_url('image_98_150',$node->uc_product_image['und'][0]['uri'])?>" width="95" height="150" alt=""></a></div>
        <div class="prod_det_box">
            <span class="special_icon" alt="" title=""></span>
            <div class="box_top"></div>
            <div class="box_center">
                <div class="prod_title"><a href="<?php print $base_url . '/' .  drupal_lookup_path('alias', "node/".$node->nid)?>"><?php echo $node->title?></a></div>
                <p class="details"><?php echo $node->body[$node->language][0]['value']?></p>
                <a href="<?php print $base_url . '/' .  drupal_lookup_path('alias', "node/".$node->nid)?>" class="more">- more detail -</a>
                <div class="clear"></div>
            </div>
            <div class="box_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>

<?php endif;?>