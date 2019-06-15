<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
    .input-group-sm.daterange .btn {padding: 4px 6px; border-radius: 0;}
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
         border: none;
        border-bottom: 1px solid #efefef;
    }
</style>

<div class='page-header'>当前位置：<span class="text-primary">签到/奖励记录 </span></div>

<div class="page-content">
<form action="./index.php" method="get" class="form-horizontal" plugins="form">
    <input type="hidden" name="c" value="site">
    <input type="hidden" name="a" value="entry">
    <input type="hidden" name="m" value="ewei_shopv2">
    <input type="hidden" name="do" value="web">
    <input type="hidden" name="r" value="sign.records">
    <div class="page-toolbar m-b-sm m-t-sm">
        <div class="col-sm-6">
            <?php  echo tpl_form_field_eweishop_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)), false);?>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group pull-right" >
                <div class="input-group-select">
                    <select class="form-control"  name="type">
                        <option value="-1" <?php  if($_GPC['type']==-1) { ?>selected<?php  } ?>>类型</option>
                        <option value="0" <?php  if($_GPC['type']=='0') { ?>selected<?php  } ?>>日常签到</option>
                        <option value="1" <?php  if($_GPC['type']==1) { ?>selected<?php  } ?>>连签奖励</option>
                        <option value="2" <?php  if($_GPC['type']==2) { ?>selected<?php  } ?>>总签奖励</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select class="form-control"name="searchtime">
                        <option value="" <?php  if(empty($_GPC['searchtime'])) { ?>selected<?php  } ?>>不按日期</option>
                        <option value="1" <?php  if(!empty($_GPC['searchtime'])) { ?>selected<?php  } ?>>搜索日期</option>
                    </select>
                </div>
                <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入昵称/手机号进行搜索"> <span class="input-group-btn">
                <button class="btn btn-primary" type="submit"> 搜索</button> </span>
            </div>
        </div>
    </div>
</form>
    <?php  if(count($list)>0) { ?>
<table class="table table-responsive ">
    <tbody>
        <tr class="trhead">
            <td style="width: 80px;">ID</td>
            <td >用户</td>
            <td >类型</td>
            <td >获得积分</td>
            <td>备注</td>
            <td style="width: 145px;">签到时间</td>
        </tr>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr class="trbody">
                    <td><?php  echo $item['id'];?></td>
                    <td>
                        <a href="<?php  echo webUrl('member/list/detail', array('id'=>$item['mid']))?>" target="_blank" title="<?php  echo $item['nickname'];?>">
                            <img class="radius50" src="<?php  echo tomedia($item['avatar'])?>" style="width:30px; height:30px; padding: 1px; border:1px solid #ccc;" onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> <?php  echo $item['nickname'];?>
                        </a>
                    </td>
                    <td>
                        <?php  if($item['type']==0) { ?>日常签到<?php  } else if($item['type']==1) { ?>连签奖励<?php  } else if($item['type']==2) { ?>总签奖励<?php  } ?>
                    </td>
                    <td><a class="text-primary" href="<?php  echo webUrl('finance/credit/credit1', array('keyword'=>$item['nickname']))?>" target="_blank">+<?php  echo $item['credit'];?></a></td>
                    <td data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="<?php  echo $item['log'];?>" data-original-title="" title=""><?php  echo $item['log'];?></td>
                    <td><?php  echo date('Y.m.d H:i:s', $item['time'])?></td>
                </tr>
            <?php  } } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-right"><?php  echo $pager;?></td>
        </tr>
    </tfoot>
</table>
    <?php  } else { ?>
    <div class='panel panel-default'>
        <div class='panel-body' style='text-align: center;padding:30px;'>
            未查询到相关记录!
        </div>
    </div>
    <?php  } ?>
</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>