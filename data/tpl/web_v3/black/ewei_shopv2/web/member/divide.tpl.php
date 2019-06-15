<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">

    当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>加盟分成<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>

</div>


<div class="page-content">

    <div class="page-sub-toolbar">

        <span class=''>
        </span>

    </div>
    <input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
    <div class="form-group">

        <label class="col-lg control-label">加盟分成</label>

        <div class="col-sm-9 col-xs-12">
            <div class='input-group fixsingle-input-group'>
                <span class='input-group-addon'>分成比例</span>
                <input type="number" name="agency_purchase_time" id="divide" class="form-control" value="<?php  echo $divide['divide'];?>"/>
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
        var divide = $('#divide').val();
        if (divide == 0 ){
            tip.msgbox.err("分成比例不能小于零 1 ！");
            return false;
        }

        $.post("<?php  echo webUrl('member/divide/post')?>",{
            "divide":divide,
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
