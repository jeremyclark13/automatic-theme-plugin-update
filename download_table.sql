CREATE TABLE downloads (
	downloadkey varchar(32) NOT NULL unique,
	file varchar(255) NOT NULL default '',
	downloads int UNSIGNED NOT NULL default '0',
	expires int UNSIGNED NOT NULL default '0'
)
