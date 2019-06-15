<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .table>thead>tr>td.full, .table>tbody>tr>td.full, .table>tfoot>tr>td.full{overflow: hidden;}
</style>
<div class="page-header">
    当前位置：<span class="text-primary">商品管理</span>
   </div>
<div class="page-content">
        <form action="./index.php" method="get" class="form-horizontal" plugins="form">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="ewei_shopv2" />
            <input type="hidden" name="do" value="web" />
            <input type="hidden" name="r"  value="creditshop.goods" />
        <div class="page-toolbar">
            <div class="col-sm-5">
                 <span class='pull-left'>
                    <?php if(cv('creditshop.goods.add')) { ?>
                        <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('creditshop/goods/add')?>"><i class='fa fa-plus'></i> 添加商品</a>
                    <?php  } ?>
                </span>
            </div>
            <div class="col-sm-6 pull-right">
                <!--<select name='status' class='form-control  input-sm' style='width:100px;'  >
                    <option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>
                    <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>暂停</option>
                    <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?> >开启</option>
                </select>-->
                <div class="input-group">
                    <div class="input-group-select">
                        <select name="cate" class='form-control input-sm select-sm' style="width:120px;">
                            <option value="" <?php  if(empty($_GPC['cate'])) { ?>selected<?php  } ?> >商品分类</option>
                            <?php  if(is_array($category)) { foreach($category as $cate) { ?>
                            <option value='<?php  echo $cate['id'];?>' <?php  if($_GPC['cate']==$cate['id']) { ?>selected<?php  } ?>><?php  echo $cate['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="input-group-select">
                        <select name='type' class='form-control input-sm' style='width:100px;'  >
                            <option value='' <?php  if($_GPC['type']=='') { ?>selected<?php  } ?>>类型</option>
                            <option value='0' <?php  if($_GPC['type']=='0') { ?>selected<?php  } ?>>兑换</option>
                            <option value='1' <?php  if($_GPC['type']=='1') { ?>selected<?php  } ?> >抽奖</option>
                        </select>
                    </div>
                    <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"> 搜索</button> </span>
                </div>
            </div>
        </div>
            <ul class="nav nav-tabs" id="myTab">
                <li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='sell') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/goods',array('tab'=>'sell'))?>">出售中</a></li>
                <li <?php  if($_GPC['tab']=='sellout') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/goods',array('tab'=>'sellout'))?>">已售罄</a></li>
                <li <?php  if($_GPC['tab']=='warehouse') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/goods',array('tab'=>'warehouse'))?>">仓库中</a></li>
                <li <?php  if($_GPC['tab']=='recycle') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/goods',array('tab'=>'recycle'))?>">回收站</a></li>
            </ul>
    </form>
    <form action="" method="post">
        <?php  if($list) { ?>
        <div class="page-table-header" style="border: none;">
            <input type="checkbox">
            <div class="btn-group">
                <?php if(cv('creditshop.goods.edit')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('creditshop/goods/status',array('status'=>0))?>">
                    <i class='icow icow-xiajia3'></i> 下架</button>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('creditshop/goods/status',array('status'=>1))?>">
                    <i class='icow icow-shangjia2'></i> 上架</button>
                <?php  } ?>
                <?php if(cv('creditshop.goods.delete' && $_GPC['tab']!='recycle' && $_GPC['tab']!='warehouse')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除吗?" data-href="<?php  echo webUrl('creditshop/goods/delete')?>">
                    <i class='icow icow icow-shanchu1'></i> 删除
                </button>
                <?php  } ?>
                <?php if(cv('creditshop.goods.delete' && $_GPC['tab']!='recycle')) { ?>
                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确定要彻底删除该商品吗?" data-href="<?php  echo webUrl('creditshop/goods/deleted')?>">
                    <i class='icow icow-shanchu5'></i> 彻底删除
                </button>
                <?php  } ?>
                <?php if(cv('creditshop.goods.delete' && $_GPC['tab']=='recycle')) { ?>
                <button class="btn btn-default btn-sm" type="button" data-toggle='batch-remove' data-confirm="确定要恢复商品到仓库吗?" data-href="<?php  echo webUrl('creditshop/goods/recycle')?>">
                    <i class='fa fa-reply'></i> 恢复商品到仓库
                </button>
                <?php  } ?>
            </div>
        </div>
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th style="width:25px;"></th>
                <th style="width:50px;">排序</th>
                <th style="width:60px;">商品</th>
                <th>&nbsp;</th>
                <th style="width:90px;">商品类型</th>
                <th style="width:90px;">活动类型</th>
                <th style="width:90px;">消耗</th>
                <th style="width: 90px;">参与/浏览</th>
                <th style="width: 100px;text-align: center;">状态</th>
                <th style="width: 120px;text-align: center;">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td>
                        <input type='checkbox'   value="<?php  echo $row['id'];?>"/>
                    </td>
                    <td>
                       <?php if(cv('creditshop.adv.edit')) { ?>
                            <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('creditshop/goods/property',array('type'=>'displayorder','id'=>$row['id']))?>" ><?php  echo $row['displayorder'];?></a>
                        <?php  } else { ?>
                            <?php  echo $row['displayorder'];?>
                        <?php  } ?>
                    </td>
                    <td>
                        <img src="<?php  echo tomedia($row['thumb'])?>" style="width:40px;height:40px;padding:1px;border:1px solid #ccc;" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </td>
                    <td class='full'>
                        <?php  if(!empty($row['merchname']) && $row['merchid'] > 0) { ?>
                            <span class="text-default">商户名称:</span><span class="text-info"><?php  echo $row['merchname'];?></span>
                        <?php  } ?>
                      <?php  if(!empty($row['subtitle'])) { ?><span class='label label-warning'><?php  echo $row['subtitle'];?></span><br/><?php  } ?>
                      <span class='text-danger'>[<?php  echo $category[$row['cate']]['name'];?>]</span><br/>
                        <?php  echo $row['title'];?>
                    </td>
                    <td style="text-align: center;">
                        <?php  if($row['goodstype']==0) { ?>
                        <span class='text-primary'>商品</span>
                        <?php  } else if($row['goodstype']==1) { ?>
                        <span class='text-success'>优惠券</span>
                        <?php  } else if($row['goodstype']==2) { ?>
                        <span class='text-warning'>余额</span>
                        <?php  } else if($row['goodstype']==3) { ?>
                        <span class='text-danger'>红包</span>
                        <?php  } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php  if($row['type']==1) { ?>
                        <span class='text-danger'>抽奖</span>
                        <?php  } else { ?>
                        <span class='text-primary'>兑换</span>
                        <?php  } ?>
                    </td>
                    <td>
                        <?php  if($row['credit']>0) { ?>-<?php  echo $row['credit'];?>积分<br/><?php  } ?>
                        <?php  if($row['money']>0) { ?>
                        -<?php  echo $row['money'];?>现金
                        <?php  } ?>
                    </td>
                    <td><?php  echo $row['joins'];?>/<?php  echo $row['views'];?></td>
                    <td style="text-align: center;">
                        <span style="display: none;" class='label <?php  if($row['istop']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>'
                          <?php if(cv('creditshop.goods.edit')) { ?>
                              data-toggle='ajaxSwitch'
                              data-switch-value='<?php  echo $row['istop'];?>'
                              data-switch-value0='0||label label-default|<?php  echo webUrl('creditshop/goods/property',array('type'=>'istop', 'value'=>1,'id'=>$row['id']))?>'
                              data-switch-value1='1||label label-success|<?php  echo webUrl('creditshop/goods/property',array('type'=>'istop', 'value'=>0,'id'=>$row['id']))?>'
                          <?php  } ?>>
                          置顶</span>
                        <span class='label <?php  if($row['isrecommand']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>'
                          <?php if(cv('creditshop.goods.edit')) { ?>
                              data-toggle='ajaxSwitch'
                              data-switch-value='<?php  echo $row['isrecommand'];?>'
                              data-switch-value0='0||label label-default|<?php  echo webUrl('creditshop/goods/property',array('type'=>'isrecommand', 'value'=>1,'id'=>$row['id']))?>'
                              data-switch-value1='1||label label-success|<?php  echo webUrl('creditshop/goods/property',array('type'=>'isrecommand', 'value'=>0,'id'=>$row['id']))?>'
                          <?php  } ?>>
                          推荐</span>
                        <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                          <?php if(cv('creditshop.goods.edit')) { ?>
                              data-toggle='ajaxSwitch'
                              data-switch-value='<?php  echo $row['status'];?>'
                              data-switch-value0='0|暂停|label label-default|<?php  echo webUrl('creditshop/goods/property',array('type'=>'status', 'value'=>1,'id'=>$row['id']))?>'
                              data-switch-value1='1|启动|label label-primary|<?php  echo webUrl('creditshop/goods/property',array('type'=>'status', 'value'=>0,'id'=>$row['id']))?>'
                          <?php  } ?>>
                          <?php  if($row['status']==1) { ?>启动<?php  } else { ?>暂停<?php  } ?></span>
                     </td>
                    <td style="text-align: center;">
                         <?php if(cv('creditshop.goods.view|creditshop.goods.edit')) { ?>
                             <a class='btn btn-default btn-sm btn-op btn-operation' href="<?php  echo webUrl('creditshop/goods/edit',array('id' => $row['id']));?>" title="">
                                 <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('creditshop.goods.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                     <?php if(cv('creditshop.goods.edit')) { ?>
                                        <i class='icow icow-bianji2'></i>
                                     <?php  } else { ?>
                                        <i class='icow icow-xianshi'></i>
                                     <?php  } ?>

                                   </span>
                             </a>
                         <?php  } ?>
                         <?php if(cv('creditshop.goods.delete' && $_GPC['tab']!='warehouse' && $_GPC['tab']!='recycle')) { ?>
                            <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('creditshop/goods/delete',array('id' => $row['id']));?>" data-confirm="确定要删除该商品吗？" title="删除">
                                 <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                     <i class="icow icow-shanchu1"></i>
                                   </span>
                            </a>
                         <?php  } ?>
                         <?php if(cv('creditshop.goods.delete')) { ?>
                        <?php  if($_GPC['tab']=='recycle') { ?>
                         <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('creditshop/goods/deleted',array('id' => $row['id']));?>" data-confirm="确定要彻底删除该商品吗？" title="彻底删除">
                             <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                 <i class="icow icow-shanchu1"></i>
                               </span>
                             </a>
                         <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('creditshop/goods/recycle',array('id' => $row['id']));?>" data-confirm="确定要恢复商品到仓库吗？" title="恢复商品到仓库">
                             <span data-toggle="tooltip" data-placement="top" title="" data-original-title="恢复商品到仓库">
                                     <i class="icow icow-2"></i>
                                   </span>
                         </a>
                        <?php  } ?> <?php  } ?>
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="checkbox"></td>
                    <td colspan="3">
                        <div class="btn-group">
                            <?php if(cv('creditshop.goods.edit')) { ?>
                            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('creditshop/goods/status',array('status'=>0))?>">
                                <i class='icow icow-xiajia3'></i> 下架</button>
                            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('creditshop/goods/status',array('status'=>1))?>">
                                <i class='icow icow-shangjia2'></i> 上架</button>
                            <?php  } ?>
                            <?php if(cv('creditshop.goods.delete' && $_GPC['tab']!='recycle' && $_GPC['tab']!='warehouse')) { ?>
                            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除吗?" data-href="<?php  echo webUrl('creditshop/goods/delete')?>">
                                <i class='icow icow icow-shanchu1'></i> 删除
                            </button>
                            <?php  } ?>
                            <?php if(cv('creditshop.goods.delete' && $_GPC['tab']!='recycle')) { ?>
                            <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确定要彻底删除该商品吗?" data-href="<?php  echo webUrl('creditshop/goods/deleted')?>">
                                <i class='icow icow-shanchu5'></i> 彻底删除
                            </button>
                            <?php  } ?>
                            <?php if(cv('creditshop.goods.delete' && $_GPC['tab']=='recycle')) { ?>
                            <button class="btn btn-default btn-sm" type="button" data-toggle='batch-remove' data-confirm="确定要恢复商品到仓库吗?" data-href="<?php  echo webUrl('creditshop/goods/recycle')?>">
                                <i class='fa fa-reply'></i> 恢复商品到仓库
                            </button>
                            <?php  } ?>
                        </div>
                    </td>
                    <td colspan="6" class="text-right">
                        <?php  echo $pager;?>
                    </td>
                </tr>
            </tfoot>
        </table>
     <?php  } else { ?>
        <div class='panel panel-default'>
            <div class='panel-body' style='text-align: center;padding:30px;'>
                暂时没有任何商品
            </div>
        </div>
        <?php  } ?>

    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
 