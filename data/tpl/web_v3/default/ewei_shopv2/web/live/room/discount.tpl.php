<?php defined('IN_IA') or exit('Access Denied');?><div class="alert alert-primary">
    <p>说明:</p>
    <p> 若不填写每人限领数量或限领数量设置为0，则该优惠券可在直播期间无限次领取。</p>
</div>
<div class="region-goods-details row" style="margin-left:0;margin-right:0;">
    <div class="region-goods-left col-sm-2">
        优惠券设置
    </div>
    <div class="region-goods-right col-sm-10">
        <div class="form-group">
            <div class="col-sm-12 col-xs-12">
                <?php if( ce('live.room' ,$item) ) { ?>
                <label class="radio-inline"><input type="radio" name='iscoupon' value="1" <?php  if($item['iscoupon']==1) { ?>checked<?php  } ?> /> 开启</label>
                <label class="radio-inline"><input type="radio" name='iscoupon' value="0" <?php  if(empty($item['iscoupon'])) { ?>checked<?php  } ?> /> 关闭</label>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(empty($item['iscoupon'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group iscoupon" <?php  if(empty($item['iscoupon'])) { ?>style="display:none;"<?php  } ?>>
            <div class="col-sm-12 col-xs-12">
                <?php if( ce('live.room' ,$item) ) { ?>
                <?php  echo tpl_selector('couponid',array('required'=>false,'multi'=>1,'type'=>'coupon','autosearch'=>1, 'preview'=>true,'url'=>webUrl('sale/coupon/query'),'text'=>'couponname','items'=>$coupon,'readonly'=>true,'buttontext'=>'选择优惠券','placeholder'=>'请选择优惠券'))?>
                <?php  } else { ?>
                <?php  if(!empty($goods)) { ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th style='width:100px;'>优惠券名称</th>
                        <th style='width:200px;'></th>
                        <th>优惠券总数</th>
                        <th>每人限领数量</th>
                    </tr>
                    </thead>
                    <tbody id="param-items" class="ui-sortable">
                    <?php  if(is_array($coupon)) { foreach($coupon as $row) { ?>
                    <tr class='multi-product-item' data-id="<?php  echo $row['id'];?>">
                        <input type='hidden' class='form-control img-textname' readonly='' value="<?php  echo $row['couponname'];?>">
                        <input type='hidden' value="<?php  echo $row['id'];?>" name="couponid[]">
                        <td style='width:80px;'>
                            <img src="<?php  echo tomedia($row['thumb'])?>" style='width:70px;border:1px solid #ccc;padding:1px'>
                        </td>
                        <td style='width:220px;'><?php  echo $row['couponname'];?></td>
                        <td>
                            <input class='form-control valid' type='text' disabled value="<?php  echo $item['coupontotal'];?>" name="coupontotal<?php  echo $row['id'];?>">
                        </td>
                        <td>
                            <input class='form-control valid' type='text' disabled value="<?php  echo $item['couponlimit'];?>" name="couponlimit<?php  echo $row['id'];?>">
                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
                <?php  } else { ?>
                暂无优惠券
                <?php  } ?>
                <?php  } ?>
            </div>
        </div>
    </div>
</div><script type="text/javascript">
    $(function () {
        $("input[name=packetprice]").change(function () {
            packet($(this),'price');
        });
        $("input[name=packettotal]").change(function () {
            packet($(this),'total');
        });
        $("input[name=packetmoney]").change(function () {
            packet($(this),'money');
        });
        /*优惠券开启关闭*/
        $("input[name=iscoupon]").off("click").on("click",function () {
            var _this = $(this).val();
            if(_this>0){
                $(".iscoupon").show();
            }else{
                $(".iscoupon").hide();
            }
        });
    });
    function packet(t,type) {
        if(t.val()<0){
            t.val(0);
        }
        var packetmoney = parseFloat($("input[name=packetmoney]").val()).toFixed(2);
        var packettotal = parseInt($("input[name=packettotal]").val());
        var packetprice = parseFloat($("input[name=packetprice]").val()).toFixed(2);
        if(type=='price'){
            $("input[name=packettotal]").val(parseInt(packetmoney/packetprice));
        }else if(type=='total'){
            $("input[name=packetprice]").val(parseFloat(packetmoney/packettotal).toFixed(2));
        }else if(type=='money'){
            $("input[name=packetprice]").val(parseFloat(packetmoney/packettotal).toFixed(2));
        }
    }
</script>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->