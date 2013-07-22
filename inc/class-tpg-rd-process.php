<?php
/*
  tpg_get_posts front-end processing
*/

//class tpg_rd_process extends tpg_get_posts {
class tpg_rd_process {
	//default parameter array
	
	//variables set by constructor				
	public $rd_opts=array();
	public $rd_paths=array();
	
	// constructor
	function __construct($opts,$paths) {
		$this->rd_opts=$opts;
		$this->rd_paths=$paths;
		
		// Register action if redirect active
		if ($this->rd_opts['rd-active']) {
			add_action('template_redirect', array(&$this, 'tpg_redirect'));
		}
		
	}
	
	/*
	 *	tpg_redirect
	 *  if user not logged in, then redirect to path specified in options
	 *
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 0.1
	 *
	 * test to see if user is logged in and if not, redirect to path specifiec in the opts
	 * 	
	 * @param    null
	 * @return   null
	 */
	public function tpg_redirect(){
		if (!is_user_logged_in()) {
			$new_site='http://'.$this->rd_opts['rd-path'];
			wp_redirect($new_site); 
			exit;
		}
	}
		
	
}//end class
?>
