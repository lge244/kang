<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">直播间管理</span>
</div>

<div class="page-content">
<form action="./index.php" method="get" class="form-horizontal" plugins="form">
    <input type="hidden" name="c" value="site">
    <input type="hidden" name="a" value="entry">
    <input type="hidden" name="m" value="ewei_shopv2">
    <input type="hidden" name="do" value="web">
    <input type="hidden" name="r" value="live.room">
    <div class="page-toolbar">
        <div class="col-sm-6">
                   <span class="">
                        <a href="<?php  echo webUrl('live/room/add')?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> 添加新直播间</a>
                    </span>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group">
                <div class="input-group-select">
                    <select name="state" class="form-control" style="width:75px;">
                        <option value="">状态</option>
                        <option value="1">显示</option>
                        <option value="0">关闭</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name="isrecommand" class="form-control" style="width:75px;">
                        <option value="">推荐</option>
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name="cate" class="form-control" style="width:120px;">
                        <option value="">直播间名称</option>
                        <option value="90">直播间分类</option>
                    </select>
                </div>
                <input type="text" class=" form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"> <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"> 搜索</button> </span>
            </div>
        </div>
    </div>
</form>

<?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body" style="text-align: center;padding:30px;">
            未找到相关问题
        </div>
    </div>
<?php  } else { ?>
    <table class="table table-hover table-responsive">
        <thead class="navbar-inner">
        <tr>
            <th style="width:25px;">
                <input type="checkbox">
            </th>
            <th style="width:60px;">排序</th>
            <th>直播间名称</th>
            <th style="width: 120px;">直播间分类</th>
            <th style="width: 50px; text-align: center;">热门</th>
            <th style="width: 50px; text-align: center;">推荐</th>
            <th style="width: 70px; text-align: center;">状态</th>
            <th style="width: 190px;">操作</th>
        </tr>
        </thead>
        <tbody id="sort">
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
            <td><input type="checkbox"  value="<?php  echo $row['id'];?>"></td>
            <td>
                <a href="javascript:;" data-toggle="ajaxEdit" data-href="<?php  echo webUrl('live/room/property',array('type'=>'displayorder','id'=>$row['id']))?>"><?php  echo $row['displayorder'];?></a>
            </td>
            <td>
                <img src="<?php  echo tomedia($row['thumb'])?>" style="width:40px;height:40px;padding:1px;border:1px solid #ccc;"/>
                <!--<label class="label label-primary"><?php  echo $row['title'];?></label>
                <br />--><?php  echo $row['title'];?>
            </td>
            <td><?php  echo $row['name'];?></td>
            <td style="text-align: center;">
                <span class='label <?php  if($row['hot']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>'
                <?php if( ce('live.room' ,$item) ) { ?>
                data-toggle='ajaxSwitch'
                data-switch-value='<?php  echo $row['hot'];?>'
                data-switch-value0='0|否|label label-default|<?php  echo webUrl('live/room/property',array('type'=>'hot', 'value'=>1,'id'=>$row['id']))?>'
                data-switch-value1='1|是|label label-success|<?php  echo webUrl('live/room/property',array('type'=>'hot', 'value'=>0,'id'=>$row['id']))?>'
                <?php  } ?>><?php  if($row['hot']==1) { ?>是<?php  } else { ?>否<?php  } ?></span>
            </td>
            <td style="text-align: center;">
                <span class='label <?php  if($row['recommend']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>'
                <?php if( ce('live.room' ,$item) ) { ?>
                data-toggle='ajaxSwitch'
                data-switch-value='<?php  echo $row['recommend'];?>'
                data-switch-value0='0|否|label label-default|<?php  echo webUrl('live/room/property',array('type'=>'recommend', 'value'=>1,'id'=>$row['id']))?>'
                data-switch-value1='1|是|label label-success|<?php  echo webUrl('live/room/property',array('type'=>'recommend', 'value'=>0,'id'=>$row['id']))?>'
                <?php  } ?>><?php  if($row['recommend']==1) { ?>是<?php  } else { ?>否<?php  } ?></span>
            </td>
            <td style="text-align: center;">
                <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                <?php if( ce('live.room' ,$item) ) { ?>
                data-toggle='ajaxSwitch'
                data-switch-value='<?php  echo $row['status'];?>'
                data-switch-value0='0|关闭|label label-default|<?php  echo webUrl('live/room/property',array('type'=>'status', 'value'=>1,'id'=>$row['id']))?>'
                data-switch-value1='1|显示|label label-primary|<?php  echo webUrl('live/room/property',array('type'=>'status', 'value'=>0,'id'=>$row['id']))?>'
                <?php  } ?>><?php  if($row['status']==1) { ?>显示<?php  } else { ?>关闭<?php  } ?></span>
            </td>
            <td style="text-align:left;">
                <?php if(cv('live.room.console')) { ?>
                <a href="<?php  echo webUrl('live/room/console',array('id'=>$row['id']))?>" class="btn btn-default btn-sm btn-op btn-operation">
                          <span data-toggle="tooltip" data-placement="top" title="" data-original-title="操作台">
                              <i class="fa fa-desktop"></i>
                       </span>
                </a>
                <?php  } ?>
                <?php if( ce('live.room' ,$item) ) { ?>
                <a href="<?php  echo webUrl('live/room/edit',array('id'=>$row['id']))?>" class="btn btn-default btn-sm btn-op btn-operation">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="编辑">
                            <i class='icow icow-bianji2'></i>
                       </span>
                </a>
                <?php  } ?>
                <a class="btn btn-op btn-operation js-clip" data-href="<?php  echo mobileUrl('live/room', array('id' => $row['id']),true)?>">
                         <span data-toggle="tooltip" data-placement="top"  data-original-title="复制链接">
                           <i class='icow icow-lianjie2'></i>
                       </span>
                </a>
                <a href="javascript:void(0);" class="btn btn-op btn-operation" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<img src='<?php  echo $row['qrcode'];?>' width='130' alt='链接二维码'>" data-placement="auto right">
                    <i class="icow icow-erweima3"></i>
                </a>
                <a class="btn btn-op btn-operation" title="" href="<?php  echo webUrl('live/room/statistics', array('roomid' => $row['id']),true)?>">
                     <span data-toggle="tooltip" data-placement="top" title="" data-original-title="直播间统计">
                              <i class="icow icow-digital"></i>
                       </span>
                </a>
                <?php if( ce('live.room' ,$item) ) { ?>
                <a class="btn btn-op btn-operation" data-toggle="ajaxRemove"  href="<?php  echo webUrl('live/room/deleted', array('id' => $row['id']))?>" data-confirm="确认删除此直播间吗？">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                             <i class='icow icow-shanchu1'></i>
                        </span>
                </a>
                <?php  } ?>
            </td>
        </tr>
        <?php  } } ?>
        </tbody>
        <tfoot>
        <tr>
            <td class="text-right" colspan="8"><?php  echo $pager;?></td>
        </tr>
        </tfoot>
    </table>
<?php  } ?>
</div>
<script type="text/javascript">
    $(function () {
        $(".btn_delete").click(function () {
            var code = randomString(4);
            var id = $(this).attr("data-id");
            var title = $(this).attr("data-title");
            var html = "<span class='text-danger'>"+title+"</span>";
            var tishi = "<span class='text-info'>直播间删除后，该直播间所有聊天记录和订阅信息会清空</span><br />";
            tip.promptlive(""+tishi+"确认删除"+html+",请输入【"+code+"】确认删除",function () {
                var confirm = $("input[name=confirm]").val();
                if(code == confirm){
                    $.ajax({
                        type: 'get',
                        url: "<?php  echo webUrl('live/room/deleted')?>",
                        data: {id:id} ,
                        dataType:'json',
                        success: function (result) {
                            if(result.status==1){
                                location.href="<?php  echo webUrl('live/room')?>";
                            }else{
                                alert(result.message)
                            }
                        }
                    });
                }else if(confirm != '' && code != confirm){
                    alert("请输入正确的确认码");
                    return false;
                }else{
                    alert("请输入确认码");
                    return false;
                }
            },false);

        });
    })
    function randomString(len) {
        len = len || 32;
        var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
        var maxPos = $chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->