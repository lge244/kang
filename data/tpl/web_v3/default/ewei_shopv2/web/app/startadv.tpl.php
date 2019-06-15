<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：
    <span class="text-primary">启动广告</span>
</div>

<div class="page-content">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('app/_tab', TEMPLATE_INCLUDEPATH)) : (include template('app/_tab', TEMPLATE_INCLUDEPATH));?>

    <form action="./index.php">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="app.startadv" />

        <div class="page-toolbar">
            <?php if(cv('app.startadv.add')) { ?>
                <div class="col-sm-4">
                    <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('app/startadv/add')?>"><i class="fa fa-plus"></i> 新建启动广告</a>
                </div>
            <?php  } ?>

            <div class="col-sm-5 pull-right">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入标题关键字进行搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </div>
    </form>

    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">
            未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关广告
        </div>
    </div>
    <?php  } else { ?>
        <div class="page-table-header">
            <input type="checkbox">
            <div class="btn-group">
                <?php if(cv('app.startadv.delete')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('app/startadv/sys/delete')?>" disabled="disabled"><i class="icow icow-shanchu1"></i> 删除</button>
                <?php  } ?>
                <?php if(cv('app.startadv.edit')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/startadv/status',array('status'=>1))?>"><i class='icow icow-qiyong'></i> 启用</button>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/startadv/status',array('status'=>0))?>"><i class='icow icow-jinyong'></i> 禁用</button>
                <?php  } ?>
            </div>
        </div>

        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:25px;"></th>
                <th>广告名称</th>
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
                        <?php  echo $row['name'];?>
                    </td>
                    <td style="text-align: center;">
                        <span class="label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>"
                            <?php if(cv('app.startadv.edit')) { ?>
                                data-toggle='ajaxSwitch'
                                data-switch-value='<?php  echo $row['status'];?>'
                                data-switch-value0='0|禁用|label label-default|<?php  echo webUrl('app/startadv/status',array('status'=>1,'id'=>$row['id']))?>'
                                data-switch-value1='1|启用|label label-primary|<?php  echo webUrl('app/startadv/status',array('status'=>0,'id'=>$row['id']))?>'
                                style="cursor: pointer;"
                            <?php  } ?> >
                        <?php  if($row['status']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?>
                        </span>
                    </td>
                    <td><?php echo empty($row['createtime'])? '-': date('Y-m-d H:i:s', $row['createtime'])?></td>
                    <td><?php echo empty($row['lastedittime'])? '-': date('Y-m-d H:i:s', $row['lastedittime'])?></td>
                    <td>
                        <?php if(cv('app.startadv.edit')) { ?>
                        <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('app/startadv/edit', array('id'=>$row['id']))?>">
                            <span data-toggle="tooltip" data-placement="top" data-original-title="编辑"><i class="icow icow-bianji2"></i></span>
                        </a>
                        <?php  } ?>
                        <?php if(cv('app.startadv.delete')) { ?>
                        <a class="btn  btn-op btn-operation" data-toggle="ajaxRemove" href="<?php  echo webUrl('app/startadv/delete', array('id'=>$row['id']))?>" data-confirm="确定要删除该页面吗？">
                            <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i></span>
                        </a>
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
                        <?php if(cv('app.startadv.delete')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('app/startadv/delete')?>" disabled="disabled"><i class="icow icow-shanchu1"></i> 删除</button>
                        <?php  } ?>
                        <?php if(cv('app.startadv.edit')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/startadv/status',array('status'=>1))?>"><i class='icow icow-qiyong'></i> 启用</button>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('app/startadv/status',array('status'=>0))?>"><i class='icow icow-jinyong'></i> 禁用</button>
                        <?php  } ?>
                    </td>
                    <td colspan="4" style="text-align: right;">
                        <?php  echo $pager;?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php  } ?>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->