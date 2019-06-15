<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='fui-page  fui-page-current member-cart-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">积分转出</div>
	</div>
	<div class='fui-content navbar cart-list' style="bottom: 4.9rem">
		<div id="cart_container">
			<form class='form-ajax'>
				<input type='hidden' id='addressid' value="<?php  echo $address['id'];?>"/>
				<div class='fui-cell-group'>
					<div class='fui-cell'>
						<div class='fui-cell-label'>接收人</div>
						<div class='fui-cell-info c000'>
							<input type="text" id='mobile' name='mobile' placeholder="请填写接收人手机号码" class="fui-input"/>
						</div>
					</div>
					<div class='fui-cell'>
						<div class='fui-cell-label'>转出数量</div>
						<div class='fui-cell-info c000'>
							<input type="number" id='price' name='price' placeholder="请填写转出数量" class="fui-input"/>
						</div>
					</div>
					<div class='fui-cell'>
						<div class='fui-cell-label'>安全密码</div>
						<div class='fui-cell-info c000'>
							<input type="password" id='safety' name='safety' placeholder="请填写安全密码" class="fui-input"/>
						</div>
					</div>
					<a id="btn-submit" href="javascript:;" class='external btn btn-danger block' style="margin-top:1.25rem">确认转出</a>
				</div>
			</form>
		</div>
	</div>
	<div id="footer_container"></div>
	<?php  $this->footerMenus()?>
</div>
<script>
	$(function () {
		$('#btn-submit').click(function () {
			var mobile = $('#mobile').val();
			var price = $('#price').val();
			var safety = $('#safety').val();
			var myreg = /^[1][3,4,5,7,8,9][0-9]{9}$/;
			if (!mobile || !price || !safety) {
				alert('请将信息填写完整');
				return false;
			}
			if (!myreg.test(mobile)) {
				alert('请填写正确的手机号码');
				return false;
			}
			$.ajax({
				type : 'post',
				url : '<?php  echo mobileUrl("member/transfer/transfer")?>',
				data : {
					mobile : mobile,
					price : price,
					safety : safety
				},
				dataType : 'json',
				success : function (data) {
					if (data.status) {
						alert(data.result.msg);
					} else {
						alert(data.result.msg);
					}
				}
			})
		})
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>