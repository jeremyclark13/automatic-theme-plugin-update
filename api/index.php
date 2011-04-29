<?php 
/*******
 Original Plugin & Theme API by Kaspars Dambis (kaspars@konstruktors.com)
 Modified by Jeremy Clark http://clark-technet.com
*******/

//Kill magic quotes.  Can't unserialize POST variable otherwise
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

// Pull user agent set up by update.php in theme or plugin and continue if is set to Wordpress
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (stristr($user_agent, 'WordPress') == TRUE){

	// Theme with update info
	$packages['theme'] = array(			//Replace theme with theme stylesheet slug that the update is for
		'versions' => array(
			'1.0' => array(				//Array name should be set to current version of update
				'version' => '1.0', 	//Current version available
				'date' => '2010-04-10',	//Date version was released
				'package' => 'http://url_to_your_site/theme.zip'  // The zip file of the theme update
			)
		),
		'info' => array(
			'url' => 'http://url_to_your_theme_site'  // Website devoted to theme if available
		)
	);

	// Plugin with update info
	$packages['plugin'] = array(		//Replace plugin with the plugin slug that updates will be checking for
		'versions' => array(
			'1.0' => array(				//Array name should be set to current version of update
				'version' => '1.0',		//Current version available
				'date' => '2010-04-10',	//Date version was released
				'author' => 'Author Name',	//Author name - if set to wordpress.org username will be linked
				'requires' => '2.8',  // WP version required for plugin
				'tested' => '3.0.1',  // WP version tested with
				'homepage' => 'http://your_author_website',  // Your personal website
				'downloaded'=> '1000',  // Number of times downloaded
				'external' => 'http://your_plugin_website',  // Site devoted to your plugin if available
				'package' => 'http://url_to_your_site/plugin.zip',  // The zip file of the plugin update
				'sections' => array(
					/* Plugin Info sections tabs.  Each key will be used as the title of the tab, value is the contents of tab.
					 Must be lowercase to function properly
					*/
					'description' => 'Description of Plugin', 	//Description Tab
					'installation' => 'Install Info', 			//Installaion Tab
					'screen shots' => 'Screen Shots', 			//Screen Shots
					'change log' => 'Change log', 				//Change Log Tab
					'faq' => 'FAQ',								//FAQ Tab
					'other notes' => 'Other Notes'				//Other Notes Tab
					)
			)
		),
		'info' => array(
			'url' => 'http://your_plugin_webiste'  // Site devoted to your plugin if available
		)	
	);



	// Process API requests

	$action = $_POST['action'];
	$args = unserialize($_POST['request']);

	if (is_array($args))
		$args = array_to_object($args);

	$latest_package = array_shift($packages[$args->slug]['versions']);



	// basic_check

	if ($action == 'basic_check') {	
		$update_info = array_to_object($latest_package);
		$update_info->slug = $args->slug;
		
		if (version_compare($args->version, $latest_package['version'], '<'))
			$update_info->new_version = $update_info->version;
		
		print serialize($update_info);
	}


	// plugin_information

	if ($action == 'plugin_information') {	
		$data = new stdClass;
		
		$data->slug = $args->slug;
		$data->version = $latest_package['version'];
		$data->last_updated = $latest_package['date'];
		$data->download_link = $latest_package['package'];
		$data->author = $latest_package['author'];
		$data->external = $latest_package['external'];
		$data->requires = $latest_package['requires'];
		$data->tested = $latest_package['tested'];
		$data->homepage = $latest_package['homepage'];
		$data->downloaded = $latest_package['downloaded'];
		$data->sections = $latest_package['sections'];
		print serialize($data);
	}


	// theme_update

	if ($action == 'theme_update') {
		$update_info = array_to_object($latest_package);
		
		//$update_data = new stdClass;
		$update_data = array();
		$update_data['package'] = $update_info->package;	
		$update_data['new_version'] = $update_info->version;
		$update_data['url'] = $packages[$args->slug]['info']['url'];
			
		if (version_compare($args->version, $latest_package['version'], '<'))
			print serialize($update_data);	
	}



	function array_to_object($array = array()) {
		if (empty($array) || !is_array($array))
			return false;
			
		$data = new stdClass;
		foreach ($array as $akey => $aval)
				$data->{$akey} = $aval;
		return $data;
	}
}
?>
