<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">底部固定信息</span>
</div>
<div class="page-content">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-validate" role="form">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r"  value="goods.fixedInfo" />
        <!--<div class="page-toolbar">-->
            <!--<div class="col-sm-6">-->
                    <!--<span class="">-->
                        <?php if(cv('goods.label.add')) { ?>
                            <!--<a href="<?php  echo webUrl('goods/label/add')?>" class="btn btn-primary"><i class="fa fa-plus"></i> 添加新标签组</a>-->
                        <?php  } ?>
                        <!--<a class="btn btn-default" href="<?php  echo webUrl('goods/label/style')?>">设置样式</a>-->
                    <!--</span>-->
            <!--</div>-->
            <!--<div class="col-sm-6">-->
                <!--<div class="input-group">-->
                        <!--<span class="input-group-select">-->
                            <!--<select name="enabled" class='form-control'>-->
                                <!--<option value="" <?php  if($_GPC['enabled'] == '') { ?> selected<?php  } ?>>状态</option>-->
                                <!--<option value="1" <?php  if($_GPC['enabled']== '1') { ?> selected<?php  } ?>>启用</option>-->
                                <!--<option value="0" <?php  if($_GPC['enabled'] == '0') { ?> selected<?php  } ?>>禁用</option>-->
                            <!--</select>-->
                        <!--</span>-->
                    <!--<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词">-->
                    <!--<span class="input-group-btn">-->
                            <!--<button class="btn btn-primary" type="submit"> 搜索</button>-->
                        <!--</span>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->

        <div class="form-group">
            <label class="col-sm-2 control-label must">请选择底部信息图片</label>
            <div class="col-sm-9 col-xs-12 gimgs">
                <?php if( ce('goods' ,$item) ) { ?>
                <?php  echo tpl_form_field_multi_image2('fixedImages',$picList)?>
                <span class="help-block image-block">尺寸建议宽度为640，并保持图片大小一致，您可以拖动图片改变其显示顺序</span>
                <?php  } else { ?>
                <?php  if(is_array($picList)) { foreach($picList as $p) { ?>
                <a href='<?php  echo tomedia($p)?>' target='_blank'>
                    <img src="<?php  echo tomedia($p)?>" style='height:100px;border:1px solid #ccc;padding:1px;float:left;margin-right:5px;' />
                </a>
                <?php  } } ?>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">主商城状态</label>
            <div class="col-sm-9 col-xs-12">
                <label class="radio-inline">
                    <input type="radio" name="shopStatus" value="0" <?php  if($shopStatus == false) { ?>checked="true"<?php  } ?>> 关闭
                </label>
                <label class="radio-inline"><input type="radio" name="shopStatus" value="1" <?php  if($shopStatus == true) { ?>checked="true"<?php  } ?>>
                    开启
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">多商户状态</label>
            <div class="col-sm-9 col-xs-12">

                <label class="radio-inline">
                    <input type="radio" name="merchStatus" value="0" <?php  if($merchStatus == false) { ?>checked="true"<?php  } ?>> 关闭
                </label>
                <label class="radio-inline"><input type="radio" name="merchStatus" value="1" <?php  if($merchStatus == true) { ?>checked="true"<?php  } ?>>
                    开启
                </label>
                <div class="help-block"> 开启后，多商户商品详情底部也会显示固定信息</div>
            </div>

        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9 subtitle">
                <input type="submit" value="保存商品" class="btn btn-primary"/>
                <a class="btn btn-default" href="<?php  echo webUrl('goods',array('goodsfrom'=>$_GPC['goodsfrom'], 'page'=>$_GPC['page']))?>">返回列表</a>
            </div>
        </div>
    </form>
</div>
<script>

    window.onload = function () {
        var images = document.getElementsByClassName('multi-item');
        Object.keys(images).forEach(function (index) {
            images[index].children[0].style.width = 100 + 'px';
            images[index].children[0].style.height = 100 + 'px';
        })
    }

    require(['jquery.ui'],function(){
        $('.multi-img-details').sortable({scroll:'false'});
        $('.multi-img-details').sortable('option', 'scroll', false);
    })

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>