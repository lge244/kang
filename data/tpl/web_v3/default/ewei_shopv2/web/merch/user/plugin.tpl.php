<?php defined('IN_IA') or exit('Access Denied');?>

<?php  if(is_array($plugins_list)) { foreach($plugins_list as $plist) { ?>
<div class="form-group">
    <label class="col-lg control-label"><?php  echo $plist['name'];?> </label>
    <div class="col-sm-8">
        <?php if( ce('merch.user' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name="pluginset[<?php  echo $plist['identity'];?>][close]" value="0" <?php  if(empty($item['pluginset'][$plist['identity']]['close'])) { ?>checked<?php  } ?> /> 开启
        </label>

        <label class="radio-inline">
            <input type="radio" name="pluginset[<?php  echo $plist['identity'];?>][close]" value="1" <?php  if(!empty($item['pluginset'][$plist['identity']]['close'])) { ?>checked<?php  } ?> />禁用
        </label>
        <?php  } else { ?>
        <div class="form-control-static">
            <?php  if($item['status']==0) { ?>
            待入驻
            <?php  } else if($item['stauts']==1) { ?>
            允许入驻
            <?php  } else if($item['stauts']==2) { ?>
            暂停中
            <?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<?php  } } ?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->