
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
... mpla mpla mpla
*/
 
$active_group = 'default';
$active_record = TRUE;

require_once('../senhas.php');

global $db_host;
global $db_user;
global $db_pass;
global $db_name;
 
$db['default']['hostname'] = $db_host;
$db['default']['username'] = $db_user;
$db['default']['password'] = $db_pass;
$db['default']['database'] = $db_name;
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
$db['default']['failover'] = array();
 
/* End of file database.php */
/* Location: ./application/config/database.php */

?>
