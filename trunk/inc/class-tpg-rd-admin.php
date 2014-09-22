<?php
/*
 *  display the settings page
*/
//class tpg_rd_settings extends tpg_redirect {
class tpg_rd_admin {
	
	private $pp_btn='';
					
	protected $vl=object;
					
	//variables set by constructor				
	public $rd_opts=array();
	public $rd_paths=array();
	public $plugin_data=array();
	public $module_data=array();
	
	function __construct($opts,$paths) {
		$this->rd_opts=$opts;
		$this->rd_paths=$paths;
		$this->module_data= array( 
				'updt-sys'=>'wp',
				"module"=>'tpg-redirect',
				);
		
		$this->vl = tpg_gp_factory::create_lic_validation($this->rd_opts,$this->rd_paths,$this->module_data);
		$this->vl->get_plugin_info();
		$this->plugin_data = $this->vl->plugin_data;
		
		// Register link to the pluging list
		add_filter('plugin_action_links', array(&$this, 'tpg_redirect_settings_link'), 10, 2);
		// Add the admin menu item
		add_action('admin_menu', array(&$this,'tpg_redirect_admin'));	

	}
	
	/**
	 *	add footer info on admin page 
	 *
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 1.3
	 *
	 * write the footer information on options page
	 * 
	 * @param	array	$links
	 * @param 	 		$file
	 * @return	array	$links
	 *
	*/ 
	public function tpg_rd_footer() {
		printf('%1$s by %2$s<br />', $this->plugin_data['Title'].'  Version: '.$this->plugin_data['Version'], $this->plugin_data['Author']);
	}

	/*
	 *	add link to plugin doc & settings 
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 1.3
	 *
	 * add the settings link in the plugin description area
	 * 
	 * @param	array	$links
	 * @param 	 		$file
	 * @return	array	$links
	 */
	 
	function tpg_redirect_settings_link($links, $file) {
		static $this_plugin;
		if (!$this_plugin) $this_plugin = plugin_basename($this->rd_paths['base']);
		if ($file == $this_plugin){
			$settings_link = '<a href="options-general.php?page=tpg-redirect-settings">'.__('Settings', 'tpg_redirect').'</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
}

	/**
	 *	add admin menu
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 1.3
	 *
	 * add the TPG redirectS menu item to the Setting tab 
	 * 
	 * @param    void
	 * @return   void
	 *
	 */
	function tpg_redirect_admin () {
		// if we are in administrator environment
		if (function_exists('add_submenu_page')) {
			add_options_page('TPG Redirect Settings', 
							'TPG Redirect', 
							'manage_options',
							'tpg-redirect-settings', 
							array(&$this,'tpg_rd_show_settings')
							);
		}
	}
	
	/*
	 * show the settings page
	 *
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 2.8
	 *
	 * the html text for the setting page is loaded into the content variable 
	 * and then printed.
	 * the style sheet is enqueued using the wp enqueue process
	 * 
	 * @param    type    $id    post id
	 * @return   string         category ids for selection
	 *
	 */ 
	public function tpg_rd_show_settings() {
		//get css, js	
		$this->rd_admin_load_inc();
		
		// footer info for settings page
		add_action('in_admin_footer', array($this,'tpg_rd_footer'));
		
		//if options have been set, process them & update array
		if( isset($_POST['rd_opts']) ) {
			$new_opts = $_POST['rd_opts'];

			$_func = $_POST['func'];
			
			switch ($_func) {
				case 'updt_opts':
					$this->update_options($new_opts);
					break;
			}
			//refresh options
			$this->rd_opts=tpg_redirect::get_options();

		}

		$page_content = file_get_contents($this->rd_paths['inc'].'doc-text.php');
		//replace tokens in text
		$page_content = str_replace("{settings}",$this->tpg_rd_bld_setting(),$page_content);
		$page_content = str_replace("{icon}",screen_icon(),$page_content);
		if ($this->rd_opts['valid-lic']) {
			$page_content = str_replace("{donate}",'',$page_content);
		} else {
			$page_content = str_replace("{donate}",$this->pp_btn,$page_content);
		}
		
		echo $page_content;
	
	}
	
	function tpg_rd_bld_setting() {
		$form_output = $this->build_form();
		//set action link for form
		$action_link = str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])."#rd-settings"; 
		//replace tokens in text
		$form_output = str_replace("{action-link}",$action_link,$form_output);
		$ver_txt = $this->plugin_data['Version'];
		//set tokens in form
		$form_output = str_replace("{cur-ver}",$ver_txt,$form_output);
		//$form_output = str_replace("{valid-lic-msg}",$valid_txt,$form_output);
		//$form_output = str_replace("{update-button}",$upd_button,$form_output);
		//$form_output = str_replace("{download-link}",$this->resp_data['dl-link'],$form_output);
		//$form_output = str_replace("{download-url}",$this->resp_data['dl-url'],$form_output);

