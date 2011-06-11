Automatic Theme & Plugin Updater for Self-Hosted Themes/Plugins

For themes and plugins that can't be submitted to official WordPress repository, ie ... commercial themes/plugins/, non-gpl licensed, written for one client.

Folder structure
- api 						(Folder to upload to server where updates will be housed)
-- .htaccess 				(set Options+Indexes to allow checking to work properly)
-- index.php 				(holds code used to check request for new versions)
-- download.php				(one-time download key generating/validating file)

- plugin					(folder for adding plugin update checking)
-- test-plugin-update 		(simple plugin folder to show how update functions work)
--- test-plugin-update.php	(example plugin that only checks for updates to server)

- theme						(folder for theme update checking)
-- update.php				(file that can be included from functions.php of theme to check for updates)


Adding new versions

Edit the index.php under api folder on your server.  Commented thoroughly throughout with sections that need to be changed to reflect themes/plugins that are to be updated.  

Securing Download location

Now update file locations can be secured using a random download key generator.  A sql database is used to store random keys and a download.php file is used to check for keys and then allow download.  By default unsecured downloads are allowed.  To setup run the download_table.sql on an existing database or new database to create the download table, then edit the api/index.php and api/download.php and change the database info.  Then under the appropriate packages array remove the unsecured link and uncomment the secure link and edit the location.  The download.php also has the folder name at the top that needs to be edited to tell where the update files are stored.

Important:

-- Change $api_url to your api server url in:
	/plugin/test-plugin-update/test-plugin-update.php 
	/theme/update.php