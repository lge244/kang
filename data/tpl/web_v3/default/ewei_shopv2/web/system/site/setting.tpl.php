<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">网站设置</span></div>

<div class="page-content">

    <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >
        <div class="form-group">
            <label class="col-lg control-label">案例展示banner</label>
            <div class="col-sm-9 col-xs-12">
                <?php if(cv('system.site')) { ?>
                <?php  echo tpl_form_field_image2('casebanner', $item['casebanner'])?>
                <span class='help-block'>建议尺寸:1920*340</span>
                <?php  } else { ?>
                <input type="hidden" name="casebanner" value="<?php  echo $item['casebanner'];?>"/>
                <?php  if(!empty($item['casebanner'])) { ?>
                <a href='<?php  echo tomedia($item['casebanner'])?>' target='_blank'>
                <img src="<?php  echo tomedia($item['casebanner'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                </a>
                <?php  } ?>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group" style="display: none;">
            <div class="col-lg control-label">案例展示banner背景颜色</div>
            <div class="col-sm-4">
                <div class="input-group input-group-sm">
                    <input class="form-control input-sm diy-bind color" name="background" value="<?php  echo $item['background'];?>" type="color" />
                    <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#000').trigger('propertychange')">重置</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label">联系我们</label>
            <div class="col-sm-9">
                <?php  echo tpl_ueditor('contact',$item['contact'])?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <?php if(cv('system.site')) { ?>
                <input type="submit" value="提交" class="btn btn-primary"  />
                <?php  } ?>
            </div>
        </div>

    </form>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->