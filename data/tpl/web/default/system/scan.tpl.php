<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">木马查杀</div>
<ul class="we7-page-tab">
	<li <?php  if($do != 'display' && $do != 'view') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/scan');?>">木马查杀</a></li>
	<li <?php  if($do == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('system/scan', array('do' => 'display'));?>">查杀报告</a></li>
	<?php  if($do == 'view') { ?><li class="active"><a href="javascript:;">查看文件</a></li><?php  } ?>
</ul>
<?php  if($do == 'post') { ?>
<div class="clearfix">
	<form action="" method="post" class="form we7-form">

		<div class="form-group">
			<label class="col-sm-2 control-label">操作说明</label>
			<div class="col-sm-10">
				<div class="help-block">这里是说明</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">查杀目录</label>
			<div class="col-sm-10" style="">
				<?php  if(is_array($list)) { foreach($list as $index => $li) { ?>
				<div class="checkbox" style="margin-left:15px">
					<?php  if(is_dir($li)) { ?>
					<input type="checkbox" name="dir[]" id="dir[<?php  echo $index;?>]" value="<?php  echo $li;?>"/><label for="dir[<?php  echo $index;?>]"><i class="fa fa-folder-open"> </i> <?php  echo basename($li);?></label>
					<?php  } else { ?>
					<input type="checkbox" name="dir[]" id="dir[<?php  echo $index;?>]" value="<?php  echo $li;?>"/><label for="dir[<?php  echo $index;?>]"><i class="fa fa-file-code-o"> </i> <?php  echo basename($li);?></label>
					<?php  } ?>
				</div>
				<?php  } } ?>
			</div>
		</div>
<!--
		<div class="form-group">
			<label class="col-sm-2 col-lg-1 control-label">文件类型</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="file_type" value="<?php  echo $safe['file_type'];?>"/>
			</div>
		</div>
-->
		<div class="form-group">
			<label class="col-sm-2 control-label">特征函数</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="func" value="<?php  echo $safe['func'];?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">特征代码</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="code" value="<?php  echo $safe['code'];?>"/>
			</div>
		</div>
		
		<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			
	</form>
</div>
<?php  } else if($do == 'display') { ?>
<div class="clearfix">
			<table class="table we7-table table-hover site-list">
				<col width=""/>
				<col width="115px"/>
				<col width="115px"/>
				<col width="115px"/>
				<col width="105px"/>
				<col width="115px"/>
				<col width="115px"/>
				<col width="115px"/>
				<tr>
					<th>文件地址</th>
					<th>特征函数次数</th>
					<th>特征函数</th>
					<th>特征代码次数</th>
					<th>特征代码</th>
					<th>Zend encoded</th>
					<th>危险文件</th>
					<th class="text-right">操作</th>
				</tr>
				<?php  if(is_array($badfiles)) { foreach($badfiles as $k => $v) { ?>
					<tr>
						<td class="text-over" style="word-break: break-word;"><?php  echo $k;?></td>
						<td style="word-break: break-word;"><?php  echo $v['func_count'];?></td>
						<td style="word-break: break-word;"><span class="text-danger"><?php  echo $v['func_str'];?></span></td>
						<td style="word-break: break-word;"><?php  echo $v['code_count'];?></td>
						<td style="word-break: break-word;"><span class="text-danger"><?php  echo $v['code_str'];?></span></td>
						<td style="word-break: break-word;">
							<?php  if(isset($v['zend'])) { ?>
							<span class="label label-danger">Yes</span>
							<?php  } else { ?>
							No
							<?php  } ?>
						</td>
						<td style="word-break: break-word;">
							<?php  if(isset($v['danger'])) { ?>
							<span class="label label-danger">Yes</span>
							<?php  } else { ?>
							No
							<?php  } ?>
						</td>
						<td style="word-break: break-word;">
							<div class="link-group"><a href="<?php  echo url('system/scan/', array('do' => 'view', 'file' => authcode($k, 'ENCODE')));?>" title="查看">查看</a></div>
						</td>
					</tr>
				<?php  } } ?>
			</table>
</div>
<?php  } else if($do == 'view') { ?>
<div class="clearfix">
	<div class="panel panel-default">
		<div class="panel-heading">查看文件 <span class="text-danger">[<?php  echo $file_tmp;?>]</span></div>
		<div class="panel-body">
			<div style="margin-bottom: 15px">
				<?php  if($info['danger']) { ?>
				<span class="label label-primary">危险文件</span>
				<?php  } ?>
				<?php  if($info['func_count']) { ?>
				<span class="label label-danger">特征函数次数：<?php  echo $info['func_count'];?></span>
				<span class="label label-danger">特征函数：<?php  echo $info['func_str'];?></span>
				<?php  } ?>
				<?php  if($info['code_count']) { ?>
				<span class="label label-warning">特征代码次数：<?php  echo $info['code_count'];?></span>
				<span class="label label-warning">特征代码：<?php  echo $info['code_str'];?></span>
				<?php  } ?>
				<?php  if($info['zend']) { ?>
				<span class="label label-info">Zend encoded</span>
				<?php  } ?>
			</div>
			<textarea name="" id="" cols="30" rows="20" class="form-control"><?php  echo $data;?></textarea>
		</div>
	</div>
	<form action="" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-10">
				<a href="<?php  echo url('system/scan', array('do' => 'display'))?>" class="btn btn-primary col-lg-1"/>返回</a>
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
