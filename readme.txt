Automatic Theme & Plugin Updater for Self-Hosted Themes/Plugins

For themes and plugins that can't be submitted to official WordPress repository, ie ... commercial themes/plugins/, non-gpl licensed, written for one client.

Folder structure
- api 						(Folder to upload to server where updates will be housed)
-- .htaccess 				(set Options+Indexes to allow checking to work properly)
-- index.php 				(holds code used to check request for new versions)

- plugin					(folder for adding plugin update checking)
-- test-plugin-update 		(simple plugin folder to show how update functions work)
--- test-plugin-update.php	(example plugin that only checks for updates to server)

- theme						(folder for theme update checking)
-- update.php				(file that can be included from functions.php of theme to check for updates)


Adding new versions

Edit the index.php under api folder on your server.  Commented thoroughly throughout with sections that need to be changed to reflect themes/plugins that are to be updated.  

Important:

-- Change $api_url to your api server url in:
	/plugin/test-plugin-update/test-plugin-update.php 
	/theme/update.php

