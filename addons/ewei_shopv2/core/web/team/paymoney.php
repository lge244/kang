<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Paymoney_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $list = pdo_getall('bob_record');
        $level = pdo_getall('ewei_shop_member_level', array(), array('id', 'levelname'));

        foreach ($list as $k => $v) {
            $member = pdo_get('ewei_shop_member',array('id'=>$v['uid']),array('bob_num','level'));
            foreach ($level as $k2=>$v2){
                if ($member['level'] == $v2['id']){
                    $member['level'] = $v2['levelname'];
                }
            }
            $list[$k]['info'] = $member;
        }
        include $this->template();
    }
}