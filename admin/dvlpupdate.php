<?php
/**
 * Apply updates to Library during development.
 * Calls upgrade function with "ignore_errors" set so repeated SQL statements
 * won't cause functions to abort.
 *
 * Only updates from the previous released version.
 *
 * @copyright   Copyright (c) 2018 Lee Garner <lee@leegarner.com>
 * @package     library
 * @version     0.0.1
 * @license     http://opensource.org/licenses/gpl-2.0.php
 *              GNU Public License v2 or later
 * @filesource
 */

require_once '../../../lib-common.php';
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to access the Library Development Code Upgrade Routine without proper permissions.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    COM_404();
    exit;
}
// needed for set_version()
require_once Library\Config::getInstance()->get('pi_path') . '/upgrade.inc.php';
if (function_exists('CACHE_clear')) {
    CACHE_clear();
}

// Force the plugin version to the previous version and do the upgrade
$_PLUGIN_INFO['library']['pi_version'] = '0.0.1';
LIBRARY_do_upgrade(true);

// need to clear the template cache so do it here
if (function_exists('CACHE_clear')) {
    CACHE_clear();
}
header('Location: '.$_CONF['site_admin_url'].'/plugins.php?msg=600');
exit;

?>
