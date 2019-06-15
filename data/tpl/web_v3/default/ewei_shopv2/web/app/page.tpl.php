<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .modal{
        display: none;
        opacity: 1;
        width: 540px;
        min-height: 260px;
        top: 50%;
        left: 50%;
        margin-top: -130px;
        margin-left: -270px;
    }
    .modal-body{
        background: #fff;
        justify-content: center;
        -webkit-justify-content: center;
        padding: 0;
        overflow: hidden;
        padding-top:30px;
    }
    .modal-body .diy-item{
        width:104px;
        margin: 30px 14px;
        margin-top: 0;
        text-align: center;
        padding: 16px 0 ;
        border-radius: 4px;
        float: left;
    }
    .modal-body .diy-item p{
        line-height: 44px;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 12px;
    }
    .modal-body .diy-item a{
        color: inherit;
        display: inline-block;
        width:77px;
        height:28px;
        border:1px solid;
        border-color: inherit;
        line-height: 26px;
    }
    .wid{
        width: 76px;
        white-space: nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
    }
   /* .dropdown-menu {
        width: 120px !important;
        background: none; border: none; box-shadow: none; padding: 0;
        left: 60px;
        margin-left: -60px;
    }
    .dropdown-menu li:last-child span {margin: 0}
    .dropdown-menu li {padding-top: 5px; width: 120px;}
    .dropdown-menu li span {background: #fff; width: 100%;}
    .create .fa-caret-up {display: none}
    .create.open .fa-caret-down {display: none}
    .create.open .fa-caret-up {display: inline-block}*/
</style>

<div class="page-header">
    当前位置：
    <span class="text-primary">页面设计</span>
</div>

