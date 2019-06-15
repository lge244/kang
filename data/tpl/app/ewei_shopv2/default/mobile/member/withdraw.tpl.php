<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='fui-page  fui-page-current member-cart-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">提现</div>
	</div>
	<div class='fui-content navbar cart-list' style="bottom: 4.9rem">
		<div id="cart_container">
			<form class='form-ajax'>
				<div class='fui-cell-group'>
					<div class='fui-cell'>
						<div class='fui-cell-label'>开户名</div>
						<div class='fui-cell-info c000'>
							<input type="text" id='name' name='name' placeholder="请填写开户名" class="fui-input"/>
						</div>
					</div>
					<div class='fui-cell'>
						<div class='fui-cell-label'>银行卡号</div>
						<div class='fui-cell-info c000'>
							<input type="number" id='number' name='number' placeholder="请填写银行卡号" class="fui-input"/>
						</div>
					</div>
					<div class='fui-cell'>
						<div class='fui-cell-label'>提现金额</div>
						<div class='fui-cell-info c000'>
							<input type="number" id='price' name='price' placeholder="请填写提现金额" class="fui-input"/>
						</div>
					</div>
					<div class='fui-cell'>
						<div class='fui-cell-label'>安全密码</div>
						<div class='fui-cell-info c000'>
							<input type="password" id='safety' name='safety' placeholder="请填写安全密码" class="fui-input"/>
						</div>
					</div>
					<a id="btn-submit" href="javascript:;" class='external btn btn-danger block' style="margin-top:1.25rem">确认提现</a>
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
			var price = $('#price').val();
			var number = $('#number').val();
			var name = $('#name').val();
			var safety = $('#safety').val();
			if (!price || !number || !name || !safety) {
				alert('请将信息填写完整');
				return false;
			}
			$.ajax({
				type : 'post',
				url : '<?php  echo mobileUrl("member/withdraw/withdraw")?>',
				data : {
					price : price,
					number : number,
					name : name,
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