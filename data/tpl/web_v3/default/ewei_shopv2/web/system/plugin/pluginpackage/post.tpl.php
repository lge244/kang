<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .multi-img-details .multi-item img{height:100px;}
    .input-group-date{padding:5px 0;}
    .input-group-remove{cursor: pointer;}
</style>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>套餐 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['title'];?>】<?php  } ?></small></span>
</div>

<div class="page-content">
    <div class="page-sub-toolbar">
        <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('system/plugin/package/add')?>"><i class='fa fa-plus'></i> 添加套餐</a>
    </div>
    <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class="tab-content ">
            <div class="tab-pane active">
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-lg control-label">排序</label>
                        <div class="col-sm-9 col-xs-12">
                            <input type='text' class='form-control' name='displayorder' value="<?php  echo $item['displayorder'];?>" />
                            <span class="help-block">数字越大，排名越靠前,如果为空，默认排序方式为创建时间</span>
                        </div>
                    </div>

                    <div class="form-group" id="product">
                        <label class="col-lg control-label">选择应用</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php  echo tpl_selector('pluginid',
                array('value'=>$item['name'],
                            'multi'=>1,
                            'type'=>'text',
                            'placeholder'=>'指定应用名称',
                            'buttontext'=>'选择应用',
                            'items'=>$plugin,
                            'nokeywords'=>1,
                            'autosearch'=>1,
                            'url'=>webUrl('system/plugin/pluginpackage/query')))?>
                            <div class="alert alert-warning" style="margin-top:10px;margin-bottom:0px;">注意：套餐最多可添加4个</div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg control-label">套餐缩略图</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php  echo tpl_form_field_image2('thumb', $item['thumb'])?>
                            <span class='help-block'>建议尺寸:180*180 , 请将所有幻灯片图片尺寸保持一致</span>
                        </div>
                    </div>

                    <div class="form-group cgt cgt-2">
                        <label class="col-lg control-label">设置价格</label>
                        <div class="col-sm-9 col-xs-12">
                            <div class="group-date-all">
                                <?php  if(!empty($item) && !empty($pluginData)) { ?>
                                <?php  if(is_array($pluginData)) { foreach($pluginData as $index => $row) { ?>
                                <div class="input-group fixmore-input-group input-group-date input-group-date<?php  echo $index;?>">
                                    <span class="input-group-addon">使用时长</span>
                                    <input type="number" class="form-control form-contro<?php  echo $index;?>" name="date[]" value="<?php  echo $row['date'];?>">
                                    <span class="input-group-addon">个月，价格</span>
                                    <input type="number" class="form-control form-contro<?php  echo $index;?>" name="price[]" value="<?php  echo $row['price'];?>">
                                    <span class="input-group-addon">元</span>
                                    <?php  if($index>0) { ?>
                                    <span class="input-group-addon input-group-remove"  onclick="removeDate(<?php  echo $index;?>)"><i class="fa fa-remove"></i></span>
                                    <?php  } else { ?>
                                    <?php  } ?>
                                </div>
                                <?php  } } ?>
                                <?php  } else { ?>
                                <div class="input-group input-group-date">
                                    <span class="input-group-addon">使用时长</span>
                                    <input type="number" class="form-control" name="date[]" value="<?php  echo $item['grant1'];?>">
                                    <span class="input-group-addon">个月，价格</span>
                                    <input type="number" class="form-control" name="price[]" value="<?php  echo $item['grant1'];?>">
                                    <span class="input-group-addon">元</span>
                                </div>
                                <?php  } ?>
                            </div>
                            <a class="btn btn-default" href="javascript:;" onclick="addDate()"><span class="fa fa-plus"></span> 新增价格</a>
                            <div class="alert alert-warning" style="margin-top:10px;margin-bottom:0px;">注意：使用时长设置为0，期限为永久。</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg control-label">套餐简介</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea name="desc" id="" class="form-control" cols="30" rows="5"><?php  echo $item['desc'];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg control-label">套餐详情</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php  echo tpl_ueditor('content',$item['content'], array('height'=>'200'))?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg control-label">是否推荐</label>
                        <div class="col-xs-12 col-sm-8">
                            <div class="input-group">
                                <label class="radio radio-inline">
                                    <input type="radio" name="rec" value="1" <?php  if(intval($item['rec']) ==1 ) { ?>checked="checked"<?php  } ?>> 是
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" name="rec" value="0" <?php  if(intval($item['rec']) ==0) { ?>checked="checked"<?php  } ?>> 否
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg control-label">状态</label>
                        <div class="col-xs-12 col-sm-8">
                            <div class="input-group">
                                <label class="radio radio-inline">
                                    <input type="radio" name="state" value="1" <?php  if(intval($item['state']) ==1 ) { ?>checked="checked"<?php  } ?>> 开启
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" name="state" value="0" <?php  if(intval($item['state']) ==0) { ?>checked="checked"<?php  } ?>> 关闭
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <input type="submit"  value="提交" class="btn btn-primary" />
                <a class="btn btn-default " href="<?php  echo webUrl('system/plugin/pluginpackage')?>">返回列表</a>
            </div>
        </div>

    </form>
</div>
<script type="text/javascript">
    $(function () {

    })
    function addDate() {
        var group = $(".input-group-date").length;
        var groupStr = '<div class="input-group fixmore-input-group input-group-date input-group-date'+group+'">' +
            '<span class="input-group-addon">使用时长</span>' +
            '<input type="number" class="form-control form-contro'+group+'" name="date[]" value="">' +
            '<span class="input-group-addon">个月，价格</span>' +
            '<input type="number" class="form-control form-contro'+group+'" name="price[]" value="">' +
            '<span class="input-group-addon">元</span>' +
            '<span class="input-group-addon input-group-remove"  onclick="removeDate('+group+')"><i class="fa fa-remove"></i></span>' +
            '</div>';
        $(".group-date-all").append(groupStr);
    }
    function removeDate(index) {
        $(".input-group-date"+index+"").remove()
    }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->