<div class="page-content">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/_tab', TEMPLATE_INCLUDEPATH)) : (include template('app/_tab', TEMPLATE_INCLUDEPATH));?>

    <form action="./index.php">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="app.page" />

        <div class="page-toolbar">
            <?php if(cv('app.page.add')) { ?>
                <div class="col-sm-4 create">
                    <a href="javascript:void(0);" class="btn btn-w-m btn-primary btn-create"><i class="fa fa-plus"></i> 立即创建</a>
                </div>
            <?php  } ?>

            <div class="col-sm-5 pull-right">
                <div class="input-group">
                    <span class="input-group-select">
                        <select name="type" class="form-control  input-sm select2" style="width:120px;">
                            <option value="">页面类型</option>
                            <option value="2" <?php  if($_GPC['type']==2) { ?>selected<?php  } ?>>商城首页</option>
                            <option value="20" <?php  if($_GPC['type']==20) { ?>selected<?php  } ?>>自定义页面</option>
                            <option value="3" <?php  if($_GPC['type']==3) { ?>selected<?php  } ?>>会员中心页</option>
                            <option value="4" <?php  if($_GPC['type']==4) { ?>selected<?php  } ?>>商品详情页</option>
                        </select>
                    </span>
                    <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入页面标题关键字进行搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </div>
        <ul class="nav nav-arrow-next nav-tabs" id="myTab" >
            <li class="<?php  if(empty($_GPC['type'])) { ?>active<?php  } ?>" >
                <a href="<?php  echo webUrl('app/page')?>">全部页面</a>
            </li>
            <li class="<?php  if($_GPC['type']==2) { ?>active<?php  } ?>" >
                <a href="<?php  echo webUrl('app/page',array('type'=>2))?>">商城首页</a>
            </li>
            <li class="<?php  if($_GPC['type']==4) { ?>active<?php  } ?>" >
                <a href="<?php  echo webUrl('app/page',array('type'=>4))?>">商品详情页</a>
            </li>
            <li class="<?php  if($_GPC['type']==3) { ?>active<?php  } ?>" >
                <a href="<?php  echo webUrl('app/page',array('type'=>3))?>">会员中心页</a>
            </li>
            <li class="<?php  if($_GPC['type']==20) { ?>active<?php  } ?>" >
                <a href="<?php  echo webUrl('app/page',array('type'=>20))?>">自定义页面</a>
            </li>
            <?php  if(p('seckill') && cv('seckill')) { ?>
                <li class="<?php  if($_GPC['type']==5) { ?>active<?php  } ?>" >
                    <a href="<?php  echo webUrl('app/page',array('type'=>5))?>">秒杀页面</a>
                </li>
            <?php  } ?>


        </ul>
    </form>

    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">
            未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关页面
        </div>
    </div>
    <?php  } else { ?>
        <div class="page-table-header">
            <input type="checkbox">
            <div class="btn-group">
                <?php if(cv('app.page.delete')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('app/page/sys/delete')?>" disabled="disabled"><i class="icow icow-shanchu1"></i> 删除</button>
                <?php  } ?>
                <?php if(cv('app.page.edit')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/page/status',array('status'=>1))?>"><i class='icow icow-qiyong'></i> 启用</button>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/page/status',array('status'=>0))?>"><i class='icow icow-jinyong'></i> 禁用</button>
                <?php  } ?>
            </div>
        </div>

        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:25px;"></th>
                <th>页面名称</th>
                <th style="width: 120px; text-align: center;">页面类型</th>
                <th style="width: 100px; text-align: center;">状态</th>
                <th style="width: 155px;">创建时间</th>
                <th style="width: 155px;">最后修改时间</th>
                <th style="width: 95px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td>
                        <input type="checkbox" value="<?php  echo $row['id'];?>">
                    </td>
                    <td>
                        <?php  if(!empty($row['isdefault']) && $row['type'] == 3) { ?>
                        <span class="label label-primary">默认会员中心</span>
                        <?php  } else if(!empty($row['isdefault']) && $row['type'] == 4) { ?>
                        <span class="label label-primary">默认商品详情</span>
                        <?php  } else if(!empty($row['isdefault']) && $row['type'] == 5) { ?>
                        <span class="label label-primary">默认秒杀页面</span>
                        <?php  } else if(!empty($row['isdefault']) && ($row['type'] == 2 || $row['type'] == 20 )) { ?>
                        <span class="label label-primary">默认首页</span>
                        <?php  } ?>
                        <?php  echo $row['name'];?>
                    </td>
                    <td style="text-align: center;">
                        <?php  if($row['type']==2) { ?>
                        <span class="label label-success wid">商城首页</span>
                        <?php  } else if($row['type']==20) { ?>
                        <span class="label label-warning wid" >自定义页面</span>
                        <?php  } else if($row['type'] == 3) { ?>
                        <span class="label label-primary wid">会员中心页</span>
                        <?php  } else if($row['type'] == 4) { ?>
                        <span class="label label-danger wid">商品详情页</span>
                        <?php  } else if($row['type'] == 5) { ?>
                        <span class="label label-danger wid">秒杀页面</span>
                        <?php  } ?>
                    </td>
                    <td style="text-align: center;">
                        <span class="label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>"
                            <?php if(cv('app.page.edit')) { ?>
                                data-toggle='ajaxSwitch'
                                data-switch-value='<?php  echo $row['status'];?>'
                                data-switch-value0='0|禁用|label label-default|<?php  echo webUrl('app/page/status',array('status'=>1,'id'=>$row['id']))?>'
                                data-switch-value1='1|启用|label label-primary|<?php  echo webUrl('app/page/status',array('status'=>0,'id'=>$row['id']))?>'
                                style="cursor: pointer;"
                            <?php  } ?> >
                        <?php  if($row['status']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?>
                        </span>
                    </td>
                    <td><?php echo empty($row['createtime'])? '-': date('Y-m-d H:i:s', $row['createtime'])?></td>
                    <td><?php echo empty($row['lasttime'])? '-': date('Y-m-d H:i:s', $row['lasttime'])?></td>
                    <td>
                        <?php if(cv('app.page.edit')) { ?>
                        <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('app/page/edit', array('id'=>$row['id'],'type'=>$row['type']))?>">
                            <span data-toggle="tooltip" data-placement="top" data-original-title="编辑"><i class="icow icow-bianji2"></i></span>
                        </a>
                        <?php  } ?>
                        <?php  if(empty($row['isdefault'])) { ?>
                            <?php if(cv('app.page.delete')) { ?>
                            <a class="btn  btn-op btn-operation" data-toggle="ajaxRemove" href="<?php  echo webUrl('app/page/delete', array('id'=>$row['id']))?>" data-confirm="确定要删除该页面吗？">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i></span>
                            </a>
                            <?php  } ?>
                            <?php if(cv('app.page.edit')) { ?>
                            <a class="btn  btn-op btn-operation" data-toggle="ajaxPost" href="<?php  echo webUrl('app/page/setdefault', array('id'=>$row['id'] , 'type' => $row['type']))?>" data-confirm="确定要将此页面设置为默认
                            <?php  if($row['type'] == 3) { ?>
                            会员中心吗？
                            <?php  } else if($row['type'] == 4) { ?>
                            商品详情吗？
                          <?php  } else if($row['type'] == 5) { ?>
                            秒杀页面吗？
                            <?php  } else { ?>
                            首页吗？首页设为默认后就不可取消！
                            <?php  } ?>">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="设为默认"><i class="icow icow-home1"></i></span>
                            </a>
                            <?php  } ?>
                        <?php  } else { ?>
                            <?php if(cv('app.page.edit')) { ?>
                                <?php  if($row['type'] == 3 || $row['type'] == 4 || $row['type'] == 5 ) { ?>
                                    <a class="btn  btn-op btn-operation" data-toggle="ajaxPost" href="<?php  echo webUrl('app/page/cancel_default', array('id'=>$row['id']))?>" data-confirm="确定要取消默认吗？">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="取消默认"><i class="icow icow-quxiao"></i></span>
                                    </a>
                                <?php  } ?>
                            <?php  } ?>
                        <?php  } ?>
                    </a>
                    </td>
                </tr>
            <?php  } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <?php if(cv('app.page.delete')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('app/page/delete')?>" disabled="disabled"><i class="icow icow-shanchu1"></i> 删除</button>
                        <?php  } ?>
                        <?php if(cv('app.page.edit')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/page/status',array('status'=>1))?>"><i class='icow icow-qiyong'></i> 启用</button>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/page/status',array('status'=>0))?>"><i class='icow icow-jinyong'></i> 禁用</button>
                        <?php  } ?>
                    </td>
                    <td colspan="5" style="text-align: right;">
                        <?php  echo $pager;?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php  } ?>

