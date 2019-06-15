<?php defined('IN_IA') or exit('Access Denied');?><?php  if($isInvitation) { ?>
<div class="region-goods-details row" style="margin-left:0;margin-right:0;">
	<div class="region-goods-left col-sm-2">
		邀请卡设置
	</div>
	<div class="region-goods-right col-sm-10">

		<div class="form-group">
			<label class="col-sm-2 control-label">选择邀请卡</label>
			<div class="col-sm-10 col-xs-12">
				<?php if( ce('live.room' ,$item) ) { ?>
				<select class='form-control' name='invitation_id'>
					<option value=''>请选择邀请卡</option>
					<?php  if(is_array($invitation)) { foreach($invitation as $row) { ?>
					<option value="<?php  echo $row['id'];?>" <?php  if($item['invitation_id']==$row['id']) { ?>selected<?php  } ?>><?php  echo $row['title'];?></option>
					<?php  } } ?>
				</select>
				<?php  } else { ?>
				<div class='form-control-static'>
					<?php  if(is_array($invitation)) { foreach($invitation as $row) { ?>
					<?php  if($item['invitation_id']==$row['id']) { ?><?php  echo $row['title'];?><?php  } ?>
					<?php  } } ?>
				</div>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<?php  } ?>
<div class="region-goods-details row" style="margin-left:0;margin-right:0;">
	<div class="region-goods-left col-sm-2">
		公告设置
	</div>
	<div class="region-goods-right col-sm-10">
		<div class="form-group">
			<label class="col-sm-2 control-label">公告内容</label>
			<div class="col-sm-10 col-xs-12">
				<?php if( ce('live.room' ,$item) ) { ?>
				<input type="text" name="notice" class="form-control" value="<?php  echo $item['notice'];?>" />
				<span class='help-block'>直播间滚动公告，不填则不显示</span>
				<?php  } else { ?>
				<input type="hidden" name="notice" value="<?php  echo $item['notice'];?>" />
				<div class='form-control-static'><?php  echo $item['notice'];?></div>
				<?php  } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">公告链接</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<div class="input-group form-group" style="margin: 0;">
					<input type="text" name="notice_url" class="form-control" value="<?php  echo $item['notice_url'];?>" id="notice_url" />
					<span data-input="#notice_url" data-toggle="selectUrl" data-full="true" class="input-group-addon btn btn-default">选择链接</span>
				</div>
				<span class='help-block'>点击公告跳转的链接，不填写则不跳转</span>
				<?php  } else { ?>
				<input type="hidden" name="notice_url" value="<?php  echo $item['notice_url'];?>" />
				<div class='form-control-static'><?php  echo $item['notice_url'];?></div>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<div class="region-goods-details row" style="margin-left:0;margin-right:0;">
	<div class="region-goods-left col-sm-2">
		分享设置
	</div>
	<div class="region-goods-right col-sm-10">
		<div class="form-group">
			<label class="col-sm-2 control-label">自定义二维码</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<?php  echo tpl_form_field_image2('followqrcode', $item['followqrcode']);?>
				<span class='help-block'>直播间关注二维码，如不填写则默认显示商城二维码</span>
				<?php  } else { ?>
				<input type="hidden" name="followqrcode" value="<?php  echo $item['followqrcode'];?>" />
				<div class='form-control-static'><?php  echo $item['followqrcode'];?></div>
				<?php  } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">分享标题</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<input type="text" name="share_title" class="form-control" value="<?php  echo $item['share_title'];?>" />
				<span class="help-block">不填写默认直播间名称</span>
				<?php  } else { ?>
				<input type="hidden" name="share_title" value="<?php  echo $item['share_title'];?>" />
				<div class='form-control-static'><?php  echo $item['share_title'];?></div>
				<?php  } ?>

			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">分享图标</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>

				<?php  echo tpl_form_field_image2('share_icon', $item['share_icon']);?>
				<span class="help-block">不选择默认直播间缩略图</span>
				<?php  } else { ?>
				<input type="hidden" name="share_icon" value="<?php  echo $item['share_icon'];?>" />
				<?php  if(!empty($item['share_icon'])) { ?>
				<a href="<?php  echo tomedia($item['share_icon'])?>" target='_blank'>
					<img src="<?php  echo tomedia($item['share_icon'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
				</a>
				<?php  } ?>
				<?php  } ?>

			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">分享描述</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<textarea name="share_desc" class="form-control" cols="60" rows="5"><?php  echo $item['share_desc'];?></textarea>
				<?php  } else { ?>
				<textarea style="display: none" name="share_desc" class="form-control" cols="60" rows="5"><?php  echo $item['share_desc'];?></textarea>
				<div class='form-control-static'><?php  echo $item['share_desc'];?></div>
				<?php  } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">分享链接</label>
			<div class="col-sm-10 col-xs-12">
				<?php if(cv('live.room.edit')) { ?>
				<div class="input-group form-group" style="margin: 0;">
					<input type="url" name="share_url" class="form-control" value="<?php  echo $item['share_url'];?>" id="shareurlselect" />
					<span data-input="#shareurlselect" data-toggle="selectUrl" data-full="true" class="input-group-addon btn btn-default">选择链接</span>
				</div>
				<span class='help-block'>用户分享出去的链接，默认为直播间链接</span>
				<?php  } else { ?>
				<input type="hidden" name="share_url" value="<?php  echo $item['share_url'];?>" />
				<div class='form-control-static'><?php  echo $item['share_url'];?></div>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->