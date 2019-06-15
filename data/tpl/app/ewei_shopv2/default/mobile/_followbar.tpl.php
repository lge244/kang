<?php defined('IN_IA') or exit('Access Denied');?>	
   	
   	<div class="follow_hidden" style="display: none;">
		<div class="verify-pop">
		    <div class="close"><i class="icon icon-roundclose"></i></div>
		    <div class="qrcode" style="height: 250px;">
				<img class="qrimg" src="" />
		    </div>
		    <div class="tip">
		    	<p class="text-white">长按识别二维码关注</p>
		    	<p class="text-warning"><?php  echo $_W['shopset']['shop']['name'];?></p> 
		    </div>
		</div>
	</div>
   	
   	<script>
   		$(function(){
   			var _followbtn = $("#followbtn");
   			var _followurl = _followbtn.data("followurl");
   			var _qrcode = _followbtn.data("qrcode");
   			_followbtn.click(function(){
   				if(_qrcode){
   					$('.verify-pop').find('.qrimg').attr('src', _qrcode).show();
   					follow_container = new FoxUIModal({
   						content: $(".follow_hidden").html(),
   						extraClass: "popup-modal",
   						maskClick:function(){
   							follow_container.close();
   						}
   					});
   					follow_container.show();
   					$('.verify-pop').find('.close').unbind('click').click(function () {
		        		follow_container.close();
		        	});
   				}
   				else if(_followurl){
					window.open(_followurl);
   				}
   				return;
   			});
   		});
   	</script>
   	

<!--913702023503242914-->