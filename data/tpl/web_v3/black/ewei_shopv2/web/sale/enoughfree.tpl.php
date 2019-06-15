<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='page-header'><span>当前位置：<span class="text-primary">满额包邮设置</span></span></div>
 
   <div class="page-content">
       <form id="dataform"    <?php if(cv('sale.enoughfree')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate">


       <div class="panel" >
           <div class="panel-body">
               <div class="col-sm-9 col-xs-12">
                   <h4 class="set_title">满额包邮</h4>
                   <span> 开启满包邮, 订单总金额超过多少可以包邮</span>
               </div>
               <div class="col-lg pull-right" style="padding-top:10px;text-align: right" >
                   <?php if(cv('sale.enoughfree')) { ?>
                   <input type="checkbox" class="js-switch" name="data[enoughfree]" value="1" <?php  if($data['enoughfree']==1) { ?>checked<?php  } ?> />
                   <?php  } else { ?>
                   <?php  if($data['enoughfree']==1) { ?>
                   <span class='text-success'>开启</span>
                   <?php  } else { ?>
                   <span class='text-default'>关闭</span>
                   <?php  } ?>
                   <?php  } ?>
               </div>
           </div>

           <div id='enoughfree'  <?php  if(empty($data['enoughfree'])) { ?>style="display:none"<?php  } ?>>
           <div class="form-group">
               <label class="col-lg control-label">单笔订单满</label>
               <div class="col-sm-9 col-xs-12">
                   <?php if(cv('sale.enoughfree')) { ?>
                   <div class='input-group fixsingle-input-group'>
                       <input type="text" name="data[enoughorder]"  value="<?php  echo $data['enoughorder'];?>" class="form-control" />
                       <span class='input-group-addon'>元</span>
                   </div>
                   <span class='help-block'>如果开启满额包邮，设置0为全场包邮</span>
                   <?php  } else { ?>
                   <div class='form-control-static'><?php  if(empty($data['enoughmoney'])) { ?>全场包邮<?php  } else { ?>订单金额满<?php  echo $data['enoughmoney'];?>元包邮<?php  } ?></div>
                   <?php  } ?>
               </div>
           </div>


           <div class="form-group">
               <label class="col-lg control-label">不参加的地区</label>
               <div class="col-sm-9 col-xs-12">
                   <?php if(cv('sale.enoughfree')) { ?>
                   <div id="areas" class="form-control-static"><?php  echo $data['enoughareas'];?></div>
                   <a href="javascript:;" class="btn btn-default" onclick="selectAreas()">选择地区</a>
                   <input type="hidden" id='selectedareas' name="data[enoughareas]" value="<?php  echo $data['enoughareas'];?>" />
                   <input type="hidden" id='selectedareas_code' name="data[enoughareas_code]" value="<?php  echo $data['enoughareas_code'];?>" />
                   <?php  } else { ?>
                   <div class='form-control-static'><?php  echo $data['enoughareas'];?></div>
                   <?php  } ?>
               </div>
           </div>

           <div class="form-group">
               <label class="col-lg control-label">不参与包邮的商品</label>
               <div class="col-sm-9">
                   <div class="form-group" style="height: auto; display: block;">
                       <div class="col-sm-12 col-xs-12">
                           <?php if(cv('sale.enoughfree')) { ?>
                           <div class="input-group">
                               <input type="text" id="goodsid_text" name="goodsid_text" value="" class="form-control text" readonly="">
                               <div class="input-group-btn">
                                   <button class="btn btn-primary select_goods" type="button">选择商品</button>
                               </div>
                           </div>
                           <div class="input-group multi-img-details container ui-sortable goods_show">
                               <?php  if(!empty($goods)) { ?>
                               <?php  if(is_array($goods)) { foreach($goods as $g) { ?>
                               <div class="multi-item" data-id="<?php  echo $g['id'];?>" data-name="goodsid" id="<?php  echo $g['id'];?>">
                                   <img class="img-responsive img-thumbnail" src="<?php  echo tomedia($g['thumb'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" style="width:100px;height:100px;">
                                   <div class="img-nickname"><?php  echo $g['title'];?></div>
                                   <input type="hidden" value="<?php  echo $g['id'];?>" name="goodsid[]">
                                   <em onclick="removeHtml(<?php  echo $g['id'];?>)" class="close">×</em>
                                   <div style="clear:both;"></div>
                               </div>
                               <?php  } } ?>
                               <?php  } ?>
                           </div>
                           <script>
                               $(function(){
                                   var title = '';
                                   $('.img-nickname').each(function(){
                                       title += $(this).html()+';';
                                   });
                                   $('#goodsid_text').val(title);
                               })
                               myrequire(['web/goods_selector'],function (Gselector) {
                                   $('.select_goods').click(function () {
                                       var ids = select_goods_ids();
                                       Gselector.open('goods_show','',0,true,'',ids);
                                   });
                               })
                               function goods_show(data) {
//                        console.log(data);
                                   if(data.act == 1){
                                       var html = '<div class="multi-item" data-id="'+data.id+'" data-name="goodsid" id="'+data.id+'">'
                                           +'<img class="img-responsive img-thumbnail" src="'+data.thumb+'" onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'" style="width:100px;height:100px;">'
                                           +'<div class="img-nickname">'+data.title+'</div>'
                                           +'<input type="hidden" value="'+data.id+'" name="goodsid[]">'
                                           +'<em onclick="removeHtml('+data.id+')" class="close">×</em>'
                                           +'</div>';

                                       $('.goods_show').append(html);
                                       var title = '';
                                       $('.img-nickname').each(function(){
                                           title += $(this).html()+';';
                                       });
                                       $('#goodsid_text').val(title);
                                   }else if(data.act == 0){
                                       removeHtml(data.id);
                                   }

                               }
                               function removeHtml(id){
                                   $("[id='"+id+"']").remove();
                                   var title = '';
                                   $('.img-nickname').each(function(){
                                       title += $(this).html()+';';
                                   });
                                   $('#goodsid_text').val(title);
                               }
                               function select_goods_ids(){
                                   var goodsids = [];
                                   $(".multi-item").each(function(){
                                       goodsids.push($(this).attr('data-id'));
                                   });
                                   return goodsids;
                               }
                           </script>
                           <?php  } else { ?>
                           <div class="input-group multi-img-details container ui-sortable">
                               <?php  if(is_array($goods)) { foreach($goods as $item) { ?>
                               <div data-name="goodsid" data-id="<?php  echo $item['id'];?>" class="multi-item">
                                   <img src="<?php  echo tomedia($item['thumb'])?>" class="img-responsive img-thumbnail">
                                   <div class="img-nickname"><?php  echo $item['title'];?></div>
                               </div>
                               <?php  } } ?>
                           </div>
                           <?php  } ?>
                       </div>
                   </div>

               </div>
           </div>
       </div>
   </div>

<?php if(cv('sale.enoughfree')) { ?>
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
                    $(":checkbox[name='data[enoughfree]']").click(function () {
                        if ($(this).prop('checked')) {
                            $("#enoughfree").show();
                        }
                        else {
                            $("#enoughfree").hide();
                        }
                    })
                   

                })
         
             
	</script>

<?php  if(empty($new_area)) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareas', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareas', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareasNew', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareasNew', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
