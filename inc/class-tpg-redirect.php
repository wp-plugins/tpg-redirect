<?php
/*
 *	Base class for TPG Redirect
 *	this class is gets the options and sets paths
 *
 * @package WordPress
 * @subpackage tpg_redirect
 * @since 2.0
 *
 */
class tpg_redirect {
	// path variables	 
	public $rd_paths=array(
			"url" => '',
			"dir" => '',
			"css" => '',
			"css_url" => '',
			"js" => '',
			"js_url" => '',
			"inc" => '',
			"ext" => '',
			"base" => '',
			"name" => '',
			"theme_dir" => '',
			);		
	public $rd_opts=array(
			"rd-path"=>"",
			"rd-active"=>false,
			"valid-lic"=>false,
			);

 	// define constants for the plugin
 	public function __construct($url,$dir,$base) {
		$this->set_paths($url,$dir,$base);
		$this->rd_opts = array_merge($this->rd_opts,$this->get_options());
	}
	
	/**
	 *	get_options
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 2.0
	 *
	 * get any options for the plugin 
	 * 
	 * @param	void
	 * @return	array   assoc array of opts
	 *
	 */
	public function get_options() {
			return get_option("tpg_rd_opts", $this->rd_opts);
	}
		
	/**
	 *	set_paths
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 1.3.5
	 *
	 * add the TPG GET POSTS menu item to the Setting tab 
	 * 
	 * @param	string	url
	 * @param 	string	directory path from home
	 * @param	string	base to plugin
	 * @return	void
	 *
	 */
	function set_paths($url,$dir,$base) {

		$this->rd_paths['url'] = $url;
		$this->rd_paths['dir'] = $dir;
		$this->rd_paths['css'] = $dir."css/";
		$this->rd_paths['css_url'] = $url."css/";
		$this->rd_paths['js'] =	$dir."js/";
		$this->rd_paths['js_url'] =  $url."js/";
		$this->rd_paths['inc'] =  $dir."inc/";
		$this->rd_paths['ext'] =  $dir."ext/";
		$this->rd_paths['base'] = $base;
		$_arr= preg_split("#[/.]#",$base);
		$this->rd_paths['name'] = $_arr[1];
		$this->rd_paths['theme'] = get_stylesheet_directory().'/';
		$this->rd_paths['theme_url'] = get_stylesheet_directory_uri().'/';

	}
	
}


?>
