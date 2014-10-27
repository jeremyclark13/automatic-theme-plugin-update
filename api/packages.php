<?php
// Theme with update info
$packages['theme'] = array( //Replace theme with theme stylesheet slug that the update is for
    'versions' => array(
        '1.0' => array( //Array name should be set to current version of update
            'version' => '1.0', //Current version available
            'date' => '2010-04-10', //Date version was released
            //theme.zip is the same as file_name
            'package' => 'http://url_to_your_site/download.php?key=' . md5('theme.zip' . mktime(0,0,0,date("n"),date("j"),date("Y"))),
            //file_name is the name of the file in the update folder.
            'file_name' => 'theme.zip',	//File name of theme zip file
            'author' => 'Author Name', //Author of theme
            'name' => 'Theme Name', //Name of theme
            'requires' => '3.1', //Wordpress version required
            'tested' => '3.1', //WordPress version tested up to
            'screenshot_url' => 'http://url_to_your_theme_site/screenshot.png' //url of screenshot of theme
        )
    ),
    'info' => array(
        'url' => 'http://url_to_your_theme_site'  // Website devoted to theme if available
    )
);

// Plugin with update info
$packages['test-plugin-update'] = array( //Replace plugin with the plugin slug that updates will be checking for
    'versions' => array(
        '1.0' => array( //Array name should be set to current version of update
            'version' => '1.0', //Current version available
            'date' => '2010-04-10', //Date version was released
            'author' => 'Author Name', //Author name - can be linked using html - <a href="http://link-to-site.com">Author Name</a>
            'requires' => '2.8', // WP version required for plugin
            'tested' => '3.0.1', // WP version tested with
            'homepage' => 'http://your_plugin_website', // Site devoted to your plugin if available
            'downloaded' => '1000', // Number of times downloaded
            'external' => '', // Unused
            //plugin.zip is the same as file_name
            'package' => 'http://url_to_your_site/download.php?key=' . md5('plugin.zip' . mktime(0,0,0,date("n"),date("j"),date("Y"))),
            //file_name is the name of the file in the update folder.
            'file_name' => 'plugin.zip',
            'sections' => array(
                /* Plugin Info sections tabs.  Each key will be used as the title of the tab, value is the contents of tab.
                  Must be lowercase to function properly
                  HTML can be used in all sections below for formating.  Must be properly escaped ie a single quote would have to be \'
                  Screenshot section must use exteranl links for img tags.
                 */
                'description' => 'Description of Plugin', //Description Tab
                'installation' => 'Install Info', //Installaion Tab
                'screen shots' => 'Screen Shots', //Screen Shots
                'change log' => 'Change log', //Change Log Tab
                'faq' => 'FAQ', //FAQ Tab
                'other notes' => 'Other Notes'    //Other Notes Tab
            )
        )
    ),
    'info' => array(
        'url' => 'http://your_plugin_webiste'  // Site devoted to your plugin if available
    )
);
