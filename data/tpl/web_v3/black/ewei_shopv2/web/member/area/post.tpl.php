<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<script type="text/javascript" src="../addons/ewei_shopv2/static/js/dist/area/cascade.js"></script>

<script type="text/javascript" src="../web/resource/js/lib/moment.js"></script>

<link rel="stylesheet" href="../web/resource/components/datetimepicker/jquery.datetimepicker.css">

<link rel="stylesheet" href="../web/resource/components/daterangepicker/daterangepicker.css">

<style type='text/css'>

    .tabs-container .form-group {overflow: hidden;}

    .tabs-container .tabs-left > .nav-tabs {}

    .tab-goods .nav li {float:left;}

    .spec_item_thumb {position: relative; width: 30px; height: 20px; padding: 0; border-left: none;}

    .spec_item_thumb i {position: absolute; top: -5px; right: -5px;}

    .multi-img-details, .multi-audio-details {margin-top:.5em;max-width: 700px; padding:0; }

    .multi-audio-details .multi-audio-item {width:155px; height: 40px; position:relative; float: left; margin-right: 5px;}

    .region-goods-details {

        background: #f8f8f8;

        margin-bottom: 10px;

        padding: 0 10px;

    }

    .region-goods-left{

        text-align: center;

        font-weight: bold;

        color: #333;

        font-size: 14px;

        padding: 20px 0;

    }

    .region-goods-right{

        border-left: 3px solid #fff;

        padding: 10px 10px;

    }

    <?php  if($item['type']==4) { ?>

    .type-4 {display: none;}

    <?php  } ?>

</style>

<div class="page-header">

    当前位置：

    <span class="text-primary">

    <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>角色<small><?php  if(!empty($item['id'])) { ?>修改【<span class="text-info"><?php  echo $item['title'];?></span>】<?php  } ?><?php  if(!empty($merch_user['merchname'])) { ?>商户名称:【<span class="text-info"><?php  echo $merch_user['merchname'];?></span>】<?php  } ?></small>

    </span>

</div>

<div class="page-content">

    <form method="post">

        <input type="hidden" id="tab" name="tab" value="#tab_basic" />

        <div class="tabs-container tab-goods">

            <div class="tabs-left">

                <ul class="nav nav-tabs" id="myTab">
                    <li  <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
                </ul>

                <div class="tab-content  ">
                    <div class="region-goods-details row">
                        <div class="region-goods-left col-sm-2">
                            代理角色
                        </div>
                        <div class="region-goods-right col-sm-10">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分成比例</label>
                                <div class="col-sm-5 input-group">
                                    <input type="number" name="proportion" id="proportion" class="form-control" value="<?php  echo $item['good_inte'];?>" />
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="form-group dispatch_info">
                                <label class="col-sm-2 control-label">等级选择</label>
                                <div class="col-sm-5">
                                    <select class="form-control tpl-category-parent select2" id="grade" name="grade"  data-rule-required="true" >
                                        <option value="1" >省级代理</option>
                                        <option value="2" >市级代理</option>
                                        <option value="3" >区域代理</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group dispatch_info">
                                <label class="col-sm-2 control-label">区域选择</label>
                                <div class="col-sm-5">
                                    <select class="form-control tpl-category-parent select2" id="address" name="address"  data-rule-required="true" >
                                        <option  >选择区域</option>
                                        <?php  if(is_array($city)) { foreach($city as $row) { ?>
                                        <option value="<?php  echo $row['id'];?>" ><?php  echo $row['REGION_NAME'];?></option>
                                        <?php  } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9 subtitle">
                <a id="submit" class="btn btn-primary">保存管理</a>
                <a class="btn btn-default" href="<?php  echo webUrl('admins')?>">返回列表</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $('#grade').change(function(){
       var id = $(this).val();
       $.post("<?php  echo webUrl('member/area/getAddress')?>",{id:id},function (res) {
           if (res.code == 0){
               $('#address ').empty();
               $('#address ').append(res.city_list);
           }
       },'json')
    });


    $('#submit').click(function () {
        var proportion = $('#proportion').val();
        var address = $("#address option:selected").html();
        if (proportion == '') {
            tip.msgbox.err('请填写分成比例!');
            return false;
        }

        $.post("<?php  echo webUrl('member/area/post')?>", {
            proportion:proportion,
            address:address,
        }, function (res) {
            if (res.code == 0) {
                tip.msgbox.suc(res.msg);
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg);
            }
        },'json')


    });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

