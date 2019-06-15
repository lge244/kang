<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    /*<?php  if(empty($item['livetype'])) { ?>
    .identity_livetype0{display: block;}
    .identity_livetype1{display: none;}
    .identity_livetype2{display: none;}
    .full_screen{display: none;}
    <?php  } ?>
    <?php  if($item['livetype']==1) { ?>
    .identity_livetype0{display: none;}
    .identity_livetype1{display: block;}
    .identity_livetype2{display: none;}
    <?php  } ?>
    <?php  if($item['livetype']==2) { ?>
    .identity_livetype0{display: none;}
    .identity_livetype1{display: none;}
    .identity_livetype2{display: block;}
    <?php  } ?>*/
    .region-goods-details {
        background: #fafafa;
        margin-bottom: 10px;
        padding: 0 10px;
    }
    .region-goods-left{
        text-align: center;
        font-weight: bold;
        color: #333;
        font-size: 14px;
        padding: 17px 0;
    }
    .region-goods-right{
        border-left: 3px solid #fff;
        padding: 10px 10px;
    }
    /*.submit_live{width:100%;background: #fff;border-top:1px solid #efefef;position: fixed;left:0;bottom:0;padding:20px 24%;z-index: 1000;}*/
</style>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(empty($item)) { ?>添加<?php  } else { ?>编辑<?php  } ?>直播间</span>
</div>

<div class="page-content">
    <div class="page-sub-toolbar">
        <?php if( ce('live.room' ,$item) ) { ?>
        <a href="<?php  echo webUrl('live/room/add')?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 添加新直播间</a>
        <?php  } ?>
    </div>
<form id="dataform" action="" method="post" class="form-horizontal form-validate">
    <input type='hidden' id='tab' name='tab' value="<?php  echo $_GPC['tab'];?>" />

    <ul class="nav nav-arrow-next nav-tabs" id="myTab">
        <li <?php  if($_GPC['tab']=='basic' || empty($_GPC['tab'])) { ?>class="active"<?php  } ?> ><a href="#tab_basic">直播间设置</a></li>
        <li class="tab_screen <?php  if($_GPC['tab']=='menu') { ?>active<?php  } ?>"  style="<?php  if($item['screen']==1) { ?>display:none;<?php  } ?>"><a href="#tab_menu">菜单设置</a></li>
        <li <?php  if($_GPC['tab']=='introduce') { ?>class="active"<?php  } ?>><a href="#tab_introduce">商品</a></li>
        <li <?php  if($_GPC['tab']=='discount') { ?>class="active"<?php  } ?>><a href="#tab_discount">优惠券</a></li>
        <li <?php  if($_GPC['tab']=='jurisdiction') { ?>class="active"<?php  } ?>><a href="#tab_jurisdiction">权限</a></li>
        <li <?php  if($_GPC['tab']=='share') { ?>class="active"<?php  } ?>><a href="#tab_share"><?php  if($isInvitation) { ?>邀请/<?php  } ?>公告/分享</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?php  if($_GPC['tab']=='basic' || empty($_GPC['tab'])) { ?>active<?php  } ?>" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/basic', TEMPLATE_INCLUDEPATH)) : (include template('live/room/basic', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='menu') { ?>active<?php  } ?>" id="tab_menu"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/menu', TEMPLATE_INCLUDEPATH)) : (include template('live/room/menu', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='introduce') { ?>active<?php  } ?>" id="tab_introduce"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/introduce', TEMPLATE_INCLUDEPATH)) : (include template('live/room/introduce', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='discount') { ?>active<?php  } ?>" id="tab_discount"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/discount', TEMPLATE_INCLUDEPATH)) : (include template('live/room/discount', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='jurisdiction') { ?>active<?php  } ?>" id="tab_jurisdiction"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/jurisdiction', TEMPLATE_INCLUDEPATH)) : (include template('live/room/jurisdiction', TEMPLATE_INCLUDEPATH));?></div>
        <div class="tab-pane <?php  if($_GPC['tab']=='share') { ?>active<?php  } ?>" id="tab_share"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live/room/share', TEMPLATE_INCLUDEPATH)) : (include template('live/room/share', TEMPLATE_INCLUDEPATH));?></div>
    </div>

    <div class="form-group"></div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('live.room' ,$item) ) { ?>
            <!--<div class="submit_live">-->
                <input type="submit"  value="提交" class="btn btn-primary" />
            <!--</div>-->
            <?php  } ?>
            <a href="<?php  echo webUrl('live/room')?>" class="btn btn-default">返回列表</a>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
    $(function () {
        $('#myTab a').off("click").on("click",function (e) {
            e.preventDefault();
            $('#myTab li').removeClass("active");
            $(this).parent("li").addClass("active");
            var href = $(this).attr('href');
            $("input[name=tab]").val(href);
            $(".tab-content .tab-pane").removeClass("active");
            $(""+href+"").addClass("active");
        });
        $("input[name=screen]").off("click").on("click",function () {
            var value = $(this).val();
            if(value>0){
                $(".tab_screen").hide();
            }else{
                $(".tab_screen").show();
            }
        });
        //将select通过clone方法保存
        var select= $("select[name=liveidentity]").find(".identity_livetype").clone();
        //删除所有的option
        $("select[name=liveidentity]").find(".identity_livetype").remove();
        var live_type = <?php echo empty($item['livetype'])?0:$item['livetype']?>;
        if(live_type==0){
            $("select[name=liveidentity]").append(select[0]);
            $("select[name=liveidentity]").append(select[1]);
        }else if(live_type==1){
            $("select[name=liveidentity]").append(select[2]);
            $("select[name=liveidentity]").append(select[3]);
            $("select[name=liveidentity]").append(select[4]);
            $("select[name=liveidentity]").append(select[5]);
            $("select[name=liveidentity]").append(select[6]);
        }else{
            $("select[name=liveidentity]").append(select[7]);
            $("select[name=liveidentity]").append(select[8]);
            $("select[name=liveidentity]").append(select[9]);
        }
        $("input[name='livetype']").off("click").on("click",function () {
            var livetype = $(this).val();
            $("select[name=liveidentity]").find("option:selected").prop("selected","false");
            $("select[name=liveidentity]").find(".identity_livetype").remove();
            //查找出需要显示的option并复制
            if(livetype==0){
                $("select[name=liveidentity]").append(select[0]);
                $("select[name=liveidentity]").append(select[1]);
            }else if(livetype==1){
                $("select[name=liveidentity]").append(select[2]);
                $("select[name=liveidentity]").append(select[3]);
                $("select[name=liveidentity]").append(select[4]);
                $("select[name=liveidentity]").append(select[5]);
                $("select[name=liveidentity]").append(select[6]);
                console.log($("select[name=liveidentity]").find(".identity_livetype"));
            }else{
                $("select[name=liveidentity]").append(select[7]);
                $("select[name=liveidentity]").append(select[8]);
                $("select[name=liveidentity]").append(select[9]);
            }
            /*$(".identity_livetype").hide();
            $(".identity_livetype"+livetype+"").show();
            */
            if(livetype==0){
                $(".full_screen").hide();
                $(".salf_screen input[name='screen']").prop("checked","true");
            }else{
                $(".full_screen").show();
            };

            if(livetype==2){
                $(".live-url").hide();
                $(".live-video").show();
            }else{
                $(".live-url").show();
                $(".live-video").hide();
            }
        });
        $("input[name=jurisdictionurl_show]").off("click").on("click",function () {
           if($(this).val() > 0){
                $(this).removeProp("checked",'fasle').val(0);
           }else{
               $(this).prop("checked",'true').val(1);
           }
        });
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>