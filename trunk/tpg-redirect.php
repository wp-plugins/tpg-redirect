<?php
/*
Plugin Name: TPG Redirect
Plugin URI: http://www.tpginc.net/wordpress-plugins/
Description: Redirects to specified page when user not logged in.
Version: 1.0.3
Author: Criss Swaim
Author URI: http://www.tpginc.net/plugins/
License: This software is licensed under <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GNU GPL</a> version 2.0 or later.

Description:  TPG Redirect checks to see if a user is logged in and if not is redirected to path specified
*/


/*
 * Main controller for tpg-redirect
 *
 * @package WordPress
 * @subpackage tpg-redirect
 * @since 3.5
 *
 * determine if the plugin is being invoked in the frontend or backend and
 * load only the functions needed for that process
 * 
 * the tpg-redirect class sets up the base class that is extended for
 * either the frontend or backend processing.
 *
 */

//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);

// get base class
if (!class_exists("tpg_redirect")) {
    require_once plugin_dir_path(__FILE__)."inc/class-tpg-redirect.php";
}

//get plugin options & set paths
$rd = new tpg_redirect(plugin_dir_url(__FILE__),plugin_dir_path(__FILE__),plugin_basename(__FILE__));

//get class factory
if (!class_exists("tpg_rd_factory")) {
    require_once($rd->rd_paths["dir"]."inc/class-tpg-rd-factory.php");
}
// load appropriate class based on admin or front-end
if(is_admin()){
    // load backend class function
    $tpg_rd_admin = tpg_rd_factory::create_admin($rd->rd_opts,$rd->rd_paths);
}else{
    // load front-end class functions
    $tpg_rd_process = tpg_rd_factory::create_process($rd->rd_opts,$rd->rd_paths);

}  

?>