		return $form_output;	
	}
	
	/*
	 *	update_options
	 *  update the wp plugin options
	 *
	 * @subpackage tpg_redirect
	 * @since 2.0
	 *
	 * update options
	 * 	
	 * @param    null
	 * @return   null
	 */
	function update_options($new_opts){
		//chk box will not return values for unchecked items
		if (!array_key_exists("rd-active",$new_opts)) {
			$new_opts['rd-active'] = false;
		} else {
			$new_opts['rd-active'] = true;
		}
		
		
		//apply new values to rd_opts 
		foreach($new_opts as $key => $value) {
			$this->rd_opts[$key] = $value;
		}
		
		//update with new values
		update_option( 'tpg_rd_opts', $this->rd_opts);
		
		echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
	}
			
	/**
     * normalize version
	 * 
	 * Normalize the version so alpha 2.0.1 and 2.01.0 will compare correctly.  
	 * convert alph ver xx.xx.xx to numeric x.xxxx
	 *
     * @param 	string	version
	 * @return	float	version numeric in x.xxxx
     */
	function normalize_ver($_v) {
	    //convert alph ver xx.xx.xx to x.xxxx
    	$va = array_map('intval',explode('.',$_v));
		return $va[0]+$va[1]*.01+$va[2]*.0001;
	}
	
	/*
	 *	rd_admin_load_inc
	 *  enque css, js and other items for admin page
	 *
	 * @package WordPress
	 * @subpackage tpg_phplist
	 * @since 0.1
	 *
	 * enque the css, js and other items only when the admin page is called.
	 * 	
	 * @param    null
	 * @return   null
	 */
	function rd_admin_load_inc(){
		//enque css style 

		$trd_css = "tpg-redirect-admin.css";
		//check if file exists with path
		if (file_exists($this->rd_paths['css'].$trd_css)) {
			wp_enqueue_style('tpg_redirect_admin_css',$this->rd_paths['css_url'].$trd_css);
		}
		
		//get jquery tabs code
		wp_enqueue_script('jquery-ui-tabs');
		
		//load admin js code
		if (file_exists($this->rd_paths['js']."tpg-redirect-admin.js")) {
			wp_enqueue_script('tpg_redirect_admin_js',$this->rd_paths['js_url']."tpg-redirect-admin.js");
		}
		
		//generate pp donate button
		//include_once("class-tpg-pp-donate-button.php");
		//$ppb = new tpg_pp_donate_button;
		$ppb = tpg_rd_factory::create_paypal_button();
		$ask="<p>If this plugin helps you build a website, please consider a small donation of $5 or $10 to continue the support of open source software.  Taking one hour&lsquo;s fee and spreading it across multiple plugins is an investment that generates amazing returns.</p><p>Thank you for supporting open source software.</p>";
		$ppb->set_var("for_text","wordpress plugin tpg-get-posts");
		$ppb->set_var("desc",$ask);
		$this->pp_btn = $ppb->gen_donate_button();
	}
	
	/*
	 *	build form for options
	 *  
	 * @package WordPress
	 * @subpackage tpg_redirect
	 * @since 2.0
	 *
	 * @param    null
	 * @return   null
	 */
	function build_form() {
		//array to hold changes
		$rd_opts = array();
		
		//test the check boxes to see if the value should be checked
		$ck_rd_active = ($this->rd_opts['rd-active'])? 'checked=checked' : '';
		//text for button
		$btn_updt_opts_txt = __('Update Options', 'rd_update_opts' ) ;
		//create output form
		$output = <<<EOT
		<div class="wrap">		
	<div class="postbox-container" style="width:100%; margin-right:5%; " >
		<div class="metabox-holder">
			<div id="jq_effects" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3><a class="togbox">+</a> TPG Redirect Options</h3>
				
				<div class="inside"  style="padding:10px;">
					<form name="redirect_options" method="post" action="{action-link}">
						<h4>Redirect Options - Current version {cur-ver}</h4>
						<table class="form-table">	
							<tr>		
							<td>Redirect Path: </td><td><input type="text" name="rd_opts[rd-path]" value="{$this->rd_opts['rd-path']}" size="60"> </td><td>(the path to redirect to when user not logged in<br />without http://)</td>
							</tr>
							<tr>
							<td>Activate Plugin:  </td><td><input type="checkbox" name="rd_opts[rd-active]" id="id_rd_active" value="true" $ck_rd_active /></td><td>Check to activate this plugin.</td>				
							</tr>
			</table>
							<!--//values are used in switch to determine processing-->
							<p class="submit">
							<button type="submit" class="button-primary tpg-settings-btn" name="func" value="updt_opts" />$btn_updt_opts_txt</button>
							&nbsp;&nbsp;
							
							</p>
								
						
					</form>
				</div>
			</div>
		</div>
	</div>
EOT;

		return $output;
	}	

}
?>
