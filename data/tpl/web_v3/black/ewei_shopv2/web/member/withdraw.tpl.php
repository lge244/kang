<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">会员提现管理</span></div>
<div class="page-content">
	<form action="./index.php" method="get" class="form-horizontal form-search" role="form">
		<input type="hidden" name="c" value="site"/>
		<input type="hidden" name="a" value="entry"/>
		<input type="hidden" name="m" value="ewei_shopv2"/>
		<input type="hidden" name="do" value="web"/>
		<input type="hidden" name="r" value="member.level"/>
		<div class="page-toolbar">
			<div class="pull-right col-md-6">
				<div class="input-group">
					<input type="text" class=" form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>"
					       placeholder="请输入关键词">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit"> 搜索</button>
					</span>
				</div>
			</div>
		</div>
	</form>
	<?php  if(empty($list)) { ?>
	<div class="panel panel-default">
		<div class="panel-body empty-data">未查询到相关数据</div>
	</div>
	<?php  } else { ?>
	<form action="" method="post">
		<table class="table table-hover table-responsive">
			<thead>
			<tr>
				<th style="width:16%;">id</th>
				<th style="width:16%;">提现人</th>
				<th style="width:16%;">开户名</th>
				<th style="width:16%;">银行卡号</th>
				<th style="width:16%;">提现金额</th>
				<th style="width:16%;">提现时间</th>
				<th style="width: 20%;">操作</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($list)) { foreach($list as $v) { ?>
			<tr>
				<td id="withdraw_id"><?php  echo $v['id'];?></td>
				<td><?php  echo $mobile[$v['uid']];?></td>
				<td><?php  echo $v['name'];?></td>
				<td><?php  echo $v['number'];?></td>
				<td><?php  echo $v['price'];?></td>
				<td><?php  echo date('Y-m-d', $v['create_time'])?></td>
				<td>
					<?php if(cv('member.withdraw.pass' && $v['status'] == 1)) { ?>
					<a class="btn btn-op btn-operation" id="withdraw"
					   href="<?php  echo webUrl('member/withdraw/pass', ['id' => $v['id']])?>" title="提现审核">
						<span data-toggle="tooltip" data-placement="top" title="" data-original-title="提现审核">
							<i class="icow icow-31"></i>
						</span>
					</a>
					<?php  } ?>
					<?php if(cv('member.withdraw.del')) { ?>
					<a data-toggle='ajaxRemove'
					   href="<?php  echo webUrl('member/withdraw/del', array('id' => $v['id']))?>"
					   class="btn btn-op btn-operation" data-confirm='确认要删除此条记录吗?'>
					<span data-toggle="tooltip" data-placement="top" data-original-title="删除">
						<i class='icow icow-shanchu1'></i>
					</span>
					</a>
					<?php  } ?>
				</td>
			</tr>
			<?php  } } ?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="2">
				</td>
				<td colspan="4" style="text-align: right">
					<span class="pull-right" style="line-height: 28px;"></span>
					<?php  echo $pager;?>
				</td>
			</tr>
			</tfoot>
		</table>
	</form>
	<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>