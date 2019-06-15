<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>
<div class="fui-page fui-page-current page-commission-down">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title"><?php  echo $this->set['texts']['mydown']?>(<?php  echo $total;?>)</div>
    </div>
    <div class="fui-content navbar">
        <?php  if($this->set['level']>=2) { ?>
        <div class="fui-tab fui-tab-warning" id="tab">
            <a class="active" href="javascript:void(0)" data-tab='level1'><?php  echo $this->set['texts']['c1']?>(<?php  echo $level1;?>)</a>
            <?php  if($this->set['level']>=2) { ?><a href="javascript:void(0)" data-tab='level2'><?php  echo $this->set['texts']['c2']?>(<?php  echo $level2;?>)</a><?php  } ?>
            <?php  if($this->set['level']>=3) { ?><a href="javascript:void(0)" data-tab='level3'><?php  echo $this->set['texts']['c3']?>(<?php  echo $level3;?>)</a><?php  } ?>
        </div>
        <?php  } ?>


        <div class="fui-title"><i class="icon icon-star text-danger"></i> 代表已成为<?php  echo $this->set['texts']['agent']?>的<?php  echo $this->set['texts']['down']?>
            
        </div>
        <div class="fui-list-group" id="container"></div>
        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

		<div class='content-empty' style='display:none;'>
			<!--<i class='icon icon-group'></i><br/>暂时没有任何数据-->
			<img src="<?php echo EWEI_SHOPV2_STATIC;?>images/nomeb.png" style="width: 6rem;margin-bottom: .5rem;"><br/><p style="color: #999;font-size: .75rem">暂时没有任何数据</p>
		</div>

    </div>


	<script id='tpl_commission_down_list' type='text/html'>
		<%each list as user%>
		<div class="fui-list" style="height: 3.5rem">
			<div class="fui-list-media">
				<%if user.avatar%>
				<img data-lazy="<%user.avatar%>" class="round" style="width:2rem;height:2rem">
				<%else%>
				<i class="icon icon-my2"></i>
				<%/if%>
			</div>
			<div class="fui-list-inner">
				<div class="row">
				      <div class="row-text" >
					  <%if user.isagent==1 && user.status==1%>
					  <i class="icon icon-star text-danger"></i>
					  <%/if%>
					  <%if user.nickname%><%user.nickname%><%else%>未获取<%/if%>
				      
				      </div>
				</div>
				<div class="subtitle">
				      <%if user.isagent==1 && user.status==1%>
				    成为<?php  echo $this->set['texts']['agent']?>时间: <%user.agenttime%>
				    <%else%>
				    注册时间:  <%user.createtime%>
				    <%/if%>
				    
				</div>
			</div>
			<div class="row-remark">
				<%if user.isagent==1 && user.status==1%>
				<p>+<%user.commission_total%></p>
				<p><%user.agentcount%>个成员</p>
				<%else%>
				<p>消费: <%user.moneycount%><?php  echo $this->set['texts']['yuan']?></p>
				<p><%user.ordercount%>个订单</p>
				<%/if%>
				
			</div>
		</div>
		<%/each%>
	</script>

	<script language='javascript'>
		require(['../addons/ewei_shopv2/plugin/commission/static/js/down.js'], function (modal) {
			modal.init({fromDetail: false});
		});
	</script>
</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->