<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">基础设置</span>
</div>
<style>
    .grant-inline{height:40px;display: block;line-height: 40px;}
    .grant-inline input[type=radio]{margin-top:11px;}
    .input-group-date{padding:5px 0;}
    .input-group-remove{cursor: pointer;}
</style>
<div class="page-content">
    <form id="setform"  action="" method="post" class="form-horizontal form-validate">
        <input type="hidden" id="tab" name="tab" value="<?php  echo $_GPC['tab'];?>" />
        <ul class="nav nav-tabs" id="myTab">
            <li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本设置</a></li>
            <li <?php  if($_GPC['tab']=='payset') { ?>class="active"<?php  } ?>><a href="#tab_payset">支付设置</a></li>
            <li <?php  if($_GPC['tab']=='contact') { ?>class="active"<?php  } ?>><a href="#tab_contact">联系方式</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?>" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('system/plugin/pluginsetting/tab_basic', TEMPLATE_INCLUDEPATH)) : (include template('system/plugin/pluginsetting/tab_basic', TEMPLATE_INCLUDEPATH));?></div>
            <div class="tab-pane <?php  if($_GPC['tab']=='payset') { ?>active<?php  } ?>" id="tab_payset"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('system/plugin/pluginsetting/tab_payset', TEMPLATE_INCLUDEPATH)) : (include template('system/plugin/pluginsetting/tab_payset', TEMPLATE_INCLUDEPATH));?></div>
            <div class="tab-pane <?php  if($_GPC['tab']=='contact') { ?>active<?php  } ?>" id="tab_contact"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('system/plugin/pluginsetting/tab_contact', TEMPLATE_INCLUDEPATH)) : (include template('system/plugin/pluginsetting/tab_contact', TEMPLATE_INCLUDEPATH));?></div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9">
                <input type="submit" value="提交" class="btn btn-primary"/>
            </div>
        </div>
    </form>
</div>
<script language='javascript'>
    require(['bootstrap'],function(){
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $('#tab').val( $(this).attr('href').replace('#tab_',''));
            $(this).tab('show');
        })
    });
</script>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->