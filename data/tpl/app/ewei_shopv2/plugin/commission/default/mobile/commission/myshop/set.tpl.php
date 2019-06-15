<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>
<style>
	.fui-cell-label{
		align-self: flex-start;
		line-height: normal;
	}
	/*.fui-uploader{*/
		/*background: #f5f5f5;*/
		/*border:0;*/
	/*}*/
	/*.fui-uploader.fui-uploader-sm:before {*/
	/*height: .7rem;*/
	/*width: 1px;*/
	/*}*/
	/*.fui-uploader.fui-uploader-sm:after {*/
	/*width: .7rem;*/
	/*height: 1px;*/
	/*}*/
	.fui-uploader.img-container-uploader.long:after{
		display: none;
	}
	.fui-uploader.img-container-uploader.long:before{
		display: none;
	}
</style>
<div class="fui-page fui-page-current">
	<div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title"><?php  echo $this->set['texts']['shop']?>设置</div>
    </div>
	<div class='fui-content'>
		<div class='fui-cell-group'>
			<div class='fui-cell'>
				<div class='fui-cell-label'>名称</div>
				<div class='fui-cell-info'><input type="text" class='fui-input' id="shopname" value="<?php  echo $shop['name'];?>" placeholder='填写默认为您的昵称'/></div>
			</div>
			<div class='fui-cell'>
				<div class='fui-cell-label'>图标</div>
				<div class='fui-cell-info'>
					<ul class="fui-images fui-images-sm" id="imageLogo"> 
						<?php  if(!empty($shop['logo'])) { ?>
						<li style="background-image:url(<?php  echo tomedia($shop['logo'])?>)" class="image image-sm" data-filename="<?php  echo $shop['logo'];?>">
							<span class="image-remove"><i class="icon icon-close"></i></span></li>
						<?php  } ?>


					</ul>
					
					<div class="fui-uploader fui-uploader-sm "  <?php  if(!empty($shop['logo'])) { ?>style='display:none'<?php  } ?>
						 data-max="1" 
						data-count="<?php  if(!empty($shop['logo'])) { ?>1<?php  } else { ?>0<?php  } ?>"> 
						 <input type="file" name='imgFile0' id='imgFile0'  <?php  if(!is_h5app() || (is_h5app() && is_ios())) { ?>multiple="" accept="image/*" <?php  } ?>>
					</div>
				 
					
				</div>
			</div>
			<div class='fui-cell' style="<?php  if(p('offic')) { ?>display:none;<?php  } else { ?>display:flex;<?php  } ?>">
				<div class='fui-cell-label'>店招</div>
				<div class='fui-cell-info'>
					
					<ul class="fui-images" id="imageImg"> 
						<?php  if(!empty($shop['img'])) { ?>
						<li style="background-image:url(<?php  echo tomedia($shop['img'])?>)" class="image long" data-filename="<?php  echo $shop['img'];?>" >
							<span class="image-remove"><i class="icon icon-close"></i></span></li>
						<?php  } ?>


					</ul>
				 
					<div class="fui-uploader img-container-uploader long"   <?php  if(!empty($shop['img'])) { ?>style='display:none'<?php  } ?>
						  data-max="1" 
						  data-long="1"
						  data-count="<?php  if(!empty($shop['img'])) { ?>1<?php  } else { ?>0<?php  } ?>"> 
						 <input type="file" name='imgFile1' id='imgFile1' <?php  if(!is_h5app() || (is_h5app() && is_ios())) { ?>multiple="" accept="image/*" <?php  } ?> >
					<span style="color: #D9D9D9;position: absolute;top: 50%;left: 15%;margin-top: -.35rem">点击此处上传图片</span>
					</div>
					 
					
				</div>
			</div>
			<div class='fui-cell'>
				<div class='fui-cell-label'>简介</div>
				<div class='fui-cell-info'><textarea id="desc" rows="3" placeholder="<?php  echo $this->set['texts']['shop']?>简介,分享你的<?php  echo $this->set['texts']['shop']?>"><?php  echo $shop['desc'];?></textarea></div>
			</div>
		</div>
		<div class='btn btn-warning block btn-submit mtop'>保存设置</div>
	</div>

	
	<script language='javascript'>
		require(['../addons/ewei_shopv2/plugin/commission/static/js/myshop.js'], function (modal) {
			modal.initSet();
	});
</script>

</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>