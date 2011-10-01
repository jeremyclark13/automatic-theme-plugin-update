<?php 
/*******
 Original Plugin & Theme API by Kaspars Dambis (kaspars@konstruktors.com)
 Modified by Jeremy Clark http://clark-technet.com
*******/

// Pull user agent  
$user_agent = $_SERVER['HTTP_USER_AGENT'];


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



//Create one time download link to secure zip file location
if (stristr($user_agent, 'WordPress') == TRUE){
	/*
	*
	* Create Download Link
	* Jaocb Wyke
	* jacob@frozensheep.com
	*
	*/

/**********************************************
Uncomment Below Section to enable url masking
**********************************************/
/*REMOVE THIS LINE
	//Database Info
	$resDB = mysql_connect("DB_SERVER", "DB_USER", "DB_PASSWORD");
	mysql_select_db("DB_NAME", $resDB);

	function createKey(){
	//create a random key
	$strKey = md5(microtime());

	//check to make sure this key isnt already in use
	$resCheck = mysql_query("SELECT count(*) FROM downloads WHERE downloadkey = '{$strKey}' LIMIT 1");
	$arrCheck = mysql_fetch_assoc($resCheck);
	if($arrCheck['count(*)']){
		//key already in use
		return createKey();
	}else{
		//key is OK
		return $strKey;
	}
	}

	//get a unique download key
	$strKey = createKey();

	mysql_query("DELETE FROM downloads WHERE expires > '" .(time()+(60*60*24*14))."' ");

REMOVE THIS LINE*/ 
}


// Theme with update info
$packages['theme'] = array(			//Replace theme with theme stylesheet slug that the update is for
	'versions' => array(
		'1.0' => array(				//Array name should be set to current version of update
			'version' => '1.0', 	//Current version available
			'date' => '2010-04-10',	//Date version was released
			/*
			Remove line below if using one time download link 
			*/
			'package' => 'http://url_to_your_site/theme.zip',  // The zip file of the theme update
						/*
			Use below value if using the one time download link.  Point to location of download.php file on your server.
			*/
			//'package' => 'http://url_to_your_site/download.php?key=' . $strKey,
			//'file_name' => 'theme.zip',	//File name of theme zip file
			'author'  =>	'Author Name',		//Author of theme
			'name' =>		'Theme Name',		//Name of theme
			'requires'=>	'3.1',				//Wordpress version required
			'tested' =>		'3.1',				//WordPress version tested up to
			'screenshot_url'=>	'http://url_to_your_theme_site/screenshot.png'	//url of screenshot of theme
		)
	),
	'info' => array(
		'url' => 'http://url_to_your_theme_site'  // Website devoted to theme if available
	)
);

// Plugin with update info
$packages['plugin'] = array(				//Replace plugin with the plugin slug that updates will be checking for
	'versions' => array(
		'1.0' => array(						//Array name should be set to current version of update
			'version' => '1.0',				//Current version available
			'date' => '2010-04-10',			//Date version was released
			'author' => 'Author Name',		//Author name - can be linked using html - <a href="http://link-to-site.com">Author Name</a>
			'requires' => '2.8',  			// WP version required for plugin
			'tested' => '3.0.1',  			// WP version tested with
			'homepage' => 'http://your_plugin_website',  // Site devoted to your plugin if available
			'downloaded'=> '1000',  		// Number of times downloaded
			'external' => '',  				// Unused
			/*
			Use below value if using the one time download link.  Point to location of download.php file on your server.
			*/
			//'package' => 'http://url_to_your_site/download.php?key=' . $strKey,
			//'file_name' => 'plugin.zip',	//File name of theme zip file
			/*
			Remove line below if using one time download link 
			*/
			'package' => 'http://url_to_your_site/plugin.zip',  // The zip file of the plugin update

			
			'sections' => array(
				/* Plugin Info sections tabs.  Each key will be used as the title of the tab, value is the contents of tab.
				 Must be lowercase to function properly
				 HTML can be used in all sections below for formating.  Must be properly escaped ie a single quote would have to be \'
				 Screenshot section must use exteranl links for img tags.
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




if (stristr($user_agent, 'WordPress') == TRUE){

	// Process API requests
	$action = $_POST['action'];
	$args = unserialize($_POST['request']);

	if (is_array($args))
		$args = array_to_object($args);

	$latest_package = array_shift($packages[$args->slug]['versions']);
	
} else {
	/*
	An error message can be displayed to users who go directly to the update url
	*/

	echo 'Whoops, this page doesn\'t exist';
}


// basic_check

if ($action == 'basic_check') {	
	$update_info = array_to_object($latest_package);
	$update_info->slug = $args->slug;
	
	if (version_compare($args->version, $latest_package['version'], '<')){
		$update_info->new_version = $update_info->version;
		print serialize($update_info);
	}	
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
	//insert the download record into the database
	//Uncomment if using url masking
	//mysql_query("INSERT INTO downloads (downloadkey, file, expires) VALUES ('{$strKey}', '{$latest_package['file_name']}', '".(time()+(60*60*24*7))."')");
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
	//insert the download record into the database
	//Uncomment if using url masking
	//mysql_query("INSERT INTO downloads (downloadkey, file, expires) VALUES ('{$strKey}', '{$update_info->file_name}', '".(time()+(60*60*24*7))."')");		
	if (version_compare($args->version, $latest_package['version'], '<'))
		print serialize($update_data);	
}

if ($action == 'theme_information') {	
	$data = new stdClass;
	
	$data->slug = $args->slug;
	$data->name = $latest_package['name'];	
	$data->version = $latest_package['version'];
	$data->last_updated = $latest_package['date'];
	$data->download_link = $latest_package['package'];
	$data->author = $latest_package['author'];
	$data->requires = $latest_package['requires'];
	$data->tested = $latest_package['tested'];
	$data->screenshot_url = $latest_package['screenshot_url'];
	//insert the download record into the database
	//Uncomment if using url masking
	//mysql_query("INSERT INTO downloads (downloadkey, file, expires) VALUES ('{$strKey}', '{$latest_package['file_name']}', '".(time()+(60*60*24*7))."')");
	print serialize($data);
}

function array_to_object($array = array()) {
	if (empty($array) || !is_array($array))
		return false;
		
	$data = new stdClass;
	foreach ($array as $akey => $aval)
			$data->{$akey} = $aval;
	return $data;
}
?>