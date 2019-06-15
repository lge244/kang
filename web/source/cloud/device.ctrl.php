<?php
/**
* [开吧授权系统 System] Copyright (c) 2018 sq.kai8.top
 */
defined('IN_IA') or exit('Access Denied');
if ($do == 'online') {
	header('Location: //sq.kai8.top/app/api.php?referrer='.$_W['setting']['site']['key']);
	exit;
} elseif ($do == 'offline') {
	header('Location: //sq.kai8.top/app/api.php?referrer='.$_W['setting']['site']['key'].'&standalone=1');
	exit;
} else {
}
template('cloud/device');
