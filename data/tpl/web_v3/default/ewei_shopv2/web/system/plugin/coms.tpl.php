<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">应用信息设置 </span>
    <span>应用关闭状态时只有超级管理员才能使用，安装后默认为关闭</span>
</div>

<div class="page-content">
    <div class='page-toolbar'>
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="ewei_shopv2" />
            <input type="hidden" name="do" value="web" />
            <input type="hidden" name="r" value="system.plugin.coms" />
            <div class="col-sm-6 pull-right">
                <div class="input-group" style='padding:0;'>
                    <input type="text" class=" form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="组件名称/组件标识">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <form method='post' class="form-horizontal form-validate">
        <table class="table">
            <thead class="navbar-inner">
            <tr>
                <th style='width:100px;'>图标</th>
                <th style='width:100px;'>标识</th>
                <th style='width:80px;'>开关</th>
                <th style='width:200px;' >组件名称</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>

            <tr>

                <td>
                    <input type='hidden'  name="thumb[<?php  echo $row['id'];?>]" value="<?php  echo $row['thumb'];?>" />
                    <img onclick="selectImage(this)" onerror="this.src='<?php echo EWEI_SHOPV2_LOCAL;?>static/images/yingyong.png'"
                         src="<?php  if(empty($row['thumb'])) { ?><?php echo EWEI_SHOPV2_LOCAL;?>static/images/yingyong.png<?php  } else { ?><?php  echo tomedia($row['thumb'])?><?php  } ?>"
                         <?php  if(!empty($row['thumb'])) { ?>
                    data-toggle='popover'
                    data-html ='true'
                    data-placement='top'
                    data-trigger ='hover'
                    data-content="<img src='<?php  echo tomedia($row['thumb'])?>' style='width:30px;height:30px;' />"
                    <?php  } ?>
                    style="width:40px;height:40px">
                </td>
                <td><?php  echo $row['identity'];?></td>
                <td>
                    <?php  if($row['identity']=='system') { ?>
                    --
                    <input type='hidden' name='status[<?php  echo $row['id'];?>]' value="0" />
                    <?php  } else { ?>
                    <label class='checkbox-inline'>
                        <input type='checkbox' name='status[<?php  echo $row['id'];?>]' value="1" <?php  if($row['status']==1) { ?>checked<?php  } ?> /> 开启
                    </label>

                    <?php  } ?>

                </td>
                <td><input type="text" class="form-control" name="name[<?php  echo $row['id'];?>]" value="<?php  echo $row['name'];?>"></td>
            </tr>
            <?php  } } ?>
            <tr>
                <td colspan='4'>
                    <input type="submit"  class="btn btn-primary" value="批量修改">

                </td>
            </tr>
            </tbody>
        </table>
        <?php  echo $pager;?>

    </form>
</div>
<script language='javascript'>
    $(function(){
        $('.desc').focus(function(){
            $(this).css('height','80px');
        }).blur(function(){
            $(this).css('height','35px');
        })
    });
    function selectImage(obj){
        util.image('',function(val){

            $(obj).attr('src',val.url).popover({
                trigger: 'hover',
                html: true,
                container: $(document.body),
                content: "<img src='" + val.url  + "' style='width:40px;height:40px;' />",
                placement: 'top'
            });

            var group  =$(obj).parent();

            group.find(':hidden').val(val.url), group.find('i').show().unbind('click').click(function(){
                $(obj).attr('src',"<?php echo EWEI_SHOPV2_LOCAL;?>static/images/nopic100.jpg");
                group.find(':hidden').val('');
                group.find('i').hide();
                $(obj).popover('destroy');
            });
        });
    }


</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->