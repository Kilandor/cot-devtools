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
Hooks=header.first
[END_COT_EXT]
==================== */

if (!defined('COT_CODE')) { die('Wrong URL.'); }

//Load temporary settings
$devtools = isset($_COOKIE[$sys['site_id'].'_devtools']) ? unserialize(base64_decode($_COOKIE[$sys['site_id'].'_devtools'])) : array();
if(($sys['domain'] == 'localhost' || $sys['domain'] == '127.0.0.1') || $usr['isadmin'])
{
	$t = new XTemplate(cot_tplfile('devtools', 'plug'));
	$t->parse('DEVTOOLS');
	$devtoolbox = json_encode(preg_replace("#\r|\n#", "", $t->text('DEVTOOLS')));
	$out['head_head'] .= '<script type="text/javascript">$(document).ready(function () { $("body").prepend('.$devtoolbox.'); });</script>';
}

//Only do auto login if enabled, is guest, is local domain, and not session disabled
if($cfg['plugin']['devtools']['autologin'] && $usr['id'] == 0 && ($sys['domain'] == 'localhost' || $sys['domain'] == '127.0.0.1') && !$devtools['disable_autologin'])
{
	//Handle and setup auto-login
	$sql = $db->query("SELECT user_id, user_name, user_token, user_regdate, user_maingrp, user_banexpire, user_theme, user_scheme, user_lang, user_sid, user_sidtime, user_password FROM $db_users WHERE user_id = 1");
	if($row = $sql->fetch())
	{
		$rmdpass = $row['user_password'];
		$ruserid = $row['user_id'];
		$token = cot_unique(16);
		$sid = hash_hmac('sha256', $rmdpass . $row['user_sidtime'], $cfg['secret_key']);
		if (empty($row['user_sid']) || $row['user_sid'] != $sid
			|| $row['user_sidtime'] + $cfg['cookielifetime'] < $sys['now'])
		{
			// Generate new session identifier
			$sid = hash_hmac('sha256', $rmdpass . $sys['now'], $cfg['secret_key']);
			$update_sid = ", user_sid = " . $db->quote($sid) . ", user_sidtime = " . $sys['now'];
		}
		else
		{
			$update_sid = '';
		}

		$db->query("UPDATE $db_users SET user_lastip='{$usr['ip']}', user_lastlog = {$sys['now']}, user_logcount = user_logcount + 1, user_token = '$token' $update_lostpass $update_sid WHERE user_id={$row['user_id']}");

		// Hash the sid once more so it can't be faked even if you  know user_sid
		$sid = hash_hmac('sha1', $sid, $cfg['secret_key']);

		$u = base64_encode($ruserid.':'.$sid);

		cot_setcookie($sys['site_id'], $u, time()+$cfg['cookielifetime'], $cfg['cookiepath'], $cfg['cookiedomain'], $sys['secure'], true);
		unset($_SESSION[$sys['site_id']]);
		
		cot_redirect($sys['site_uri']);
	}
}