<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
	当前位置：<span class="text-primary">发货人信息模板管理</span>
</div>

<div class="page-content">
	<form action="./index.php" method="get" class="form-horizontal" plugins="form">
		<input type="hidden" name="c" value="site" />
		<input type="hidden" name="a" value="entry" />
		<input type="hidden" name="m" value="ewei_shopv2" />
		<input type="hidden" name="do" value="web" />
		<input type="hidden" name="r" value="exhelper.sender" />
		<div class="page-toolbar">
			<div class="col-sm-4">
				<?php if(cv('exhelper.sender.add')) { ?>
					<a class='btn btn-primary btn-sm' href="<?php  echo webUrl('exhelper/sender/add')?>"><i class='fa fa-plus'></i> 添加模板</a>
				<?php  } ?>
			</div>

			<div class="col-sm-6 pull-right">
				<div class="input-group">
					<input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="输入发件人/发件人电话/发件人签名/发件邮编/发件省市区/发件地址进行搜索"> <span class="input-group-btn">
						<button class="btn btn-primary" type="submit"> 搜索</button> </span>
				</div>
			</div>
		</div>
	</form>

	<?php  if(empty($list)) { ?>
	<div class="panel panel-default">
		<div class="panel-body empty-data">暂时没有任何数据</div>
	</div>
	<?php  } else { ?>
		<form action="" method="post">
			<?php if(cv('exhelper.sender.delete')) { ?>
			<div class="page-table-header">
				<input type="checkbox">
				<div class="btn-group">
					<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('exhelper/sender/delete')?>"><i class='icow icow-shanchu1'></i> 删除</button>
				</div>
			</div>
			<?php  } ?>
			<table class="table table-hover table-responsive">
				<thead>
					<tr>
						<th style="width:30px;">

						</th>
						<th >发件人</th>
						<th>发件人电话</th>
						<th >发件人签名</th>
						<th>发件地邮编</th>
						<th>发件城市</th>
						<th>发件地址</th>
						<th style="width:70px;">默认</th>
						<th style="width:65px;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $row) { ?>
						<tr>
							<td>
								<input type='checkbox' value="<?php  echo $row['id'];?>" />
							</td>
							<td><?php  if(!empty($row['sendername'])) { ?><?php  echo $row['sendername'];?><?php  } else { ?>-<?php  } ?></td>
							<td><?php  if(!empty($row['sendertel'])) { ?><?php  echo $row['sendertel'];?><?php  } else { ?>-<?php  } ?></td>
							<td><?php  if(!empty($row['sendersign'])) { ?><?php  echo $row['sendersign'];?><?php  } else { ?>-<?php  } ?></td>
							<td><?php  if(!empty($row['sendercode'])) { ?><?php  echo $row['sendercode'];?><?php  } else { ?>-<?php  } ?></td>
							<td>
								<?php  if(!empty($row['sendercity'])) { ?>
									<?php  echo $row['sendercity'];?>
								<?php  } else if(!empty($row['province'])) { ?>
									<?php  echo $row['province'];?><?php  echo $row['city'];?><?php  echo $row['area'];?>
								<?php  } else { ?>
									-
								<?php  } ?>
							</td>
							<td><?php  if(!empty($row['senderaddress'])) { ?><?php  echo $row['senderaddress'];?><?php  } else { ?>-<?php  } ?></td>
							<td>
								<span class='defaults label <?php  if($row['isdefault']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
								  <?php if(cv('exhelper.sender.setdefault')) { ?>
									  data-toggle='ajaxSwitch'
									  data-confirm = "确认<?php  if($row['isdefault']==1) { ?>取消<?php  } else { ?>设为<?php  } ?>默认吗？"
									  data-switch-css='.defaults'
									  data-switch-other = 'true'
									  data-switch-value='<?php  echo $row['isdefault'];?>'
									  data-switch-value0='0|否|label label-default|<?php  echo webUrl('exhelper/sender/setdefault',array('isdefault'=>1,'id'=>$row['id']))?>'
									  data-switch-value1='1|是|label label-primary|<?php  echo webUrl('exhelper/sender/setdefault',array('isdefault'=>0,'id'=>$row['id']))?>'
									  style="cursor: pointer;"
								  <?php  } ?>
								><?php  if($row['isdefault']==1) { ?>是<?php  } else { ?>否<?php  } ?></span>
							</td>
							<td>
								<?php if(cv('exhelper.sender.view|exhelper.sender.edit')) { ?>
									<a class="btn btn-op btn-operation" href="<?php  echo webUrl('exhelper/sender/edit',array('id' => $row['id']))?>">
										<span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('exhelper.sender.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
											<?php if(cv('exhelper.sender.edit')) { ?>
											<i class="icow icow-bianji2"></i>
											<?php  } else { ?>
											<i class="icow icow-chakan-copy"></i>
											<?php  } ?>
										</span>
									</a>
								<?php  } ?>
								<?php if(cv('exhelper.sender.delete')) { ?>
									<a class="btn btn-op btn-operation" href="<?php  echo webUrl('exhelper/sender/delete',array('id' => $row['id']))?>">
										<span data-toggle="tooltip" data-placement="top" data-original-title="删除">
											<i class="icow icow-shanchu1"></i>
										</span>
									</a>
								<?php  } ?>
							</td>
						</tr>
					<?php  } } ?>
				</tbody>
				<tfoot>
				<tr>
					<td>
						<input type="checkbox" />
					</td>
					<td>
						<div class="btn-group">
							<?php if(cv('exhelper.sender.delete')) { ?>
							<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除选中内容吗?" data-href="<?php  echo webUrl('exhelper/sender/delete')?>"><i class='icow icow-shanchu1'></i> 删除</button>
							<?php  } ?>
						</div>
					</td>
					<td colspan="7" class="text-right"><?php  echo $pager;?></td>
				</tr>
				</tfoot>
			</table>
		</form>
	<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->