<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary">添加会员</span>
</div>
<div class="page-content">

	<input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
	<div class="form-group">
		<label class="col-lg control-label">添加会员</label>
		<div class="col-sm-9 col-xs-12">
			<div class='input-group fixsingle-input-group'>
				<span class='input-group-addon'>我的上级</span>
				<select name="fid" id="fid" class="form-control tp_is_default" style="">
					<option value="-1">请选择上级</option>
					<?php  if(is_array($member_list)) { foreach($member_list as $v) { ?>
					<option value="<?php  echo $v['id'];?>"><?php  echo $v['mobile'];?></option>
					<?php  } } ?>
				</select>
			</div>
			<div class='input-group fixsingle-input-group' style="margin-top: 20px;">
				<span class='input-group-addon'>手机号码</span>
				<input type="number" name="mobile" id="mobile" class="form-control"
				       value=""/>
			</div>
			<div class='input-group fixsingle-input-group' style="margin-top: 20px;">
				<span class='input-group-addon'>密码</span>
				<input type="text" name="pwd" id="pwd" class="form-control"
				       value=""/>
			</div>
			<div class='input-group fixsingle-input-group' style="margin: 20px 0;">
				<span class='input-group-addon'>安全密码</span>
				<input type="text" name="safety" id="safety" class="form-control"
				       value=""/>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg control-label"></label>
		<div class="col-sm-9 col-xs-12">
			<input type="submit" value="保存" class="btn btn-primary submit"/>
		</div>
	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
	$('.submit').click(function () {
		var fid = $('#fid').val();
		var mobile = $('#mobile').val();
		var pwd = $('#pwd').val();
		var safety = $('#safety').val();
		if (!fid || !mobile || !pwd || !safety) {
			alert('请将信息填写完整');
          	return false;
		}
		$.ajax({
			type : 'post',
			url : '<?php  echo webUrl("member/list/reg")?>',
			data : {
				fid : fid,
				mobile : mobile,
				pwd : pwd,
				safety : safety
			},
			dataType : 'json',
			success : function (data) {
				if (data.status == 1) {
					alert(data.result.message);
					location.reload();
				} else {
					alert(data.result.message);
				}
			}
		});
	})
</script>
