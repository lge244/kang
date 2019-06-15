<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
		padding: 10px 20px;
	}
	.table > tbody>.trbody{
		border:1px solid #efefef;
	}
	.table > tbody>.trbody > td{
		border-top:none !important;
	}
	.trhead td {  background:#efefef;text-align: center}
	.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #f2f2f2;overflow: hidden; font-size:12px;}
	.trorder { background:#f8f8f8;border:1px solid #f2f2f2;text-align:left;}
	.ops { border-right:1px solid #f2f2f2; text-align: center;}
</style>

<div class="page-header">
	当前位置：<span class="text-primary"><?php  if($type=='0') { ?>兑换记录
		<?php  } else if($type=='1') { ?>抽奖记录
		<?php  } else if($type=='2') { ?>待发货
		<?php  } else if($type=='3') { ?>待收货
		<?php  } else if($type=='4') { ?>已完成
		<?php  } else if($type=='5') { ?>待核销
		<?php  } else if($type=='6') { ?>已核销
		<?php  } else if($type=='7') { ?>全部核销<?php  } ?>
		</span>
</div>
<div class="page-content">
	<form action="" method="get" class="form-horizontal table-search">
		<input type="hidden" name="c" value="site" />
		<input type="hidden" name="a" value="entry" />
		<input type="hidden" name="m" value="ewei_shopv2" />
		<input type="hidden" name="do" value="web" />
		<input type="hidden" name="r" value="<?php  echo $_GPC['r'];?>" />
		<input type="hidden" name="type" value="<?php  echo $type;?>" />
		<div class="page-toolbar m-b-sm m-t-sm">
			<div class="col-sm-5">
				<div class='input-group input-group-sm'>
					<?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'参与时间'),true);?>
				</div>
			</div>
			<div class="col-sm-6 pull-right">
				<div class="input-group">
					<div class="input-group-select">
						<select name='status' class="form-control input-sm select-md" style="width:100px;">
							<option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>
							<?php  if(empty($type)) { ?>
							<option value='2' <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?>>未兑换</option>
							<option value='3' <?php  if($_GPC['status']=='3') { ?>selected<?php  } ?> >已兑换</option>
							<?php  } else { ?>
							<option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>未中奖</option>
							<option value='2' <?php  if($_GPC['status']=='2') { ?>selected<?php  } ?> >已中奖</option>
							<option value='3' <?php  if($_GPC['status']=='3') { ?>selected<?php  } ?> >已兑换</option>
							<?php  } ?>
						</select>
					</div>
					<div class="input-group-select">
						<select name='searchfield' class='form-control  input-sm select-md' style="width:120px;">
							<option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
							<option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>
							<option value='logno' <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>活动编号</option>
							<option value='eno' <?php  if($_GPC['searchfield']=='eno') { ?>selected<?php  } ?>>兑换码</option>
							<option value='store' <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>兑换门店</option>
							<option value='express' <?php  if($_GPC['searchfield']=='express') { ?>selected<?php  } ?>>快递单号</option>
							<option value='goods' <?php  if($_GPC['searchfield']=='goods') { ?>selected<?php  } ?>>商品名称</option>
						</select>
					</div>
					<input type="text" class="form-control input-sm" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit"> 搜索</button>
						<?php if(cv('creditshop.log.export')) { ?>
							<button type="submit" name="export" value="1" class="btn btn-success">导出</button>
						<?php  } ?>
					</span>
				</div>
			</div>
		</div>
	</form>
	<?php  if(count($list)>0) { ?>
	<!--<table class="table table-responsive">-->
		<!--<thead>-->
			<!--<th>商品</th>-->
			<!--<th>类型</th>-->
			<!--<th>用户</th>-->
			<!--<th>消耗</th>-->
			<!--<th>状态</th>-->
			<!--<th>操作</th>-->
		<!--</thead>-->
	<!--</table>-->
	<table class="table table-responsive ">
		<thead>
			<tr style='background:#f8f8f8'>
				<th style="width: 250px;" >编号/商品</th>
				<th style="text-align: center">信息</th>
				<th style="text-align: center" >粉丝</th>
				<th style="text-align: center">会员</th>
				<th style="text-align: center">支付</th>
				<th style="text-align: center">消耗</th>
				<th style="text-align: center">操作</th>
				<th style="text-align: center">状态</th>
			</tr>
		</thead>
		<tbody>
			<?php  if(is_array($list)) { foreach($list as $row) { ?>
			<tr ><td colspan='8' style='height:20px;padding:0;border:none;'>&nbsp;</td></tr>
			<tr class='trorder' style='background:#f8f8f8'>
					<td colspan="8">
						<?php  echo $row['logno'];?>
						<?php  if($item['merchid'] == 0) { ?>
						<?php if(cv('creditshop.log.remarksaler')) { ?>
						<a class=''  data-toggle="ajaxModal" href="<?php  echo webUrl('creditshop/log/remarksaler', array('id' => $row['id']))?>" style="float: right">
							<?php  if(!empty($row['remarksaler'])) { ?>
							<i class="icow icow-flag-o" style="color: #df5254;display: inline-block;vertical-align: middle" title="  查看备注"></i>
							备注
							&nbsp
							<?php  } else { ?>
							<i class="icow icow-yibiaoji" style="color: #999;display: inline-block;vertical-align: middle" title="  添加备注" ></i>
							备注
							&nbsp
							<?php  } ?>
						</a>
						<?php  } ?>
						<?php  } ?>
					</td>
			</tr>
			<tr class="trbody">
				<td style="text-align: left"><img src="<?php  echo tomedia($row['thumb'])?>" style='width:30px;height:30px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" /> <?php  echo $row['title'];?>
					<span class="label label-danger"> x<?php  echo $row['goods_num'];?></span></td>
				<td style='line-height:22px;'>
					<?php  if($row['type']==1) { ?>
					<span class='label label-danger'>抽奖</span> <?php  } else { ?>
					<span class='label label-primary'>兑换</span> <?php  } ?>
					<br/>
					<?php  if($row['iscoupon']==0) { ?>
						<?php  if($row['isverify']==1) { ?>
							<span class='label label-warning' <?php  if(!empty($row[ 'storename'])) { ?>data-toggle='popover' data-placement='top' data-trigger='hover' data-content='<?php  echo $row['storename'];?>' data-title='兑换门店' <?php  } ?>>
								线下兑换 <?php  if(!empty($row['storename'])) { ?><i class='fa fa-question-circle'></i><?php  } ?>
							</span>
						<?php  } else { ?>
							<span class='label label-success'>快递配送</span>
						<?php  } ?>
					<?php  } else { ?>
						<?php  if($row['goodstype'] == 1) { ?>
							<span class='label label-success'>优惠券</span>
						<?php  } else if($row['goodstype'] == 2) { ?>
							<span class='label label-warning'>余额</span>
						<?php  } else if($row['goodstype'] == 3) { ?>
							<span class='label label-danger'>红包</span>
						<?php  } ?>
					<?php  } ?>
				</td>
				<td>
					<img class="radius50" src="<?php  echo tomedia($row['avatar'])?>" style='width:30px;height:30px;padding1px;border:1px solid #ccc'  onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/> <?php  echo $row['nickname'];?>
				</td>
				<td>
					<?php echo empty($row['realname'])?$row['mrealname']:$row['realname']?><br /> <?php echo empty($row['mobile'])?$row['mmobile']:$row['mobile']?>
				</td>
				<td>
					<?php  if($row['paytype']==-1) { ?>
					<span class='text-default'>无需支付</span>
					<?php  } else { ?>
					<?php  if($row['paytype']==0) { ?>
					<?php  if($row['paystatus']==0) { ?>
						<span><i class="icow icow-yue text-default"></i>余额未支付</span>
					<?php  } else { ?>
						<span><i class="icow icow-yue text-warning"></i>余额已支付</span>
					<?php  } ?>
					<?php  } else if($row['paytype']==1) { ?>
					<?php  if($row['paystatus']==0) { ?><span class='text-default'><i class="icow icow-weixin"></i>微信未支付</span><?php  } else { ?><span class='text-default'><i class="icow icow-weixin text-success"></i>微信已支付</span><?php  } ?>
					<?php  } else if($row['paytype']==2) { ?>
					<?php  if($row['paystatus']==0) { ?><span class='text-default'><i class="icow icow-zhifubao"></i>支付宝未支付</span><?php  } else { ?><span class='text-default'><i class="icow icow-zhifubao text-primary"></i>支付宝已支付</span><?php  } ?>
					<?php  } ?>
					<?php  } ?>
					<br/>
					<?php  if($row['dispatchstatus']==-1) { ?><span class='text-default'>无需运费</span>
					<?php  } else if($row['dispatchstatus']==0) { ?><span class='text-default'>未支付运费</span>
					<?php  } else if($row['dispatchstatus']==1) { ?><span class='text-primary'>已支付运费</span> <?php  } ?>
				</td>
				<td><?php  if($row['credit']>0) { ?>-<?php  echo $row['credit']*$row['goods_num']?>积分<br/><?php  } ?> <?php  if($row['money']>0 || $row['dispatch'] > 0) { ?> -<?php  echo number_format($row['money']*$row['goods_num'] + $row['dispatch'],2)?>现金 <?php  } ?>
				</td>
				<td>
					<?php if(cv('creditshop.log.detail')) { ?>
					<a class='text-primary' href="<?php  echo webUrl('creditshop/log/detail',array('id' => $row['id']));?>">
						查看详情
					</a>
					<?php  } ?>
					<?php  if($row['addressid']!=0 && $row['expresssn']>0) { ?>
					<br/>
					<a class='text-primary' data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $row['id'],'express'=>$row['express'],'expresssn'=>$row['expresssn']))?>">
						 物流信息
					</a>
					<?php  } ?>
					<?php if(cv('creditshop.log.exchange')) { ?>
					<?php  if($row['canexchange']) { ?>
					<br/>
					<a class='text-primary' data-toggle='ajaxModal' href="<?php  echo webUrl('creditshop/log/doexchange',array('id' => $row['id'],'type'=>$row['goodstype']));?>">
						兑换
					</a>
					<?php  } ?>
					<?php  } ?>
				</td>
				<td style='line-height:22px;'>
					<?php  if($row['status'] ==1 && $row['type']==1) { ?><span class='text-danger'>未中奖</span><?php  } ?>
					<?php  if($row['goodstype']==0) { ?>
						<?php  if($row['isverify']==1) { ?>
							<?php  if($row['status'] ==2) { ?><span class='text-warning'>待核销</span><?php  } ?>
							<?php  if($set['isreply'] == 1) { ?>
								<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='text-default'>等待评价</span><?php  } ?>
								<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='text-success'>追加评价</span><?php  } ?>
								<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='text-danger'>已完成</span><?php  } ?>
							<?php  } else { ?>
								<?php  if($row['status'] ==3) { ?><span class='text-danger'>已完成</span><?php  } ?>
							<?php  } ?>
						<?php  } else { ?>
							<?php  if($row['status'] ==2 && $row['addressid'] == 0 ) { ?><span class='text-warning'><?php  if($row['type']==0) { ?>已兑换<?php  } else { ?>已中奖<?php  } ?></span><?php  } ?>
							<?php  if($row['status'] ==2 && $row['addressid'] > 0 && $row['time_send'] == 0) { ?><span class='text-default'>待发货</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['time_send'] > 0 && $row['time_finish'] ==0 ) { ?><span class='text-success'>已发货</span><br>
							<a class="btn btn-primary btn-xs" data-toggle="ajaxPost" href="<?php  echo webUrl('creditshop/log/goodsfinish',array('id' => $row['id'],'merchid'=>$row['merchid']))?>">确认收货</a>
							<?php  } ?>
							<?php  if($set['isreply'] == 1) { ?>
								<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 0 ) { ?><span class='text-default'>等待评价</span><?php  } ?>
								<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 1 ) { ?><span class='text-success'>追加评价</span><?php  } ?>
								<?php  if($row['status'] ==3 && $row['time_finish'] > 0 && $row['iscomment'] == 2 ) { ?><span class='text-danger'>已完成</span><?php  } ?>
							<?php  } else { ?>
								<?php  if($row['status'] ==3 && $row['time_finish'] > 0) { ?><span class='text-danger'>已完成</span><?php  } ?>
							<?php  } ?>
						<?php  } ?>
					<?php  } else if($row['goodstype']==1) { ?>
						<?php  if($set['isreply'] == 1) { ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='text-default'>等待评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='text-success'>追加评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='text-danger'>已发放</span><?php  } ?>
						<?php  } else { ?>
							<?php  if($row['status'] ==3) { ?><span class='text-danger'>已发放</span><?php  } ?>
						<?php  } ?>
					<?php  } else if($row['goodstype']==2) { ?>
						<?php  if($set['isreply'] == 1) { ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='text-default'>等待评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='text-success'>追加评价</span><?php  } ?>
							<?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='text-danger'>已发放</span><?php  } ?>
						<?php  } else { ?>
							<?php  if($row['status'] ==3 ) { ?><span class='text-danger'>已发放<?php  } ?>
						 <?php  } ?>
					 <?php  } else if($row['goodstype']==3) { ?>
						 <?php  if($set['isreply'] == 1) { ?>
							 <?php  if($row['status'] ==3 && $row['iscomment'] == 0 ) { ?><span class='text-success'>等待评价</span><?php  } ?>
							 <?php  if($row['status'] ==3 && $row['iscomment'] == 1 ) { ?><span class='text-success'>追加评价</span><?php  } ?>
							 <?php  if($row['status'] ==3 && $row['iscomment'] == 2 ) { ?><span class='text-danger'>已发放</span><?php  } ?>
						 <?php  } else { ?>
							<?php  if($row['status'] ==3) { ?><span class='text-danger'>已发放</span><?php  } ?>
						 <?php  } ?>
					 <?php  } ?>
					<br/>
				</td>

			</tr>
			<?php  } } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8" class="text-right"><?php  echo $pager;?></td>
			</tr>
		</tfoot>
	</table>
	<?php  } else { ?>
	<div class='panel panel-default'>
		<div class='panel-body' style='text-align: center;padding:30px;'>
			暂时没有任何记录!
		</div>
		<?php  } ?>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>