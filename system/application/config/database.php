<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/
if (APPMODE=='development'){
	$active_group = "db_development";
}else if(APPMODE=='production'){
	$active_group = "db_production";
}
//To make Zend like Dyanimc


$active_record = TRUE;

$db['db_development']['hostname'] = "localhost";
$db['db_development']['username'] = "root";
$db['db_development']['password'] = "root12";
$db['db_development']['database'] = "nhrdevelopment";
$db['db_development']['dbdriver'] = "mysql";
$db['db_development']['dbprefix'] = "";
$db['db_development']['pconnect'] = TRUE;
$db['db_development']['db_debug'] = TRUE;
$db['db_development']['cache_on'] = FALSE;
$db['db_development']['cachedir'] = "";
$db['db_development']['char_set'] = "utf8";
$db['db_development']['dbcollat'] = "utf8_general_ci";


$db['db_production']['hostname'] = "localhost";
$db['db_production']['username'] = "hemophil_SPDnhr";
$db['db_production']['password'] = "NHR1234sdp";
$db['db_production']['database'] = "hemophil_nhrRegistry";
$db['db_production']['dbdriver'] = "mysql";
$db['db_production']['dbprefix'] = "";
$db['db_production']['pconnect'] = TRUE;
$db['db_production']['db_debug'] = TRUE;
$db['db_production']['cache_on'] = FALSE;
$db['db_production']['cachedir'] = "";
$db['db_production']['char_set'] = "utf8";
$db['db_production']['dbcollat'] = "utf8_general_ci";
/* End of file database.php */
/* Location: ./system/application/config/database.php */
