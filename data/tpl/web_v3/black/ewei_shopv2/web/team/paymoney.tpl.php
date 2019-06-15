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
            <div class="pull-left">
                <a class='btn btn-primary btn-sm jiesuan' href="#">拨比结算</a>
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
                <th style="width:16%;">会员名称</th>
                <th style="width:16%;">会员等级</th>
                <th style="width:16%;">会员电话</th>
                <th style="width:16%;">拨比金额</th>
                <th style="width:16%;">拨比扣税</th>
                <th style="width:16%;">拨比时间</th>
                <th style="width:16%;">拨比次数</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $v) { ?>
            <tr>
                <td><?php  echo $v['id'];?></td>
                <td><?php  echo $v['name'];?></td>
                <td><?php  echo $v['info']['level'];?></td>
                <td><?php  echo $v['mobile'];?></td>
                <td><?php  echo $v['teamBonus'];?></td>
                <td><?php  echo $v['tallage'];?></td>
                <td><?php  echo date('Y-m-d H:i:s',$v['time']);?></td>
                <td><?php  echo $v['info']['bob_num'];?></td>
            </tr>
            <?php  } } ?>
            </tbody>

        </table>
    </form>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
    $('.jiesuan').click(function () {
        $.post("/app/index.php?i=5&c=entry&m=ewei_shopv2&do=mobile&r=account.range",{},function (res) {
            if(res.code == 0){
                tip.msgbox.suc(res.msg);
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg)
            }
        },'json')
    })
</script>