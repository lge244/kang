<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css"
      href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon-new.css?v=2017030302">
<style>
	#con {
		padding: 0 0.5rem;
	}

	.container2 li {
		border-radius: 0.2rem;
		padding: 0.2rem 0.3rem;
		margin: 0.5rem 0;
		background: #fff;
	}

	.container2 li div {
		font-size: 0.1rem;
		text-align: center;
		display: inline-block;
		margin-right: 0.5rem;
	}

	.container2 li div:last-child {
		margin-right: 0;
	}
	
	.container1 li  {
		border-radius: 0.2rem;
		padding: 0.2rem 0.3rem;
		margin: 0.5rem 0;
		background: #fff;
	}
</style>
<div class='fui-page  fui-page-current coupon-my-page'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">资金明细</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>
	<div class='fui-content'>
		<div class='fui-tab fui-tab-danger' id='cateTab'>
			<a class="active" id="tab1">奖金记录</a>
			<a id="tab2">转账记录</a>
		</div>
		<ul class="container1"  id="con">

		</ul>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>
	<script>
		function money_list () {
			$('.container1').html('');
			var status = 1;
			$('#tab1').attr('class', 'active');
			$('#tab2').removeAttr('class');
			$('#con').attr('class', 'container1');
			$.ajax({
				type: 'post',
				url: '<?php  echo mobileUrl("member/money/details")?>',
				data: {
					status: status
				},
				dataType: 'json',
				success: function (data) {
					var html = '';
					$.each(data.result.data, function (k, v) {
						html += "<li>" +
							"<div>奖金来源：" +
							"<sapn>" + v.uid + "</sapn>" +
							"</div>" +
							"<div>奖金金额：" +
							"<sapn>" + v.commission + "</sapn>" +
							"</div>" +
							"<div>奖金类型：" +
							"<sapn>" + v.status + "</sapn>" +
							"</div>" +
							"<div>结算时间：" +
							"<sapn>" + v.create_time + "</sapn>" +
							"</div>" +
							"</li>";
					});
					$('.container1').html(html);
				}
			});
		}
		$(function () {
			money_list();
			$('#tab1').click(function () {
				money_list();
				return;
			});
			$('#tab2').click(function () {
				$('.container2').html('');
				var status = 2;
				$(this).attr('class', 'active');
				$('#tab1').removeAttr('class');
				$('#con').attr('class', 'container2');
				$.ajax({
					type: 'post',
					url: '<?php  echo mobileUrl("member/money/details")?>',
					data: {
						status: status
					},
					dataType: 'json',
					success: function (data) {
						var html = '';
						$.each(data.result.data, function (k, v) {
							html += "<li>" +
								"<div>收款对象：<sapn>" + v.payee + "</sapn></div>" +
								"<div>转账金额：<sapn>" + v.price + "</sapn></div>" +
								"<div>转账时间：<sapn>" + v.create_time + "</sapn></div>" +
								"</li>";
						});
						$('.container2').html(html);
					}
				});
				return;
			});
		});
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
