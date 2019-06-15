<?php defined('IN_IA') or exit('Access Denied');?><form class="form-horizontal form-validate" <?php  if($send) { ?> action="<?php  echo webUrl('sysset/sms/temp/testsend')?>" method="post" enctype="multipart/form-data"<?php  } ?>>
    <input type="hidden" name="id" value="<?php  echo $id;?>" />
	<div class="modal-dialog">
           <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">测试发送<?php  if(!empty($item)) { ?> <small>(<?php  echo $item['name'];?>)</small><?php  } ?></h4>
            </div>
            <div class="modal-body">
                <?php  if(!$send) { ?>
                    <p style="font-size: 16px; text-align: center; line-height: 80px; margin-bottom: 0"><?php  echo $errmsg;?></p>
                <?php  } else { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label must">手机号</label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="tel" name="mobile" class="form-control" value="" placeholder="请输入被发送手机号" data-rule-required="true" maxlength="11"></span>
                        </div>
                    </div>
                    <?php  if(empty($item['template'])) { ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label must">短信内容</label>
                            <div class="col-sm-9 col-xs-12">
                                <textarea class="form-control" name="data" rows="4" style="resize: none;"><?php  echo $item['content'];?></textarea>
                            </div>
                        </div>
                    <?php  } else { ?>
                        <?php  if(is_array($item['data'])) { foreach($item['data'] as $data) { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label must">数据值</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="input-group" style="margin: 0;">
                                        <span class="input-group-addon"><?php  echo $data['data_temp'];?></span>
                                        <input type="text" name="data[]" class="form-control" value="" data-rule-required="true" placeholder="此处请填写变量">
                                    </div>
                                </div>
                            </div>
                        <?php  } } ?>
                    <?php  } ?>
                <?php  } ?>
            </div>
            <div class="modal-footer">
                <?php  if($send) { ?>
                    <button class="btn btn-primary" type="submit">确认发送</button>
                <?php  } ?>
                <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
            </div>
        </div>
    </div>
    <script>
        $(function () {
           $("form").submit(function () {
               var mobile = $.trim($("input[name='mobile']").val());
               if (mobile.length < 11) {
                   tip.msgbox.err('请填写正确手机号!');
                   $('form').attr('stop',1);
                   return;
               }
               var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
               if (!myreg.test(mobile)) {
                   tip.msgbox.err('请填写正确手机号!');
                   $('form').attr('stop',1);
                   return;
               }
               $('form').removeAttr('stop');
               return true;
           });
        });
    </script>
</form>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->