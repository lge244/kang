<?php defined('IN_IA') or exit('Access Denied');?><!--
<link href="../addons/ewei_shopv2/plugin/app/static/css/base.css?v=20171118" rel="stylesheet" type="text/css"/>

<ul class="nav nav-tabs flex">
    <?php if(cv('app.page')) { ?>
        <li <?php  if($_W['controller']=='page' || $_W['controller']=='startadv') { ?>class="active"<?php  } ?>>
            <a href="<?php  echo webUrl('app/page')?>"><i>1</i> 页面设计</a>
        </li>
    <?php  } ?>
    <li <?php  if($_W['controller']=='goods') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('app/goods')?>"><i>2</i> 商品二维码</a>
    </li>
    <?php if(cv('app.tabbar')) { ?>
        <li <?php  if($_W['controller']=='tabbar') { ?>class="active"<?php  } ?>>
            <a href="<?php  echo webUrl('app/tabbar')?>"><i>3</i> 底部导航</a>
        </li>
    <?php  } ?>
    <?php if(cv('app.setting')) { ?>
        <li <?php  if($_W['controller']=='setting') { ?>class="active"<?php  } ?>>
            <a href="<?php  echo webUrl('app/setting')?>"><i>4</i> 小程序设置</a>
        </li>
    <?php  } ?>
    <?php if(cv('app.release')) { ?>
        <li <?php  if($_W['controller']=='release') { ?>class="active"<?php  } ?>>
            <a href="<?php  echo webUrl('app/release')?>"><i>5</i> 发布与审核</a>
        </li>
    <?php  } ?>
</ul>-->
