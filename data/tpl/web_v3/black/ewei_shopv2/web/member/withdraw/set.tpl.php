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

    <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>代理<small><?php  if(!empty($item['id'])) { ?>修改【<span class="text-info"><?php  echo $item['title'];?></span>】<?php  } ?><?php  if(!empty($merch_user['merchname'])) { ?>商户名称:【<span class="text-info"><?php  echo $merch_user['merchname'];?></span>】<?php  } ?></small>

    </span>

</div>

<div class="page-content">

    <form method="post" action="<?php  echo webUrl('member/withdraw/set')?>">
        <input type="hidden" id="set_id" name="set_id" value="<?php  echo $info['id'];?>" />
        <div class="tabs-container tab-goods">
            <div class="tabs-left">
                <ul class="nav nav-tabs" id="myTab">
                    <li  <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
                </ul>

                <div class="tab-content  ">
                    <div class="region-goods-details row">
                        <div class="region-goods-left col-sm-2">
                            设置提现金额
                        </div>
                        <div class="region-goods-right col-sm-10">
                            <div class="form-group dispatch_info" >
                                <label class="col-sm-2 control-label">最小金额</label>
                                <div class="col-sm-5">
                                    <input type="number" id="small_price" name="small_price" value="<?php  echo $info['small_price'];?>">
                                </div>
                            </div>
                            <div class="form-group dispatch_info" >
                                <label class="col-sm-2 control-label">最大金额</label>
                                <div class="col-sm-5">
                                   <input type="number" id="big_price" name="big_price" value="<?php  echo $info['big_price'];?>">
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
                <input type="submit" id="submit" class="btn btn-primary" value="保存">
                <a class="btn btn-default" href="<?php  echo webUrl('member/commissionscale')?>">返回列表</a>
            </div>
        </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

