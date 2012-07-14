## Automatic Theme & Plugin Updater for Self-Hosted Themes/Plugins

**Support This Developer: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SE9ZVJUS324UC**

*Any amount is always appreciated*


## General Info

For themes and plugins that can't be submitted to official WordPress repository, ie ... commercial themes/plugins/, non-gpl licensed, written for one client.

### Folder structure
* api (Folder to upload to server where updates will be housed)
	* .htaccess (set Options+Indexes to allow checking to work properly)
	* index.php (holds code used to check request for new versions)
	* download.php (one-time download key generating/validating file)
	* update (folder to hold all zip file updates for url masking)
	
* plugin (folder for adding plugin update checking)
	* test-plugin-update (simple plugin folder to show how update functions work)
		* test-plugin-update.php (example plugin that only checks for updates to server)

* theme (folder for theme update checking)
	* update.php (file that can be included from functions.php of theme to check for updates)
	
---------------	
	
**Important:**

*Change $api_url to your api server url in:*

    /plugin/test-plugin-update/test-plugin-update.php 
    /theme/update.php	

## Adding new versions

Edit the index.php under api folder on your server.  Commented thoroughly throughout with sections that need to be changed to reflect themes/plugins that are to be updated.  

## Adding additional themes/plugins

Simply create another $package array with the key of the new theme/plugin slug and add all the appropriate info.  When releasing the theme/plugin make sure that functions and variables are prefixed to prevent errors and allow multiple themes/plugins to be updated.

## Child theme support

Child themes are now supported.  If the theme being updated is meant to be a parent theme the standard theme/update.php from the theme file will work.  If the theme is a child theme of another theme comment out the parent theme section and uncomment the child theme section on the theme/update.php 

## Securing Download location

Now update file locations can be secured using a random download key generator.  A sql database is used to store random keys and a download.php file is used to check for keys and then allow download.  By default unsecured downloads are allowed.  To setup run the download_table.sql on an existing database or new database to create the download table, then edit the api/index.php and api/download.php and change the database info.  Then under the appropriate packages array remove the unsecured link and uncomment the secure link and edit the location.  The download.php also has the folder name at the top that needs to be edited to tell where the update files are stored.