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
}else if(APPMODE=='testing'){
	$active_group = "db_testing";
}
//To make Zend like Dyanimc


$active_record = TRUE;

$db['db_development']['hostname'] = "localhost";
$db['db_development']['username'] = "root";
$db['db_development']['password'] = "root12";
$db['db_development']['database'] = "pwhdatabase";
$db['db_development']['dbdriver'] = "mysql";
$db['db_development']['dbprefix'] = "";
$db['db_development']['pconnect'] = TRUE;
$db['db_development']['db_debug'] = TRUE;
$db['db_development']['cache_on'] = FALSE;
$db['db_development']['cachedir'] = "";
$db['db_development']['char_set'] = "utf8";
$db['db_development']['dbcollat'] = "utf8_general_ci";


$db['db_testing']['hostname'] = "localhost";
$db['db_testing']['username'] = "root";
$db['db_testing']['password'] = "root12";
$db['db_testing']['database'] = "pwhdatabase";
$db['db_testing']['dbdriver'] = "mysql";
$db['db_testing']['dbprefix'] = "";
$db['db_testing']['pconnect'] = TRUE;
$db['db_testing']['db_debug'] = TRUE;
$db['db_testing']['cache_on'] = FALSE;
$db['db_testing']['cachedir'] = "";
$db['db_testing']['char_set'] = "utf8";
$db['db_testing']['dbcollat'] = "utf8_general_ci";
/* End of file database.php */
/* Location: ./system/application/config/database.php */
