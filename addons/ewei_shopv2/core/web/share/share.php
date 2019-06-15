<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Share_EweiShopV2Page extends WebPage
{
    public function share($pid = '')
    {
        $a = 1;
        $pid = m('share')->getPid($pid);
        if($pid != 0){
            $this->share($pid);
            $a = $a++;
        }
        
    }

}
?>