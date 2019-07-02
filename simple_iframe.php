<?php
/*
**********************************************************************************
Plugin Name: Simple Iframe
Plugin URI: https://github.com/omarfaruksharif/simple_iframe
Description: Simple Iframe generator for WP. It will appear in the TinyMCE editor as a Media Button
Version: 1.1.0
Author: Omar Faruk Sharif
Author URI: https://github.com/omarfaruksharif/simple_iframe
Text Domain: simple_iframe
License: GPLv2 or later
Publish tool: Git

************************************************************************************

Copyright (C) 2019 Simple Iframe

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

************************************************************************************/


define( 'SIMPLE_IFRAME_PLUGIN_DIR', dirname(__FILE__) . '/' );
define( 'SIMPLE_IFRAME_PLUGIN_URL', plugin_dir_url(__FILE__)) ;
define( 'SIMPLE_IFRAME_PLUGIN_DOMAIN', 'simple_iframe' ) ;

function plugin_version() {
    if ( ! function_exists( 'get_plugins' ) )
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    $plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
    $plugin_file = basename( ( __FILE__ ) );
    return $plugin_folder[$plugin_file]['Version'];
}


/*
 * Add button to the media button context in edit/add new post screen
 *
 */

add_action( 'media_buttons_context',  'simple_iframe_media_button' );

add_action( 'admin_footer',  'add_inline_simple_iframe_popup_content' );

function simple_iframe_media_button($context) {

    add_action( 'wp_footer',  'add_inline_simple_iframe_popup_content' );
    
    simple_iframe_after_wp_tiny_mce();

    $buttonName = apply_filters( 'simple_iframe_media_button_name', __('Simple Iframe', SIMPLE_IFRAME_PLUGIN_DOMAIN) );
    $context .= "<a id='simple_iframe_popup_link' href='#TB_inline?width=650&height=350&inlineId=simple_iframe_popup_container&guid=".uniqid()."' 
                    class='button thickbox' title='{$buttonName} Generator'>{$buttonName}</a>";

    return $context;
}

function simple_iframe_after_wp_tiny_mce() {
    wp_enqueue_script( 'simple-iframe-script', SIMPLE_IFRAME_PLUGIN_URL . 'assets/js/simple_iframe.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload','thickbox' ) );
    wp_enqueue_script('jquery-ui-resizable');

    if( apply_filters( 'simple_iframe_include_bootstrap', 1 ) ) {
        wp_enqueue_style( 'simple-iframe-bootstrap-style', SIMPLE_IFRAME_PLUGIN_DIR . 'assets/css/bootstrap-4.0.0.min.css' );
    }
    wp_enqueue_style( 'simple-iframe-style', SIMPLE_IFRAME_PLUGIN_URL . 'assets/css/simple_iframe.css' );
}

function add_inline_simple_iframe_popup_content() {
    ?>
    <div id="simple_iframe_popup_container">
        <div class="simple_iframe_popup_container">
            <div class="wrap" id="tabs_container">
                <ul class="tabs">
                    <li class="active">
                        <a href="#" id="simple-iframe-tab" rel="#simple-iframe-tab-contents" class="tab">Generator Block</a>
                    </li>
                </ul>

                <div class="tab_contents_container">
                    <div id="simple-iframe-tab-contents" class="simple-iframe-tab-contents">
                        <form id="simple_iframe_form">
                            <div class="row iframe_url_wrapper">
                                <div class="col-3">
                                    <label for="simple_iframe_url" class="simple_iframe_label">File URL:<em class="required">*</em></label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="simple_iframe_url" name="simple_iframe_url" class="simple_iframe_field" />
                                </div>
                            </div>
                            <div class="row iframe_width_wrapper">
                                <div class="col-3">
                                    <label for="simple_iframe_width" class="simple_iframe_label">Iframe Width:<em class="required">*</em></label>
                                </div>
                                <div class="col-6 no-padding">
                                    <input type="text" id="simple_iframe_width" name="simple_iframe_width" class="simple_iframe_field" value="100%" />
                                </div>
                                <div class="col-3">
                                    <span class="description">Ex: 100% or 600px</span>
                                </div>
                            </div>
                            <div class="row iframe_height_wrapper">
                                <div class="col-3">
                                    <label for="simple_iframe_height" class="simple_iframe_label">Iframe Height: <em class="required">*</em></label>
                                </div>
                                <div class="col-6 no-padding">
                                    <input type="text" id="simple_iframe_height" name="simple_iframe_height" class="simple_iframe_field" value="600px"/>
                                </div>
                                <div class="col-3">
                                    <span class="description">Ex: 100% or 600px</span>
                                </div>
                            </div>

                            <div class="row simple_iframe_buttons_wrapper">
                                <input class="button button-primary" type="button" id="simple_iframe_generate" value="<?php _e('Insert Iframe', SIMPLE_IFRAME_PLUGIN_DOMAIN ); ?>">
                                <a class="button" onclick="tb_remove(); return false;" href="#">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}



