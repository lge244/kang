<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .select2{
        margin:0;
        width:100%;
        height:34px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice{
        height: 34px;
        line-height: 32px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice .select2-arrow{
        background: #fff;
    }
</style>
<div class="page-header">
    <div class="pull-right" style="text-align: right;" >
        <strong>高级模式</strong>
        <input class="js-switch small isadvanced" type="checkbox" <?php  if(!empty($data['tm']['is_advanced'])) { ?>checked<?php  } ?>/>
    </div>
    当前位置：<span class="text-primary">通知设置</span>
</div>
<div class="page-content">
    <form id="setform"  action="" method="post" class="form-horizontal form-validate">
        <input type="hidden" value="<?php  echo intval($data['tm']['is_advanced'])?>" name='data[is_advanced]' />
        <div class='alert alert-primary'>
            默认为全部开启，用户在会员中心可自行设置是否开启, 模板消息自动替换变量
        </div>
        <div class='alert alert-primary'>
            使用高级模式 , 将全部启用自定义的模板内容进行推送 !
        </div>

        <div class="form-group normal">
            <label class="col-lg control-label">业务处理通知</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" name="data[templateid]" class="form-control" value="<?php  echo $data['tm']['templateid'];?>" />
                <div class="help-block">公众平台模板消息编号: OPENTM413117078 </div>
            </div>
        </div>

        <div class="form-group-title">商家通知 - 入驻申请</div>

        <div class="form-group">
            <label class="col-lg control-label">选择通知人</label>
            <div class="col-sm-9 col-xs-12">
                <?php if(cv('merch.notice.edit')) { ?>
                <?php  echo tpl_selector('openids',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers,'url'=>webUrl('member/query') ))?>
                <span class='help-block'>选择多商户下面所有通知的通知人，可以指定多个人，如果不填写则不通知</span>
                <?php  } else { ?>
                <div class="input-group multi-img-details" id='saler_container'>
                    <?php  if(is_array($salers)) { foreach($salers as $saler) { ?>
                    <div class="multi-item saler-item" openid='<?php  echo $saler['openid'];?>'>
                    <img class="img-responsive img-thumbnail" src='<?php  echo $saler['avatar'];?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                    <div class='img-nickname'><?php  echo $saler['nickname'];?></div>
                    <input type="hidden" value="<?php  echo $saler['openid'];?>" name="openids[]">
                    <?php  } } ?>
                </div>
                <?php  } ?>
            </div>
        </div>
        <div class="normal">
            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="data[merch_applytitle]" class="form-control" value="<?php  echo $data['tm']['merch_applytitle'];?>" />
                    <div class="help-block">标题，默认"商户入驻申请"</div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea  name="data[merch_apply]" class="form-control textarea"rows="5" ><?php  echo $data['tm']['merch_apply'];?></textarea>
                  <div class="variable">
                      模板变量: [商户名称] [主营项目] [联系人] [手机号] [申请时间]
                      <br/>如果不填写默认内容为: [商户名称]在[申请时间]提交了入驻申请，请到后台查看~
                  </div>
                </div>
            </div>
        </div>
        <div class="advanced">
            <div class="form-group">
                <label class="col-lg control-label">入驻申请</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" name="data[merch_apply_advanced]">
                        <option value=''>[默认]入住申请通知</option>
                        <?php  if(is_array($template_list['merch_apply'])) { foreach($template_list['merch_apply'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['merch_apply_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div style="text-align: right;line-height: 30px" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[merch_apply_close_advanced]" value="<?php  echo intval($data['tm']['merch_apply_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="merch_apply" type="checkbox" value="<?php  echo intval($data['tm']['merch_apply_close_advanced'])?>" <?php  if(empty($data['tm']['merch_apply_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" style="display: <?php  if($opensms) { ?>block<?php  } else { ?>none<?php  } ?>;">
            <label class="col-lg control-label">短信通知</label>
            <div class="col-sm-9 col-xs-12">
                <select class="select2" name="data[merch_apply_sms]">
                    <option value="0">从短信模板库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['merch_apply_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                </select>
            </div>
            <div style="text-align: right;line-height: 30px;" class="is_sms advanced">
                <input type="hidden" name="data[merch_apply_close_sms]" value="<?php  echo intval($data['merch_apply_close_sms'])?>" />
                <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['merch_apply_close_sms'])?>" <?php  if(empty($data['merch_apply_close_sms'])) { ?>checked<?php  } ?>/>
            </div>
        </div>
        <div class="form-group" style="display: <?php  if($opensms) { ?>block<?php  } else { ?>none<?php  } ?>;">
            <label class="col-lg control-label">短信通知人</label>
            <div class="col-sm-9 col-xs-12">
                <textarea class="form-control" name="data[mobiles]" rows="5"><?php  echo $data['tm']['mobiles'];?></textarea>
                <div class="help-block">可填写多个手机号以英文逗号隔开(,)，提醒人为空或者未选择短信模板则不发送</div>
            </div>
        </div>

        <div class="form-group-title">商家通知 - 提现申请提交通知</div>

        <div class="form-group">
            <label class="col-lg control-label">提现申请通知人</label>
            <div class="col-sm-9 col-xs-12">
                <?php if(cv('merch.notice.edit')) { ?>
                <?php  echo tpl_selector('applyopenids',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$applysalers,'url'=>webUrl('member/query') ))?>
                <span class='help-block'>选择多商户下面所有通知的通知人，可以指定多个人，如果不填写则不通知</span>
                <?php  } else { ?>
                <div class="input-group multi-img-details" id='saler_container_apply'>
                    <?php  if(is_array($applysalers)) { foreach($applysalers as $saler) { ?>
                    <div class="multi-item saler-item" applyopenid='<?php  echo $saler['openid'];?>'>
                        <img class="img-responsive img-thumbnail" src='<?php  echo $saler['avatar'];?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                        <div class='img-nickname'><?php  echo $saler['nickname'];?></div>
                        <input type="hidden" value="<?php  echo $saler['openid'];?>" name="applyopenids[]"/>
                    </div>
                    <?php  } } ?>
                </div>
                <?php  } ?>
            </div>
        </div>

        <div  class="normal">
            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('merch.notice.edit')) { ?>
                    <input type="text" name="data[merch_applymoneytitle]" class="form-control" value="<?php  echo $data['tm']['merch_applymoneytitle'];?>" />
                    <div class="help-block">标题，默认"提现申请提交通知"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['merch_applymoneytitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('merch.notice.edit')) { ?>
                    <textarea  name="data[merch_applymoney]" class="form-control" rows="5"><?php  echo $data['tm']['merch_applymoney'];?></textarea>
                  <div class="variable">  模板变量  [商户名称] [金额] [联系人] [手机号] [申请时间]</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['merch_applymoney'];?></div>
                    <?php  } ?>
                </div>
            </div>
        </div>
        <div class="advanced">
            <div class="form-group">
                <label class="col-lg control-label">提现申请提交通知</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" name="data[merch_applymoney_advanced]">
                        <option value=''>[默认]提现申请提交通知</option>
                        <?php  if(is_array($template_list['merch_applymoney'])) { foreach($template_list['merch_applymoney'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['merch_applymoney_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div style="text-align: right;line-height: 30px" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[merch_applymoney_close_advanced]" value="<?php  echo intval($data['tm']['merch_applymoney_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="merch_apply" type="checkbox" value="<?php  echo intval($data['tm']['merch_applymoney_close_advanced'])?>" <?php  if(empty($data['tm']['merch_applymoney_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group" style="display: <?php  if($opensms) { ?>block<?php  } else { ?>none<?php  } ?>;">
            <label class="col-lg control-label">短信通知</label>
            <div class="col-sm-9 col-xs-12">
                <select class="select2" name="data[merch_applymoney_sms]">
                    <option value="0">从短信模板库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['merch_applymoney_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                </select>
            </div>
            <div style="text-align: right;line-height: 30px" class="is_sms advanced">
                <input type="hidden" name="data[merch_applymoney_close_sms]" value="<?php  echo intval($data['merch_applymoney_close_sms'])?>" />
                <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['merch_applymoney_close_sms'])?>" <?php  if(empty($data['merch_applymoney_close_sms'])) { ?>checked<?php  } ?>/>
            </div>
        </div>

        <div class="form-group" style="display: <?php  if($opensms) { ?>block<?php  } else { ?>none<?php  } ?>;">
            <label class="col-lg control-label">短信通知人</label>
            <div class="col-sm-9 col-xs-12">
                <textarea class="form-control" name="data[applymobiles]"rows="5"><?php  echo $data['tm']['applymobiles'];?></textarea>
                <div class="help-block">可填写多个手机号以英文逗号隔开(,)，提醒人为空或者未选择短信模板则不发送</div>
            </div>
        </div>


            <div class="form-group">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9">
                    <input type="submit" value="提交" class="btn btn-primary" />
                </div>
            </div>
    </form>
</div>
<script>
    $(function () {
        $(".isadvanced").click(function () {
            $(":input[name='data[is_advanced]']").val( this.checked ?1:0);
            if (this.checked)
            {
                $(".advanced").show();
                $(".alert-success").show();
                $(".normal").hide();
                $(".alert-info").hide();
            }
            else
            {
                $(".advanced").hide();
                $(".alert-success").hide();
                $(".normal").show();
                $(".alert-info").show();
            }
        })


        $(".js-switch").not(".checkhi").click(function () {
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val("0");
            }else{
                $(this).val("0").prev().val("1");
            }
        });

        if($(":input[name='data[is_advanced]']").val() == 1)
        {
            $(".advanced").show();
            $(".alert-success").show();
            $(".normal").hide();
            $(".alert-info").hide();
        }
        else
        {
            $(".advanced").hide();
            $(".alert-success").hide();
            $(".normal").show();
            $(".alert-info").show();
        }

        //开启通知
        $(".checkone").click(function () {
            var _this =$(this);
            var type = _this.data('type');
            var val = _this.val();

            var tag = _this.data('tag');
            var stop = _this.data('stop');

            if(stop==1)
            {
                return;
            }

            //判断是否开启模板通知
            if(tag != '' && val==1&&type=='tpl-advanced') {
                $(this).data('stop', 1);
                $(this).parent().hide().next().show();

                var data = {
                    'tag': tag,
                    checked:val
                };
                //申请微信模板,并将模板ID更新至数据库.
                $.ajax({
                    url: "<?php  echo webUrl('sysset/settemplateid')?>",
                    type:'get',
                    dataType:'json',
                    timeout : 3000, //超时时间设置，单位毫秒
                    data:data,
                    success:function(ret){
                        var _this = $(".checkone[data-tag='"+ret.result.tag+"']");
                        if (ret.result.status == '0') {
                            this.value=0;
                            _this.prev().val(1);
                            _this.next().removeClass('checked');

                            console.log(ret.result.messages);
                            alert(ret.result.messages);
                        }

                        $(_this).data('stop', 0);
                        $(_this).parent().show().next().hide();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $(".table").each(function () {
                            var _this = $(this);
                            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                                $(this).data('stop', 0);
                                $(this).parent().show().next().hide();
                            });
                        });
                    }
                });
            }


            var type = $(this).data('type');
            var val = $(this).val();
            if(val==0){
                $(this).attr("checked","false").val("1").next().removeClass("checked");
                $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("1").attr("checked","false").next().removeClass("checked");
            }else{
                $(this).attr("checked","true").val("0").next().addClass("checked");
                var all = true;
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").each(function () {
                    var val = $(this).val();
                    if(val!='on' && val==1){
                        all = false;
                        return;
                    }
                });
                if(all){
                    $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("0").attr("checked","true").next().addClass("checked");
                }
            }

        });

        $(".table").each(function () {
            var _this = $(this);
            var all_tpl_normal = true;
            var all_tpl_advanced = true;
            var all_sms = true;
            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_tpl_advanced = false;
                    return;
                }
            });
            _this.find(".checkone[data-type='sms']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_sms = false;
                    return;
                }
            });
            if(all_tpl_normal){
                _this.find(".checkall[data-type='tpl-normal']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_tpl_advanced){
                _this.find(".checkall[data-type='tpl-advanced']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_sms){
                _this.find(".checkall[data-type='sms']").val("0").attr("checked","true").next().addClass("checked");
            }
        });

    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>