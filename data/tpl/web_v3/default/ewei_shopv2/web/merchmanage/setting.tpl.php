<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-heading">
    <h2>基本设置</h2>
</div>

<form id="setform"  <?php if(cv('merchmanage.setting.save')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" >

    <div class="form-group">
        <label class="col-sm-2 control-label">直接链接</label>
        <div class="col-sm-9 col-xs-12">
            <div class="form-control-static">
                <a href='javascript:;' class="js-clip" title="点击复制链接" data-url="<?php  echo mobileUrl('merchmanage', array(), true)?>" ><?php  echo mobileUrl('merchmanage',array(),true)?></a>
                <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<img src='<?php  echo $qrcode;?>' width='130' alt='链接二维码'>" data-placement="auto right">
                    <i class="glyphicon glyphicon-qrcode"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="form-group-title"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">入口关键字</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <input type="text" class="form-control valid" name="keyword" value="<?php  echo $data['keyword'];?>" placeholder="请输入入口关键字，不填则不设置" />
            <?php  } else { ?>
                <div class="form-control-static"><?php  echo $data['keyword'];?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">入口标题</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <input type="text" class="form-control valid" name="title" value="<?php  echo $data['title'];?>" placeholder="请输入入口标题" />
            <?php  } else { ?>
                <div class="form-control-static"><?php  echo $data['title'];?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">入口图片</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <?php  echo tpl_form_field_image('thumb', $data['thumb'])?>
            <?php  } else { ?>
                <img width="150" class="img-responsive img-thumbnail" onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'" src="<?php  echo tomedia($data['thumb'])?>" />
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">入口介绍</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <textarea class="form-control" name="desc" placeholder="请输入入口介绍"><?php  echo $data['desc'];?></textarea>
            <?php  } else { ?>
                <div class="form-control-static"><?php  echo $data['desc'];?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">关键字状态</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <label class="radio-inline"><input type="radio" value="0" <?php  if(empty($data['status'])) { ?>checked<?php  } ?> name="status"> 禁用</label>
                <label class="radio-inline"><input type="radio" value="1" <?php  if(!empty($data['status'])) { ?>checked<?php  } ?> name="status"> 启用</label>
            <?php  } else { ?>
                <div class="form-control-static"><?php echo empty($data['status'])?"禁用":"启用"?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group-title"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">手机端后台开关</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('merchmanage.setting.save')) { ?>
                <label class="radio-inline"><input type="radio" value="0" <?php  if(empty($data['open'])) { ?>checked<?php  } ?> name="open"> 关闭</label>
                <label class="radio-inline"><input type="radio" value="1" <?php  if(!empty($data['open'])) { ?>checked<?php  } ?> name="open"> 开启</label>
            <?php  } else { ?>
                <div class="form-control-static"><?php echo empty($data['open'])?"关闭":"开启"?></div>
            <?php  } ?>
        </div>
    </div>

    <?php if(cv('merchmanage.setting.save')) { ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <input type="submit" class="btn btn-primary btn-sm" value="保存" />
            </div>
        </div>
    <?php  } ?>

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>