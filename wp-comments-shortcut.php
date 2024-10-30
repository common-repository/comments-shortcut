<?php
/*
Plugin Name: Comments shortcut
Plugin URI: http://blog.gekimoe.cn/chating/comments-shortcut-plugin-for-wordpress
Description: This plugin helps you to set a shortcut for the comments submiting
Author: JAY
Version: 1.0.2
Author URI: http://www.gekimoe.cn/
*/
?>
<?php
// Options
class CCMSC	// Class Comments Shortcut
{
	public $plugin_name	= 'WP Comments Shortcut';
	public $option_key = 'comments_shortcut_options';
	public $plugin_directory;
	public $plugin_path;
	public $plugin_options_path;
	public $option;
	
	function __construct()
	{
		// Initialize
		$this->plugin_directory 	= get_bloginfo('wpurl').'/'.PLUGINDIR.'/'.dirname(plugin_basename(__FILE__));
		$this->plugin_path 			= get_bloginfo('wpurl').'/'.PLUGINDIR.'/'.plugin_basename(__FILE__);
		$this->plugin_options_path 	= dirname(plugin_basename(__FILE__)) . '/options.php';
		$this->get_option();
		
		if (!is_array($this->option))
		{
			$this->option['textarea_id'] 	= 'comment';
			$this->option['submit_id'] 		= 'submit';
			$this->option['remind_text'] 	= ' (Ctrl + Enter)';
			$this->option['accelerate_key']	= 13; // Key 'Enter'
			
			add_option($this->option_key, $this->option);
		}
	}
	
	function clear_deprecate_options()
	{
		$deprecated_option_keys = 
		array(
			'comments_shortcut_textboxid', 
			'comments_shortcut_submitbtnid',
			'comments_shortcut_submitbtndesc',
			'comments_shortcut_accelerate_key'
		);
		
		$dumy = get_option($deprecated_option_keys['comments_shortcut_textboxid']);
		
		if (isset($dumy))
		{
			$this->option['textarea_id'] 	= get_option('comments_shortcut_textboxid');
			$this->option['submit_id'] 		= get_option('comments_shortcut_submitbtnid');
			$this->option['remind_text'] 	= get_option('comments_shortcut_submitbtndesc');
			$this->option['accelerate_key']	= get_option('comments_shortcut_accelerate_key');
		
			foreach ($deprecated_option_keys as $key)
			{
				delete_option($key);
			}
			
			$this->update_option();
		}
	}
		
	function get_option()
	{
		$this->option = get_option($this->option_key);
	}
	
	function update_option()
	{
		update_option($this->option_key, $this->option);
	}
	
	function save_option_changes()
	{
		$this->option['textarea_id']	= $_POST['textarea_id'];
		$this->option['submit_id']		= $_POST['submit_id'];
		$this->option['remind_text']	= $_POST['remind_text'];
		$this->option['accelerate_key']	= $_POST['accelerate_key'];
		$this->update_option();
		$this->get_option();
	}
	
	function hook_options_page()
	{
		add_options_page($this->plugin_name, $this->plugin_name, 10, $this->plugin_options_path);
	}
	
	function hook_comment_form()
	{
?>
	<script type="text/javascript">	
	//<![CDATA[
	document.getElementById('<?=$this->option['textarea_id']?>').onkeydown = function (moz_ev)
	{
		var ev = null;
		if (window.event){
			ev = window.event;
		}else{
			ev = moz_ev;
		}
		if (ev != null && ev.ctrlKey && ev.keyCode == <?=$this->option['accelerate_key']?>)
		{
			document.getElementById('<?=$this->option['submit_id']?>').click();
		}
	}
	document.getElementById('<?=$this->option['submit_id']?>').value += '<?=$this->option['remind_text']?>';
	//]]>
	</script>
<?php
	}
}

$cmsc_instance = new CCMSC();

add_action('comment_form',	array(&$cmsc_instance, 'hook_comment_form'));
add_action('admin_menu', 	array(&$cmsc_instance, 'hook_options_page'));

register_activation_hook( __FILE__, array(&$cmsc_instance, 'clear_deprecate_options'));
?>