<?
define("DBPersistent", false);
$DBType = "mysql";
#$DBHost = "localhost";
$DBHost = "localhost:31006";

#$DBLogin = "root";
#$DBLogin = "avoytenko_alba2";
#$DBLogin = "cl23943_alba";
#$DBLogin = "cl23943_alba";
$DBLogin = "cl23943_alba1";




#$DBPassword = "123456";
#$DBPassword = "AL1HXbyJ";
#$DBPassword = "AL1HXbyJ";
$DBPassword = "alba_1alba_1";



#$DBName = "alba";
#$DBName = "avoytenko_alba2";
#$DBName = "cl23943_alba";
#$DBName = "cl23943_alba";
$DBName = "cl23943_alba1";




$DBDebug = false;
$DBDebugToFile = false;
define("MYSQL_TABLE_TYPE", "INNODB");

@set_time_limit(60);

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_UTF", true);
define("BX_FILE_PERMISSIONS", 0644);
define("BX_DIR_PERMISSIONS", 0755);
@umask(~BX_DIR_PERMISSIONS);
@ini_set("memory_limit", "512M");
define("BX_DISABLE_INDEX_PAGE", true);
?>