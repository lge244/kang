<?php defined('IN_IA') or exit('Access Denied');?><div class="we7-page-title"></div>
<ul class="we7-page-tab">
	<!--<li <?php  if($type == 'system') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/thirdlogin', array('type' => 'system'))?>">系统登录</a></li>-->
	<li <?php  if($action == 'registerset') { ?>class="active"<?php  } ?>><a href="<?php  echo url('user/registerset');?>">注册设置</a></li>
	<li <?php  if($do == 'login') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/usersetting', array('do' => 'login'))?>">登录设置</a></li>
	<li <?php  if($do == 'binding') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/usersetting', array('do' => 'binding'))?>">绑定设置</a></li>
	<li <?php  if($type == 'wechat' || $type == 'qq') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/thirdlogin')?>">第三方登录配置</a></li>
</ul>