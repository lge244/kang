<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>级差规则<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>
</div>
<div class="page-content">

    <input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
    <div class="form-group">
        <label class="col-lg control-label">加盟分成</label>
        <div class="col-sm-9 col-xs-12">
            <div class='input-group fixsingle-input-group'>
                <span class='input-group-addon'>团队业绩</span>
                <input type="number" name="agency_purchase_time" id="total" class="form-control" value="<?php  echo $divide['total'];?>"/>
            </div>

            <div class='input-group fixsingle-input-group' style="margin-top: 20px;">
                <span class='input-group-addon'>拨出比例</span>
                <input type="number" name="agency_purchase_time" id="ratio" class="form-control" value="<?php  echo $divide['ratio'];?>"/>
                <span class='input-group-addon'>%</span>
            </div>
        </div>

    </div>


    <div class="form-group">
        <label class="col-lg control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <input type="submit" value="保存" class="btn btn-primary submit"/>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
    $('.submit').click(function () {
        var total = $('#total').val();
        var ratio = $('#ratio').val();
        if (total == 0 ){
            tip.msgbox.err("团队业绩不能小于零 1 ！");
            return false;
        }
        if (ratio == 0 ){
            tip.msgbox.err("拨出比例不能小于零 1 ！");
            return false;
        }

        $.post("<?php  echo webUrl('team/range/post')?>",{
            "total":total,
            "ratio":ratio,
        },function (res) {
            if(res.code == 0){
                tip.msgbox.suc(res.msg)
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg)
            }
        },'json')
    })
</script>
