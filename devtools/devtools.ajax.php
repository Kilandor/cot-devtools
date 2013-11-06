<?PHP
/**
 * Developer Tools
 *
 * @package devtools
 * @version 1.0.0
 * @author Jason Booth (Kilandor)
 * @copyright Copyright (c) 2013 Jason Booth (Kilandor)
 * @license BSD
 */
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

if (!defined('COT_CODE')) { die('Wrong URL.'); }

//Prevent access when not on localhost to admins
if($sys['domain'] != 'localhost' && $sys['domain'] != '127.0.0.1')
	cot_block($usr['isadmin']);

$m = cot_import('m', 'G', 'ALP');
$a = cot_import('a', 'G', 'ALP');

if($m == 'autologin')
{
	if($a == 1)
		$devtools['disable_autologin'] = 1;
	else
		$devtools['disable_autologin'] = 0;
	echo '<div class="success">success</div>';
}
else
	exit;

cot_setcookie($sys['site_id'].'_devtools', base64_encode(serialize($devtools)), time()+$cfg['cookielifetime'], $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
