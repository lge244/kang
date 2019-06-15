<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .page-sub-toolbar{
        position: relative;
        width: 100%;
        padding-bottom: 15px;
        height: 45px;
        line-height: 1;
        vertical-align: middle;
        margin-bottom: 15px;
        border-bottom: 1px solid #efefef;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>商户 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['merchname'];?>】<?php  } ?></small>
 </span>
</div>

<div class="page-content">
    <div class="page-sub-toolbar">
        <span class='pull-left'>
		<?php if(cv('merch.group.add')) { ?>
			<a class="btn btn-primary btn-sm" href="<?php  echo webUrl('merch/user/add')?>">添加新商户</a>
		<?php  } ?>
	</span>
    </div>
<form id="setform"  <?php if( ce('merch.user' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate">

<input type="hidden" id="tab" name="tab" value="#tab_basic" />


<div class="tabs-container">
    <ul class="nav nav-tabs" id="myTab">
        <li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
        <li <?php  if($_GPC['tab']=='plugin') { ?>class="active"<?php  } ?>><a href="#tab_plugin">应用权限</a></li>
    </ul>
    <div class="tab-content ">
        <div class="tab-pane <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?>" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('merch/user/basic', TEMPLATE_INCLUDEPATH)) : (include template('merch/user/basic', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='plugin') { ?>active<?php  } ?>" id="tab_plugin"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('merch/user/plugin', TEMPLATE_INCLUDEPATH)) : (include template('merch/user/plugin', TEMPLATE_INCLUDEPATH));?></div>
    </div>
</div>

<?php if( ce('merch.user' ,$item) ) { ?>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <input type="submit"  value="提交" class="btn btn-primary" />
        <a class="btn btn-default" href="<?php  echo webUrl('merch/user')?>">返回列表</a>
    </div>
</div>
<?php  } ?>

</form>
</div>
<script language='javascript'>
    require(['bootstrap'], function () {
        $('#myTab a').click(function (e) {
            $('#tab').val($(this).attr('href'));
            e.preventDefault();
            $(this).tab('show');
        })
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--青岛易联互动网络科技有限公司-->