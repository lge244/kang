<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="../addons/ewei_shopv2/plugin/app/static/css/web.css?v=20170911" rel="stylesheet" type="text/css"/>

<div class="page-header">
    当前位置：
    <span class="text-primary">底部导航</span>
</div>

<div class="page-content">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/_tab', TEMPLATE_INCLUDEPATH)) : (include template('app/_tab', TEMPLATE_INCLUDEPATH));?>


    <div class="row relative w840">
        <div class="alert alert-warning">提醒：底部导航改动后需重新提交微信审核，并且审核通过后才可生效。</div>

        <div class="diy-phone" data-merch="<?php  echo intval($_W['merchid'])?>">
            <div class="phone-head"></div>
            <div class="phone-body">
                <div class="phone-title black" id="page">页面标题</div>
                <div class="phone-main" id="phone">
                    <p style="text-align: center; line-height: 400px">loading...</p>
                </div>
            </div>
            <div class="phone-foot"></div>
        </div>

        <div class="diy-editor form-horizontal" id="diy-editor">
            <div class="editor-arrow"></div>
            <div class="inner"></div>
        </div>

        <div class="diy-menu">
            <div class="navs" id="navs"></div>
            <div class="action">
                <nav class="btn btn-default btn-sm" style="float: left; display: none" id="gotop"><i class="icon icon-top" style="font-size: 12px"></i> 返回顶部</nav>
                <nav class="btn btn-primary btn-sm btn-save" data-type="save">保存导航</nav>
            </div>
        </div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/tabbar/tpl/_template', TEMPLATE_INCLUDEPATH)) : (include template('app/tabbar/tpl/_template', TEMPLATE_INCLUDEPATH));?>
</div>

<script language="javascript">
    myrequire(['../../plugin/app/static/js/tabbar.min','tpl','web/biz'],function(modal,tpl){
        window.tpl = tpl;
        modal.init({tabbar: <?php  echo $tabbar;?>});
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->