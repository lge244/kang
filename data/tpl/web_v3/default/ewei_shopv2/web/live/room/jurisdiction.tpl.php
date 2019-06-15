<?php defined('IN_IA') or exit('Access Denied');?><div class="region-goods-details row" style="margin-left:0;margin-right:0;">
	<div class="region-goods-left col-sm-2">
		权限设置
	</div>
	<div class="region-goods-right col-sm-10">
		<?php  if($iscommission) { ?>
		<div class="form-group">
			<label class="col-sm-2 control-label">分销商等级浏览权限</label>
			<div class="col-sm-10 col-xs-12 chks">
				<?php if(cv('live.room.edit')) { ?>
				<select name='showcommission[]' class='form-control select2' multiple=''>
					<?php  if(is_array($commission)) { foreach($commission as $level) { ?>
					<option value="<?php  echo $level['id'];?>" <?php  if(is_array($item['showcommission']) && in_array($level['id'], $item['showcommission'])) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
					<?php  } } ?>
				</select>
				<span class='help-block'>不设置默认全部分销商等级</span>

				<?php  } else { ?>
				<div class='form-control-static'>
					<?php  if($item['showcommission']=='') { ?>
					全部分销商等级
					<?php  } else { ?>
						<?php  if($item['showcommission']!='' && is_array($item['showcommission']) && in_array('0', $item['showcommission'])) { ?>
						<?php echo empty($shop['levelname'])?'默认等级':$shop['levelname']?>;
						<?php  } ?>
						<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
						<?php  if($item['showcommission']!='' && is_array($item['showcommission'])  && in_array($level['id'], $item['showcommission'])) { ?>
						<?php  echo $level['levelname'];?>;
						<?php  } ?>
						<?php  } } ?>
					<?php  } ?>
				</div>

				<?php  } ?>
			</div>
		</div>
		<?php  } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label">会员等级浏览权限</label>
			<div class="col-sm-10 col-xs-12 chks">
				<?php if(cv('live.room.edit')) { ?>
				<select name='showlevels[]' class='form-control select2' multiple=''>
					<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
					<option value="<?php  echo $level['id'];?>" <?php  if(is_array($item['showlevels']) && in_array($level['id'], $item['showlevels'])) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
					<?php  } } ?>
				</select>
				<span class='help-block'>不设置默认全部会员等级</span>

				<?php  } else { ?>
				<div class='form-control-static'>
					<?php  if($item['showlevels']=='') { ?>
					全部会员等级
					<?php  } else { ?>
					<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
					<?php  if($item['showlevels']!='' && is_array($item['showlevels'])  && in_array($level['id'], $item['showlevels'])) { ?>
					<?php  echo $level['levelname'];?>;
					<?php  } ?>
					<?php  } } ?>
					<?php  } ?>
				</div>

				<?php  } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">会员组浏览权限</label>
			<div class="col-sm-10 col-xs-12 chks" >
				<?php if(cv('live.room.edit')) { ?>
				<select name='showgroups[]' class='form-control select2' multiple=''>
					<option value="0"  <?php  if($item['showgroups']!='' && is_array($item['showgroups'])  && in_array('0', $item['showgroups'])) { ?>selected<?php  } ?>>无分组</option>
					<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
					<option value="<?php  echo $group['id'];?>" <?php  if(is_array($item['showgroups']) && in_array($group['id'], $item['showgroups'])) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
					<?php  } } ?>
				</select>
				<span class='help-block'>不设置默认全部会员分组</span>

				<?php  } else { ?>
				<div class='form-control-static'>
					<?php  if($item['showgroups']=='') { ?>
					全部会员等级
					<?php  } else { ?>
					<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
					<?php  if($item['showgroups']!='' && is_array($item['showgroups'])  && in_array($level['id'], $item['showgroups'])) { ?>
					<?php  echo $level['levelname'];?>;
					<?php  } ?>
					<?php  } } ?>
					<?php  } ?>
				</div>

				<?php  } ?>

			</div>
		</div>
	</div>
</div>
<div class="region-goods-details row" style="margin-left:0;margin-right:0;">
	<div class="region-goods-left col-sm-2">
		错误提醒
	</div>
	<div class="region-goods-right col-sm-10">
		<div class="form-group">
			<label class="col-sm-2 control-label">自定义链接</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<div class="input-group form-group" style="margin: 0;">
					<input type="text" name="jurisdiction_url" class="form-control" value="<?php  echo $item['jurisdiction_url'];?>" id="jurisdiction_url" />
					<span data-input="#jurisdiction_url" data-toggle="selectUrl" data-full="true" class="input-group-addon btn btn-default">选择链接</span>
					<span class="input-group-addon btn btn-default">
						<input type="checkbox" name="jurisdictionurl_show" <?php  if($item['jurisdictionurl_show'] > 0) { ?>checked<?php  } ?> value="<?php  if(empty($item['jurisdictionurl_show'])) { ?>0<?php  } else { ?>1<?php  } ?>" class=""> 显示
					</span>
				</div>
				<span class='help-block'>会员无权限浏览时选择跳转的链接</span>
				<?php  } else { ?>
				<input type="hidden" name="jurisdiction_url" value="<?php  echo $item['jurisdiction_url'];?>" />
				<div class='form-control-static'><?php  if($item['jurisdiction_url']>0) { ?>显示<?php  } else { ?>隐藏<?php  } ?></div>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->