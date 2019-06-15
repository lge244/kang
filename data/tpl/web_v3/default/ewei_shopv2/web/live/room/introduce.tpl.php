<?php defined('IN_IA') or exit('Access Denied');?><div class="region-goods-details row" style="margin-left:0;margin-right:0;">
    <div class="region-goods-left col-sm-2">
        商品信息
    </div>
    <div class="region-goods-right col-sm-10">
        <div class="form-group">
            <div class="col-sm-12 col-xs-12">
                <?php if( ce('live.room' ,$item) ) { ?>
                <div>

                    <?php  echo tpl_goods_selector('goodsarr',$goods,
                                array(
                                        'option'=>true,
                                        'condition'=>' and deleted = 0 and status = 1 and total>0',
                                        'ophtml'=>'注意',
                                        'column'=>array(
                                            array('title'=>'直播间价格','name'=>'liveprice')
                                         )
                                 )
                    );?>
                </div>
                <span class='help-block'>提示：直播商品可在直播中显示，且观看直播的用户可在直播中自由购买已添加的商品。</span>
                <?php  } else { ?>
                <?php  if(!empty($goods)) { ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th style='width:80px;'>商品名称</th>
                        <th style='width:220px;'></th>
                        <th>直播金额</th>
                    </tr>
                    </thead>
                    <tbody id="param-items" class="ui-sortable">
                    <?php  if(is_array($goods)) { foreach($goods as $row) { ?>
                    <tr class="multi-product-item" data-id="<?php  echo $row['goodsid'];?>">
                        <input type="hidden" class="form-control img-textname" readonly="" value="<?php  echo $row['title'];?>">
                        <input type="hidden" value="<?php  echo $row['goodsid'];?>" name="goodsid[]">
                        <td style="width:80px;">
                            <img src="<?php  echo tomedia($row['thumb'])?>" style="width:70px;border:1px solid #ccc;padding:1px">
                        </td>
                        <td style="width:220px;"><?php  echo $row['title'];?></td>
                        <td><a class="btn btn-default btn-sm" data-toggle="ajaxModal"
                               href="<?php  echo webUrl('live/room/hasoption',array('goodsid'=>$row['goodsid'],'id'=>$row['id']))?>" id="optiontitle<?php  echo $row['goodsid'];?>">&yen;<?php  echo $goods['liveprice'];?></a>
                            <input type="hidden" id="livegoods<?php  echo $row['goodsid'];?>" value="" name="livegoods[<?php  echo $row['goodsid'];?>]">
                            <input type="hidden" value="<?php  echo $row['liveprice'];?>" name="liveprice<?php  echo $goods['goodsid'];?>">
                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
                <?php  } else { ?>
                暂无商品
                <?php  } ?>
                <?php  } ?>
            </div>
        </div>

    </div>
</div>