</div>

    <div class="modal fade" id="selectUrl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        选择类型
        <button data-dismiss="modal" class="close" type="button" aria-label="Close">×</button>
    </div>
    <div class="modal-body ">
        <div class="diy-item item1" style="background: #e9fae4;color: #7ecf6b">
            <p> 商城首页</p>
            <a href="<?php  echo webUrl('app/page/add',array('type'=>2))?>">立即创建</a>
        </div>
        <div class="diy-item" style="background: #fffbdf;color: #ffb243">
            <p> 自定义页面</p>
            <a href="<?php  echo webUrl('app/page/add',array('type'=>20))?>">立即创建</a>
        </div>
        <div class="diy-item" style="background: #fff3f3;color: #ff5555">
            <p> 商品详情</p>
            <a href="<?php  echo webUrl('app/page/add',array('type'=>4))?>">立即创建</a>
        </div>
        <div class="diy-item" style="background: #edf6ff;color: #5cacf6">
            <p> 会员中心</p>
            <a href="<?php  echo webUrl('app/page/add',array('type'=>3))?>">立即创建</a>
        </div>
        <?php  if(p('seckill') && cv('seckill')) { ?>
            <div class="diy-item" style="background: #fef1e3;color: #ff8a33">
                <p>整点秒杀</p>
                <a href="<?php  echo webUrl('app/page/add',array('type'=>5))?>">立即创建</a>
            </div>
        <?php  } ?>
        <div class="diy-item" style="background-image: url('<?php echo EWEI_SHOPV2_LOCAL;?>static/images/coming.png');background-size: 100% 100%;height: 116px;">
        </div>
    </div>
</div>
<!--<div class="modal-backdrop fade in"></div>-->
<script>
    $(".btn-create").off("click").on("click",function () {
        $('#selectUrl').modal()
    })

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>