<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .table_kf {display: none;}
    .table_kf.active {display: table-row-group;}
</style>
<div class="page-header">
    当前位置：<span class="text-primary">全返商品管理</span>
 </div>

<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type='hidden' id='tab' name='type' value="<?php  echo $_GPC['type'];?>"/>
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r"  value="sale.fullback" />

        <div class="page-toolbar">
            <span class=''>
                <table class="table-responsive" style="float:left;">
                    <tbody>
                    <tr>
                        <td>
                            <?php if(cv('sale.fullback.add')) { ?>
                                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('sale/fullback/add',array('type'=>$type))?>"><i class='fa fa-plus'></i> 添加商品</a>
                            <?php  } ?>
                            <?php if(cv('sale.fullback.edit'||'sale.fullback.add')) { ?>
                            <span class="form-horizontal">
                                <a  class="btn <?php  if($ishidden['ishidden']==false) { ?>btn-info<?php  } else { ?>btn-danger<?php  } ?> btn-sm" data-toggle="ajaxRemove" href="<?php  echo webUrl('sale/fullback/show')?>" data-confirm="确认要<?php  if($ishidden['ishidden']==false) { ?>隐藏<?php  } else { ?>显示<?php  } ?>吗？">
                                    <span data-toggle="tooltip" data-placement="top">会员中心<?php  if($ishidden['ishidden']==false) { ?>显示<?php  } else { ?>隐藏<?php  } ?></span>
                                </a>
                            </span>
                            <a class="btn btn-success btn-sm" data-toggle="ajaxModal" href="<?php  echo webUrl('sale.fullback.set')?>">
                                <i class='fa fa-gear'></i> 全返设置</a>
                            <?php  } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </span>
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <span class="input-group-select">
                         <select name="status" class="form-control select2" style="width:100px;" data-placeholder="状态">
                             <option value="0" <?php  if(empty($_GPC['status'])) { ?>selected<?php  } ?> >状态</option>
                             <option value="1" <?php  if($_GPC['status']==1) { ?>selected<?php  } ?> >开启</option>
                             <option value="-1" <?php  if($_GPC['status']==-1) { ?>selected<?php  } ?> >关闭</option>
                         </select>
                    </span>
                    <input type="text" class=" form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="商品名称">
                    <span class="input-group-btn">
                        <button class="btn  btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <form action="" method="post" class="form-horizontal">
        <div class="row">
            <?php  if(count($gifts)>0) { ?>
            <div class="col-md-12">
                <table class="table table-responsive">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:25px;"><input type='checkbox' /></th>
                        <th style="width:60px;text-align:center;">排序</th>
                        <th style="width:80px;">商品名称</th>
                        <th  style="">&nbsp;</th>
                        <th  style="">&nbsp;</th>
                        <th  style="width:60px;text-align: center;" >状态</th>
                        <th style="width:65px;text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody class=" table_kf active" id="tab_all">
                    <?php  if(is_array($gifts)) { foreach($gifts as $item) { ?>
                    <tr>
                        <td>
                            <input type='checkbox'  value="<?php  echo $item['id'];?>"/>
                        </td>
                        <td style='text-align:center;'>
                            <?php if(cv('sale.fullback.edit')) { ?>
                            <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('sale/fullback/change',array('typechange'=>'displayorder','id'=>$item['id']))?>" ><?php  echo $item['displayorder'];?></a>
                            <?php  } else { ?>
                            <?php  echo $item['displayorder'];?>
                            <?php  } ?>
                        </td>
                        <td>
                            <img src="<?php  echo tomedia($item['thumb'])?>" style="width:40px;height:40px;padding:1px;border:1px solid #ccc;"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                        </td>
                        <td class='full' style="overflow-x: hidden">
                            <?php if(cv('sale.fullback.edit')) { ?>
                            <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('sale/fullback/change',array('typechange'=>'title','id'=>$item['id']))?>" ><?php  echo $item['titles'];?></a>
                            <?php  } else { ?>
                            <?php  echo $item['titles'];?>
                            <?php  } ?>
                        </td>
                        <td></td>
                        <td  style="overflow:visible;">
                            <span class='label <?php  if($item['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                            <?php if(cv('sale.fullback.edit')) { ?>
                            data-toggle='ajaxSwitch'
                            data-confirm = "确认是<?php  if($item['status']==1) { ?>关闭<?php  } else { ?>开启<?php  } ?>？"
                            data-switch-refresh='true'
                            data-switch-value='<?php  echo $item['status'];?>'
                            data-switch-value0='0|关闭|label label-default|<?php  echo webUrl('sale/fullback/status',array('status'=>1,'id'=>$item['id']))?>'
                            data-switch-value1='1|开启|label label-primary|<?php  echo webUrl('sale/fullback/status',array('status'=>0,'id'=>$item['id']))?>'
                            <?php  } ?>>
                            <?php  if($item['status']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?></span>
                        </td>
                        <td  style="overflow:visible;position:relative;text-align: right;">
                            <?php if(cv('sale.fullback.edit|sale.fullback.view')) { ?>
                            <a  class='btn btn-op btn-operation' href="<?php  echo webUrl('sale/fullback/edit', array('type'=>$_GPC['type'],'id' => $item['id'],'page'=>$page))?>" title="<?php if(cv('sale.fullback.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('sale.fullback.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>"><i class="icow icow-bianji2"></i></span>
                            </a>
                            <?php  } ?>
                            <?php if(cv('sale.fullback.delete1')) { ?>
                            <a  class='btn btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('sale/fullback/delete1', array('id' => $item['id']))?>" data-confirm='如果此活动存在购买记录，会无法关联到商品, 确认要彻底删除吗?？'>
                                <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i></span>
                            </a>
                            <?php  } ?>
                        </td>
                    </tr>
                    <?php  if(!empty($item['merchname']) && $item['merchid'] > 0) { ?>
                    <tr>
                        <td colspan='3' style='text-align: left;border-top:none;padding:5px 0;' class='aops'>
                            <span class="text-default" style="margin-left: 95px;">商户名称:</span><span class="text-info"><?php  echo $item['merchname'];?></span>
                        </td>
                        <td colspan='3' style='text-align: right;border-top:none;padding:5px 0;' class='aops'></td>
                    </tr>
                    <?php  } ?>
                    <?php  } } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <input type='checkbox' />
                        </td>
                        <td colspan="3">
                            <div class="btn-group">
                                <?php if(cv('sale.fullback.edit')) { ?>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('sale/fullback/status',array('status'=>1))?>">
                                    <i class='icow icow-qiyong'></i> 开启
                                </button>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('sale/fullback/status',array('status'=>0))?>">
                                    <i class='icow icow-jinyong'></i> 关闭
                                </button>
                                <?php  } ?>
                                <?php if(cv('sale.fullback.delete1')) { ?>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要彻底删除吗?" data-href="<?php  echo webUrl('sale/fullback/delete1')?>">
                                    <i class='icow icow-shanchu1'></i></i> 删除
                                </button>
                                <?php  } ?>
                            </div>
                        </td>
                        <td colspan="3" style="text-align: right">
                            <?php  echo $pager;?>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <?php  } else { ?>
            <div class="panel panel-default">
                <div class="panel-body empty-data">暂时没有任何记录</div>
            </div>
            <?php  } ?>
        </div>

    </form>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
