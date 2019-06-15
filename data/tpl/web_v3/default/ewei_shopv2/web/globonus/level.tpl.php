<?php defined('IN_IA') or exit('Access Denied');?> <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
 <div class="page-header">
     当前位置：<span class="text-primary">股东等级</span>
</div>
<div class="page-content">
    <div class="page-sub-toolbar">
            <span class=''>

		 <?php if(cv('globonus.level.add')) { ?>
                            <a class='btn btn-primary btn-sm' data-toggle='ajaxModal' href="<?php  echo webUrl('globonus/level/add')?>"><i class="fa fa-plus"></i> 添加新等级</a>
		 <?php  } ?>

	</span>
    </div>
            <table class="table table-responsive table-hover">
                <thead>
                    <tr>
                        <th style='width:160px;'>等级名称</th>
                        <th>分红比例</th>
                        <th>升级条件</th>
                        <th style="width: 75px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr <?php  if($row['id']=='default') { ?>style='background:#f2f2f2'<?php  } ?>>
                        <td><?php  echo $row['levelname'];?><?php  if($row['id']=='default') { ?>【默认等级】<?php  } ?></td>
                          <td><?php  echo number_format((float)$row['bonus'],4)?>%</td>
                          <td>	<?php  if($row['id']!='default') { ?>
						<?php  if($leveltype==0) { ?><?php  if($row['ordermoney']>0) { ?>分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==1) { ?><?php  if($row['ordermoney']>0) { ?>一级分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==2) { ?><?php  if($row['ordercount']>0) { ?>分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==3) { ?><?php  if($row['ordercount']>0) { ?>一级分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==4) { ?><?php  if($row['ordermoney']>0) { ?>自购订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==5) { ?><?php  if($row['ordercount']>0) { ?>自购订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==6) { ?><?php  if($row['downcount']>0) { ?>下级总人数满 <?php  echo $row['downcount'];?> 个（股东+非股东） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==7) { ?><?php  if($row['downcount']>0) { ?>一级下级人数满 <?php  echo $row['downcount'];?> 个（股东+非股东） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==8) { ?><?php  if($row['downcount']>0) { ?>团队总人数满 <?php  echo $row['downcount'];?> 个（股东） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==9) { ?><?php  if($row['downcount']>0) { ?>一级团队人数满 <?php  echo $row['downcount'];?> 个（股东） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						 
						<?php  if($leveltype==10) { ?><?php  if($row['commissionmoney']>0) { ?>已提现佣金总金额满 <?php  echo $row['commissionmoney'];?> 元<?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
                              <?php  if($leveltype==11) { ?><?php  if($row['bonusmoney']>0) { ?>已发放分红总金额满 <?php  echo $row['bonusmoney'];?> 元<?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
					<?php  } else { ?>
					默认等级
					<?php  } ?>
                          </td>
                        <td>
							<?php if(cv('globonus.level.edit')) { ?>
                            <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxModal'  href="<?php  echo webUrl('globonus/level/edit', array('id' => $row['id']))?>" title="<?php if(cv('globonus.level.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('globonus.level.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                    <?php if(cv('globonus.level.edit')) { ?>
                                    <i class='icow icow-bianji2'></i>
                                    <?php  } else { ?>
                                   <i class='icow icow-chakan-copy'></i>
                                    <?php  } ?>

                                </span>
                            </a>
                            <?php  } ?> 
                            <?php  if($row['id']!='default') { ?>
							 <?php if(cv('globonus.level.delete')) { ?>
								<a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove'  href="<?php  echo webUrl('globonus/level/delete', array('id' => $row['id']))?>" data-confirm="确认删除此等级吗？">
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                       <i class='icow icow-shanchu1'></i>
                                    </span>
                                </a>
                        </td>
						<?php  } ?>
						<?php  } ?>

                    </tr>
                    <?php  } } ?>
                
                </tbody>
            </table>
</div>
 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


<!--青岛易联互动网络科技有限公司-->