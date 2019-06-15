<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">佣金比例列表</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="member.level"/>
        <div class="page-toolbar">
            <div class="pull-left">
                <?php if(cv('scale.level.add')) { ?>
                <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('member/commissionscale/add')?>"><i class='fa fa-plus'></i> 添加佣金比例</a>
                <?php  } ?>
            </div>
            <div class="pull-right col-md-6">
                <div class="input-group">
                    <input type="text" class=" form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>"
                           placeholder="请输入关键词">
                    <span class="input-group-btn">
						<button class="btn btn-primary" type="submit"> 搜索</button>
					</span>
                </div>
            </div>
        </div>
    </form>
    <?php  if(empty($scale)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>
    <form action="" method="post">
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:8%;">id</th>
                <th style="width:24%;">佣金类型</th>
                <th style="width:16%;">佣金比例</th>
                <th style="width: 20%;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($scale)) { foreach($scale as $v) { ?>
            <tr>
                <td><?php  echo $v['id'];?></td>
                <td><?php  echo $v['title'];?></td>
                <td><?php  echo $v['scale'];?></td>
                <td>
                    <?php if(cv('member.commissionscale.add|member.commissionscale.edit')) { ?>
                    <a href="<?php  echo webUrl('member/commissionscale/add', array('id' => $v['id']))?>" class="btn btn-op btn-operation">
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('member.level.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">
                                                <i class='icow icow-bianji2'></i>
                                            </span>
                    </a>
                    <?php  } ?>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">
                </td>
                <td colspan="4" style="text-align: right">
                    <span class="pull-right" style="line-height: 28px;"></span>
                    <?php  echo $pager;?>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>