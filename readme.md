## Automatic Theme & Plugin Updater for Self-Hosted Themes/Plugins

**Support This Developer: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SE9ZVJUS324UC**

*Any amount is always appreciated*

TEST

## General Info

For themes and plugins that can't be submitted to official WordPress repository, ie ... commercial themes/plugins/, non-gpl licensed, written for one client.

### Folder structure
* api (Folder to upload to server where updates will be housed)
    * .htaccess (set Options+Indexes to allow checking to work properly)
    * index.php (holds code used to check request for new versions)
    * packages.php (file containing all info about plugins and themes)
    * download.php (validates md5 key of date and package zip file)
    * update (folder to hold all zip file updates for url masking - protected by .htaccess to disallow file listings)


* update (default folder for holding theme and plugin zip files)
    * .htaccess (prevents indexing and viewing of any zip files in directory)


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

Edit the packages.php under api folder on your server.  Commented thoroughly throughout with sections that need to be changed to reflect themes/plugins that are to be updated.  

## Adding additional themes/plugins

Simply create another $package array with the key of the new theme/plugin slug and add all the appropriate info.  When releasing the theme/plugin make sure that functions and variables are prefixed to prevent errors and allow multiple themes/plugins to be updated.

## Child theme support

Child themes are now supported.  If the theme being updated is meant to be a parent theme the standard theme/update.php from the theme file will work.  If the theme is a child theme of another theme comment out the parent theme section and uncomment the child theme section on the theme/update.php 

## Securing Download location

Downloads are now always secured by a md5 hash of the package file_name and timestamp of current date.  When downloading file current timestamp and timestamp of previous day are compared to key received from update request, if either match zip file is passed, and file can be downloaded. 
