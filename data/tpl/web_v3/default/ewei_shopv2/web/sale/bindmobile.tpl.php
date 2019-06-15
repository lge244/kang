<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class='page-header'>
    当前位置：<span class="text-primary">绑定手机号送积分</span>
</div>

<div class="page-content">
    <form id="dataform" <?php if(cv('sale.bindmobile')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate">

        <div class="panel">
            <div class="panel-body">
                <div class="col-sm-9 col-xs-12">
                    <h4 class="set_title">绑定手机号送积分</h4>
                    <span> 开启绑定手机号送积分, 用户绑定手机号后会获得指定积分</span>
                </div>
                <div class="col-lg pull-right" style="padding-top:10px;text-align: right" >
                    <?php if(cv('sale.bindmobile')) { ?>
                        <input type="checkbox" class="js-switch" name="data[bindmobile]" value="1" <?php  if($data['bindmobile']==1) { ?>checked<?php  } ?> />
                    <?php  } else { ?>
                        <?php  if($data['bindmobile']==1) { ?>
                            <span class='text-success'>开启</span>
                        <?php  } else { ?>
                            <span class='text-default'>关闭</span>
                        <?php  } ?>
                    <?php  } ?>
                </div>
            </div>

            <div id='bindmobile'  <?php  if(empty($data['bindmobile'])) { ?>style="display:none"<?php  } ?>>
                <div class="form-group">
                    <label class="col-lg control-label">绑定成功发放</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sale.bindmobile')) { ?>
                            <div class='input-group fixsingle-input-group'>
                                <input type="number" name="data[bindmobilecredit]"  value="<?php  echo $data['bindmobilecredit'];?>" class="form-control" />
                                <span class='input-group-addon'>积分</span>
                            </div>
                            <span class='help-block'>开启后用户首次绑定手机号会获得指定积分(包含wap与小程序)</span>
                        <?php  } else { ?>
                            <div class='form-control-static'>{$data['bindmobilecredit'])}积分</div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if(cv('sale.bindmobile')) { ?>
            <div class="form-group"></div>
            <div class="form-group">
                <div class="col-sm-9 col-xs-12">
                    <input type="submit"  value="保存设置" class="btn btn-primary"/>
                </div>
            </div>
        <?php  } ?>

    </form>
</div>

<script language='javascript'>
    $(function () {
        $(":checkbox[name='data[bindmobile]']").click(function () {
            if ($(this).prop('checked')) {
                $("#bindmobile").show();
            } else {
                $("#bindmobile").hide();
            }
        });
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->