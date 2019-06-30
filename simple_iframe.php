<?php
/*
**********************************************************************************
Plugin Name: Simple Iframe
Plugin URI: https://github.com/omarfaruksharif/simple_iframe
Description: Simple Iframe generator for WP. It will appear in the TinyMCE editor as a Media Button
Version: 1.0.0
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
add_action( 'wp_footer',  'add_inline_simple_iframe_popup_content' );

function simple_iframe_media_button($context) {

    simple_iframe_after_wp_tiny_mce();

    $context .= "<a id='simple_iframe_popup_link' href='#TB_inline?width=650&height=300&inlineId=simple_iframe_popup_container&guid=".uniqid()."' 
                    class='button thickbox' title='Simple Iframe Generator'>Simple Iframe</a>";

    return $context;
}

function simple_iframe_after_wp_tiny_mce() {
    wp_enqueue_script( 'simple-iframe-scripts', SIMPLE_IFRAME_PLUGIN_URL . 'assets/js/simple_iframe.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload','thickbox' ) );
    wp_enqueue_script('jquery-ui-resizable');
}

function add_inline_simple_iframe_popup_content() {
    ?>
    <div id="simple_iframe_popup_container">
        <div class="wrap" id="tabs_container">
            <ul class="tabs">
                <li class="active">
                    <a href="#" id="simple-iframe-tab" rel="#simple-iframe-tab-contents" class="tab">Generator Block</a>
                </li>
            </ul>

            <div class="tab_contents_container">
                <div id="simple-iframe-tab-contents" class="simple-iframe-tab-contents tab_contents_active">
                    <form id="simple_iframe_form">
                        <ul>
                            <li>
                                <label for="simple_iframe_url">File URL:<em>*</em></label>
                                <input type="text" id="simple_iframe_url" name="simple_iframe_url" />
                            </li>
                            <li>
                                <label for="simple_iframe_width">Iframe Width:<em>*</em></label>
                                <input type="text" id="simple_iframe_width" name="simple_iframe_width" value="100%" />
                            </li>
                            <li>
                                <label for="simple_iframe_height">Iframe Height: <em>*</em></label>
                                <input type="text" id="simple_iframe_height" name="simple_iframe_height" value="600px"/>
                            </li>
                        </ul>

                        <input class="button-primary" type="button" id="simple_iframe_generate" value="<?php _e('Insert Iframe', SIMPLE_IFRAME_PLUGIN_DOMAIN ); ?>">
                        <a class="button" onclick="tb_remove(); return false;" href="#">Cancel</a>

                    </form>
                </div>
            </div>

            <style type="text/css">
                #simple_iframe_popup_container {
                    display: none;
                }
                #simple_iframe_form ul li label {
                    width: 140px;
                    display: inline-block;
                }
                #simple_iframe_form ul li label em {
                    color: red;
                }
                #simple_iframe_form ul li input {
                    width: 25%;
                }
                #simple_iframe_form ul li input#simple_iframe_url {
                    width: 67%;
                }
                #simple_iframe_form #simple_iframe_generate {
                    margin-left: 145px;
                }
                #TB_ajaxContent {
                    height: 300px !important;
                }
            </style>

        </div>
    </div>

    <?php
}



