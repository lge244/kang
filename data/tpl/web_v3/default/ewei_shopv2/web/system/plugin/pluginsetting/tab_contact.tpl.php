<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">在线客服</label>
    <div class="col-sm-9 col-xs-12">
        <input type='text' class='form-control' name='data[customer]' value="<?php  echo $data['customer'];?>" />
        <div class="help-block">客服QQ号</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">联系电话</label>
    <div class="col-sm-9 col-xs-12">
        <div class="group-date-all">
            <?php  if(!empty($data) && !empty($contacts)) { ?>
            <?php  if(is_array($contacts)) { foreach($contacts as $index => $row) { ?>
            <div class="input-group input-group-date input-group-date<?php  echo $index;?>">
                <span class="input-group-addon">电话</span>
                <input type="text" class="form-control form-contro<?php  echo $index;?>" name="tel[]" value="<?php  echo $row['tel'];?>">
                <span class="input-group-addon">备注</span>
                <input type="text" class="form-control form-contro<?php  echo $index;?>" name="note[]" value="<?php  echo $row['note'];?>">
                <?php  if($index>0) { ?>
                <span class="input-group-addon input-group-remove"  onclick="removeTel(<?php  echo $index;?>)"><i class="fa fa-remove"></i></span>
                <?php  } else { ?>
                <span class="input-group-addon">默认</span>
                <?php  } ?>
            </div>
            <?php  } } ?>
            <?php  } else { ?>
            <div class="input-group input-group-date">
                <span class="input-group-addon">电话</span>
                <input type="text" class="form-control" name="tel[]" value="">
                <span class="input-group-addon">备注</span>
                <input type="text" class="form-control" name="note[]" value="">
                <span class="input-group-addon">默认</span>
            </div>
            <?php  } ?>
        </div>
        <a class="btn btn-default" href="javascript:;" onclick="addTel()"><span class="fa fa-plus"></span> 新增联系电话</a>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">服务时间</label>
    <div class="col-sm-9 col-xs-12">
        <input type='text' class='form-control' name='data[servertime]' value="<?php  echo $data['servertime'];?>" />
        <div class="help-block">例：周一至周五 9:00~18：00</div>
    </div>
</div>
<script>

    function addTel() {
        var group = $(".input-group-date").length;
        var groupStr = '<div class="input-group input-group-date input-group-date'+group+'">' +
            '<span class="input-group-addon">电话</span>' +
            '<input type="text" class="form-control form-contro'+group+'" name="tel[]" value="">' +
            '<span class="input-group-addon">备注</span>' +
            '<input type="text" class="form-control form-contro'+group+'" name="note[]" value="">' +
            '<span class="input-group-addon input-group-remove"  onclick="removeTel('+group+')"><i class="fa fa-remove"></i></span>' +
            '</div>';
        $(".group-date-all").append(groupStr);
    }
    function removeTel(index) {
        $(".input-group-date"+index+"").remove()
    }
</script>

<!--4000097827-->