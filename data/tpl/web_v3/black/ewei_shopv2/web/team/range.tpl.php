<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">级差规则列表</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="member.level"/>
        <div class="page-toolbar">
            <div class="pull-left">
                <?php if(cv('member.level.add')) { ?>
                <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('team/range/add')?>"><i class='fa fa-plus'></i> 添加级差规则</a>
                <?php  } ?>
            </div>

        </div>
    </form>
    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>
    <form action="" method="post">
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:16%;">id</th>
                <th style="width:16%;">级差条件</th>
                <th style="width:16%;">拨出比例</th>
                <th style="width: 20%;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $v) { ?>
            <tr>
                <td><?php  echo $v['id'];?></td>
                <td><?php  echo $v['total'];?> 万</td>
                <td><?php  echo $v['ratio'];?> %</td>
                <td>
                    <a data-toggle='ajaxRemove'
                       href="<?php  echo webUrl('member/transfer/del', array('id' => $v['id']))?>"
                       class="btn btn-op btn-operation" data-confirm='确认要删除此条记录吗?'>
					<span data-toggle="tooltip" data-placement="top" data-original-title="删除">
						<i class='icow icow-shanchu1'></i>
					</span>
                    </a>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
    </form>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>