<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">代理人列表</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="member.level"/>
        <div class="page-toolbar">

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
    <?php  if(empty($members)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>
    <form action="" method="post">
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:16%;">id</th>
                <th style="width:16%;">会员名称</th>
                <th style="width:16%;">会员等级</th>
                <th style="width:16%;">历史会员业绩</th>
                <th style="width:16%;">历史团队业绩</th>
                <th style="width:16%;">今日会员业绩</th>
                <th style="width:16%;">今日团队业绩</th>
                <th style="width:16%;">今日团队提成</th>
                <th style="width: 20%;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($members)) { foreach($members as $v) { ?>
            <tr>
                <td><?php  echo $v['id'];?></td>
                <td><?php  echo $v['nickname'];?></td>
                <td><?php  if(($v['level'] == '')) { ?>免费会员<?php  } else { ?><?php  echo $v['level'];?><?php  } ?></td>
                <td><?php  if((!$v['info']['sum_price'])) { ?>0<?php  } else { ?><?php  echo $v['info']['sum_price'];?><?php  } ?></td>
                <td><?php  if((!$v['info']['teamSumPrice'])) { ?>0<?php  } else { ?><?php  echo $v['info']['teamSumPrice'];?><?php  } ?></td>
                <td><?php  if((!$v['info']['today_price'])) { ?>0<?php  } else { ?><?php  echo $v['info']['today_price'];?><?php  } ?></td>
                <td><?php  if((!$v['info']['teamTodayPrice'])) { ?>0<?php  } else { ?><?php  echo $v['info']['teamTodayPrice'];?><?php  } ?></td>
                <td><?php  if((!$v['info']['teamBonus'])) { ?>0<?php  } else { ?><?php  echo $v['info']['teamBonus'];?><?php  } ?></td>
                <td>
                    <?php if(cv('member.transfer.del')) { ?>
                    <a data-toggle='ajaxRemove'
                       href="<?php  echo webUrl('member/transfer/del', array('id' => $v['id']))?>"
                       class="btn btn-op btn-operation" data-confirm='确认要删除此条记录吗?'>
					<span data-toggle="tooltip" data-placement="top" data-original-title="删除">
						<i class='icow icow-shanchu1'></i>
					</span>
                    </a>
                    <?php  } ?>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>

        </table>
    </form>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>