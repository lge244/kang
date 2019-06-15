<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">代理人列表</span></div>
<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th style="width:16%;">奖金发放总额</th>
        <th style="width:16%;">总业绩</th>
        <th style="width:16%;">分配比例</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php  echo $Totalbonuspayment['Totalbonuspayment'];?></td>
        <td><?php  echo $sumPrice;?></td>
        <td><?php  echo $sum;?> %</td>
    </tr>
    </tbody>
</table>
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
    <?php  if(empty($data)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>
    <form action="" method="post">
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:16%;">id</th>
                <th style="width:16%;">奖金发放总额</th>
                <th style="width:16%;">当日总业绩</th>
                <th style="width:16%;">分配比例</th>
                <th style="width:16%;">结算日期</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($data)) { foreach($data as $v) { ?>
            <tr>
                <td><?php  echo $v['id'];?></td>
                <td><?php  echo $v['Totalbonuspayment'];?></td>
                <td><?php  echo $v['TodayPerformance'];?></td>
                <td><?php  echo $v['partitionRatio'];?> %</td>
                <td><?php  echo date('Y-m-d H:i:s',$v['time']);?></td>
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