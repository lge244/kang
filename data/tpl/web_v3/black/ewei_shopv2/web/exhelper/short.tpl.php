<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
	当前位置：<span class="text-primary">商品简称设置</span>
</div>

<div class="page-content">

	<form action="./index.php" method="get" class="form-horizontal" plugins="form">
		<input type="hidden" name="c" value="site"/>
		<input type="hidden" name="a" value="entry"/>
		<input type="hidden" name="m" value="ewei_shopv2"/>
		<input type="hidden" name="do" value="web"/>
		<input type="hidden" name="r" value="exhelper.short"/>
		<div class="page-toolbar">
			<div class="col-sm-6 pull-right">
				<span class="input-group">
					<span class="input-group-select">
						<select name='status' class='form-control'>
							<option value='' <?php  if($_GPC[ 'status']=='' ) { ?>selected<?php  } ?>>全部状态</option>
							<option value='1' <?php  if($_GPC[ 'status']=='1' ) { ?>selected<?php  } ?>>上架</option>
							<option value='0' <?php  if($_GPC[ 'status']=='0' ) { ?>selected<?php  } ?>>下架</option>
						</select>
					</span>
					<span class="input-group-select">
						<select name='shorttitle' class='form-control'>
							<option value='' <?php  if($_GPC[ 'shorttitle']=='' ) { ?>selected<?php  } ?>>全部简称</option>
							<option value='1' <?php  if($_GPC[ 'shorttitle']=='1' ) { ?>selected<?php  } ?>>已填写</option>
							<option value='2' <?php  if($_GPC[ 'shorttitle']=='2' ) { ?>selected<?php  } ?>>未填写</option>
						</select>
					</span>
					<input type="text" class="form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit"> 搜索</button> </span>
					</span>
				</span>
			</div>
		</div>
	</form>

	<?php  if(empty($list)) { ?>
		<div class="panel panel-default">
			<div class="panel-body empty-data">暂时没有任何商品</div>
		</div>
	<?php  } else { ?>
		<form action="" method="post">
			<?php if(cv('exhelper.short.edit')) { ?>
				<div class="page-table-header">
					<input type="checkbox">
					<div class="btn-group">
						<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('exhelper/short/edit')?>" data-confirm="确认要清除所选商品的简称吗?">清空简称</button>
					</div>
				</div>
			<?php  } ?>
			<table class="table table-hover table-responsive">
				<thead>
					<tr>
						<th style="width:25px;"></th>
						<th style="width: 80px">商品ID</th>
						<th>商品标题<?php if(cv('goods.view')) { ?>(点击查看商品)<?php  } ?></th>
						<th style="width:300px;">商品简称<?php if(cv('exhelper.short.edit')) { ?><small>(点击编辑)</small><?php  } ?></th>
						<th style="width:60px;">状态</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $row) { ?>
					<tr>
						<td>
							<input type='checkbox' value="<?php  echo $row['id'];?>" />
						</td>
						<td>
							<?php  echo $row['id'];?>
						</td>
						<td>
							<?php if(cv('goods.view')) { ?>
								<a href="<?php  echo webUrl('goods/edit', array('id'=>$row['id']))?>" target="_blank"><?php  echo $row['title'];?></a>
							<?php  } else { ?>
								<?php  echo $row['title'];?>
							<?php  } ?>
						</td>
						<td>
							<?php if(cv('exhelper.short.edit')) { ?>
								<a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('exhelper/short/edit',array('id'=>$row['id']))?>">
									<?php  if(empty($row['shorttitle'])) { ?>未填写<?php  } else { ?><?php  echo $row['shorttitle'];?><?php  } ?>
								</a>
							<?php  } else { ?>
								<?php  echo $row['shorttitle'];?>
							<?php  } ?>
						</td>
						<td>
							<?php  if($row['status']>0) { ?>
								<span class='label label-primary'>上架</span>
							<?php  } else { ?>
								<span class='label label-default'>下架</span>
							<?php  } ?>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
				<tfoot>
				<tr>
					<td>
						<input type='checkbox'/>
					</td>
					<td>
						<div class="btn-group">
							<?php if(cv('exhelper.short.edit')) { ?>
								<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('exhelper/short/edit')?>" data-confirm="确认要清除所选商品的简称吗?">清空简称</button>
							<?php  } ?>
						</div>
					</td>
					<td colspan="3" class="text-right"><?php  echo $pager;?></td>
				</tr>
				</tfoot>
			</table>
		</form>
	<?php  } ?>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->