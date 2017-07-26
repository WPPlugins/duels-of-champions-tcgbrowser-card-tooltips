<?php
/*
Plugin Name: Duel of Champions TCGBrowser Card Tooltips
Plugin URI: http://wordpress.org/plugins/mmdoc-tcgbrowser-card-tooltips
Description: Transform Duel of Champions card names into links that show the card image when hovering over them.
Author: bogycoins
Author URI: http://mmdoc.tcgbrowser.com
Version: 1.0
License: GPLv2
*/

function mmdoc_tcgbrowser_register_button($buttons)
{
    array_push($buttons, "separator", "mmdoc_tcgbrowser");
    return $buttons;
}

function mmdoc_tcgbrowser_add_tinymce_plugin($plugin_array)
{
    $plugin_array['mmdoc_tcgbrowser'] = get_bloginfo('wpurl') .
        '/wp-content/plugins/duels-of-champions-tcgbrowser-card-tooltips/resources/tinymce3/editor_plugin.js';
    return $plugin_array;
}

function mmdoc_tcgbrowser_add_buttons()
{
    wp_enqueue_script('mmdoc_tcgbrowser', 'http://mmdoc.tcgbrowser.com/tools/api/tooltip.js', array('jquery'));

    if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        return;

    if (get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "mmdoc_tcgbrowser_add_tinymce_plugin");
        add_filter('mce_buttons', 'mmdoc_tcgbrowser_register_button');
    }
}

add_action('init', 'mmdoc_tcgbrowser_add_buttons');
