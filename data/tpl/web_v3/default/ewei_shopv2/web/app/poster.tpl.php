<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="../addons/ewei_shopv2/plugin/app/static/css/poster.css?v=20171031" rel="stylesheet" type="text/css"/>

<div class="page-header">
    当前位置：
    <span class="text-primary">分销海报</span>
</div>

<div class="page-content">
    <form action="./index.php">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="app.poster" />

        <div class="page-toolbar">
            <?php if(cv('app.poster.add')) { ?>
            <div class="col-sm-4">
                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('app/poster/add')?>"><i class="fa fa-plus"></i> 新建海报</a>
                <a class="btn btn-danger btn-sm" type="button" data-toggle="ajaxPost" data-confirm="确认要清空当前公众号海报缓存?" data-href="<?php  echo webUrl('app/poster/clear')?>"><i class="fa fa-trash"></i> 清除海报缓存</a>
            </div>
            <?php  } ?>

            <div class="col-sm-5 pull-right">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键字进行搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </div>
    </form>

    <div class="page-table-header"></div>

    <?php  if(empty($keyword)) { ?>
        <div class="form-group-title">已使用海报</div>
        <?php  if(empty($list_enabled)) { ?>
            <div class="panel panel-default">
                <div class="panel-body empty-data">未查询到已使用海报</div>
            </div>
        <?php  } else { ?>
            <div class="poster-list">
                    <?php  if(is_array($list_enabled)) { foreach($list_enabled as $item_enabled) { ?>
                        <div class="item" data-id="<?php  echo $item_enabled['id'];?>">
                            <span class="sup">已使用</span>
                            <div class="thumb">
                                <img src="<?php  echo $item_enabled['thumb'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/default-pic.jpg'" />
                            </div>
                            <div class="title"><?php  echo $item_enabled['title'];?></div>
                            <div class="oper">
                                <div class="pull-left">
                                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑" href="<?php  echo webUrl('app/poster/edit', array('id'=>$item_enabled['id']))?>">
                                        <i class="icow icow-bianji2"></i>
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <span class="btn btn-warning btn-xs btn-handle" data-action="disabled">取消使用</span>
                                </div>
                            </div>
                        </div>
                    <?php  } } ?>
            </div>
        <?php  } ?>
        <div class="form-group-title">海报仓库</div>
    <?php  } ?>

    <?php  if(empty($list)) { ?>
        <div class="panel panel-default">
            <div class="panel-body empty-data">未查询到<?php  if(empty($keyword)) { ?>未使用<?php  } ?>海报</div>
        </div>
    <?php  } else { ?>
        <div class="poster-list">
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <div class="item" data-id="<?php  echo $item['id'];?>">
                    <?php  if(!empty($item['status'])) { ?>
                        <span class="sup">已使用</span>
                    <?php  } ?>
                    <div class="thumb">
                        <img src="<?php  echo $item['thumb'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/default-pic.jpg'" />
                    </div>
                    <div class="title"><?php  echo $item['title'];?></div>
                    <div class="oper">
                        <div class="pull-left">
                            <?php if(cv('app.poster.edit')) { ?>
                                <a data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑" href="<?php  echo webUrl('app/poster/edit', array('id'=>$item['id']))?>">
                                    <i class="icow icow-bianji2"></i>
                                </a>
                            <?php  } ?>
                            <?php  if(empty($item['status'])) { ?>
                                <?php if(cv('app.poster.delete')) { ?>
                                    <span class="btn-delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                        <i class="icow icow-shanchu1"></i>
                                    </span>
                                <?php  } ?>
                            <?php  } ?>
                        </div>

                        <?php if(cv('app.poster.edit')) { ?>
                            <div class="pull-right">
                                <?php  if(empty($item['status'])) { ?>
                                    <span class="btn btn-primary btn-xs btn-handle" data-action="enabled">立即使用</span>
                                <?php  } else { ?>
                                    <span class="btn btn-warning btn-xs btn-handle" data-action="disabled">取消使用</span>
                                <?php  } ?>
                            </div>
                        <?php  } ?>
                    </div>
                </div>
            <?php  } } ?>
        </div>
    <?php  } ?>

</div>

<script language="javascript">
    myrequire(['../../plugin/app/static/js/poster','web/biz'],function(modal){
        modal.initList();
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->