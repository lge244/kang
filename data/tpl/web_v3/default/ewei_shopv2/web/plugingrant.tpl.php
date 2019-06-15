<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/plugingrant.css" rel="stylesheet">
<style>
	.page-content{width:auto;}
</style>
<div class="page-header">
    <!--<span class='pull-right'>
        <a class='btn btn-default btn-sm' href="<?php  echo webUrl('plugins')?>">返回我的应用</a>
    </span>-->
	当前位置：<span class="text-primary">授权应用中心</span>
</div>
<div class="page-content">
	<div class="plugingrant-container">
		<div class="plugingrant-container-adv">
			<div id="myCarousel" class="grant-banner carousel slide" data-ride="carousel">
				<!-- 轮播（Carousel）指标 -->
				<ol class="carousel-indicators">
					<?php  if(is_array($adv)) { foreach($adv as $index => $a) { ?>
					<li data-target="#myCarousel" data-slide-to="<?php  echo $index;?>" class="<?php  if($index==0) { ?>active<?php  } ?>"></li>
					<?php  } } ?>
				</ol>
				<!-- 轮播（Carousel）项目 -->
				<div class="carousel-inner" role="listbox">
					<?php  if(is_array($adv)) { foreach($adv as $index => $a) { ?>
					<div class="item <?php  if($index==0) { ?>active<?php  } ?>">
						<a href="<?php  echo $a['link'];?>"><img src="<?php  echo tomedia($a['thumb'])?>" width="100%" alt="<?php  echo $a['advname'];?>"></a>
					</div>
					<?php  } } ?>
				</div>
			</div>
		</div>
		<?php  if($package) { ?>
		<div class="plugingrant-container-package">
			<div class="plugingrant-container-package-head row">
				<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 plugin-package-head-left">超值套餐</span>
				<span class="col-lg-6 col-md-6 col-sm-6 col-xs-6 plugin-package-head-right">
					<!--<a href="javascript:void(0);" class="active">更多套餐>></a>-->
				</span>
			</div>
			<div class="plugingrant-container-package-list">
				<ul class="row plugin-package-ul">
					<?php  if(is_array($package)) { foreach($package as $row) { ?>
					<li class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="plugin-package-list">
							<h3><?php  echo $row['text'];?></h3>
							<p><?php  echo $row['desc'];?></p>
							<div class="plugin-package-list-plugin row">
								<?php  if(is_array($row['package'])) { foreach($row['package'] as $r) { ?>
								<span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
									<i>
										<img  onerror="this.src='<?php echo EWEI_SHOPV2_LOCAL;?>static/images/yingyong.png'" src="<?php echo empty($r['thumb'])?'../addons/ewei_shopv2/static/images/plugin.png': tomedia($r['thumb'])?>" alt="<?php  echo $r['name'];?>">
									</i>
								</span>
								<?php  } } ?>
							</div>
							<div class="plugin-package-list-buy">
								价格：<span>&yen;<?php  echo $row['data'][0]['price'];?></span><a href="<?php  echo webUrl('plugingrant/detail',array('id'=>$row['id'],'type'=>'package'))?>">立即购买</a>
							</div>
						</div>
					</li>
					<?php  } } ?>
				</ul>
			</div>
		</div>
		<?php  } ?>
		<?php  if(count($list)>0) { ?>
		<div class="plugingrant-container-plugin" name="sort">
			<div class="plugingrant-container-package-head row">
				<span class="col-lg-2 col-md-2 col-sm-2 col-xs-2 plugin-package-head-left">全部插件</span>
				<span class="col-lg-10 col-md-10 col-sm-10 col-xs-10 plugin-package-head-right">
					<form action="./index.php" method="get" class="form-horizontal table-search" role="form">
						<input type="hidden" name="c" value="site" />
						<input type="hidden" name="a" value="entry" />
						<input type="hidden" name="m" value="ewei_shopv2" />
						<input type="hidden" name="do" value="web" />
						<input type="hidden" name="r" value="plugingrant" />
					排序：<a href="<?php  echo webUrl('plugingrant',array('sort'=>'time'))?>#sort" name="sort" class="<?php  if($_GPC['sort']=='time') { ?>active<?php  } ?>">按时间</a><a href="<?php  echo webUrl('plugingrant',array('sort'=>'sale'))?>#sort" name="sort" class="<?php  if($_GPC['sort']=='sale') { ?>active<?php  } ?>">按销量</a>
						<label class="grant-screen-right-label">
							<input type="search" placeholder="输入您需要的应用名称" name="keyword" value="<?php  echo $_GPC['keyword'];?>">
							<button type="submit" class="glyphicon glyphicon-search" id="search"></button>
						</label>
					</form>
				</span>
			</div>
			<div class="plugingrant-container-plugin-list">
				<ul class="plugingrant-plugin-list-ul row">
					<?php  if(is_array($list)) { foreach($list as $row) { ?>
					<li class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<a href="<?php  echo webUrl('plugingrant/detail',array('id'=>$row['id'],'type'=>'plugin'))?>" class="plugingrant-plugin-list">
							<img src="<?php echo empty($row['thumb'])?'../addons/ewei_shopv2/static/images/yingyong.png': tomedia($row['thumb'])?>" alt="<?php  echo $row['name'];?>" onerror="this.src='<?php echo EWEI_SHOPV2_LOCAL;?>static/images/yingyong.png'">
							<h3><?php  if(!empty($row['name'])) { ?><?php  echo $row['name'];?><?php  } else { ?><?php  echo $row['pname'];?><?php  } ?></h3>
							<div class="plugingrant-plugin-list-price">
								价格：<span>&yen;<?php  echo $row['data'][0]['price'];?></span>
							</div>
						</a>
					</li>
					<?php  } } ?>
				</ul>
			</div>
		</div>
		<?php  } ?>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->