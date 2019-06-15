<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Promotion_EweiShopV2Page extends MobilePage {
    public function main(){
        global $_W, $_GPC;
        $goods = pdo_getall("ewei_shop_goods",array('promotion'=>1));
        foreach ($goods as $k=>$v){
            $goods[$k]['thumb'] = "http://".$_SERVER['SERVER_NAME'].'/attachment/'.$v['thumb'];
        }
        include $this->template();
    }
}