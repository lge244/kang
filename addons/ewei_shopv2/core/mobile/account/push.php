<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Push_EweiShopV2Page extends MobilePage
{
    //推广奖
    public function pushCommission(){
        $today = date('Y-m-d',time());
        $tomorrow = date('Y-m-d',strtotime( "+1 day",time()));
        $today0 = strtotime($today);
        $tomorrow0 = strtotime($tomorrow);
        $pc = pdo_getall("ewei_shop_member",array('is_league'=>1),array('id'));
        $pr = [];
        foreach ($pc as $ka=>$va){
            $pid = $va['id'];
            $openids = m("share")->digui($va['id']);
            for($i = 0;$i < count($openids);$i++){
                $groupids[] = pdo_get("ewei_shop_member",array('id'=>$openids[$i]),array('openid'));
            }
            foreach ($groupids as $k=>$v){
                $todayAchievement[] =  pdo_getall("ewei_shop_order",array('openid' => $v['openid'],'status'=>3,"finishtime <" =>  $tomorrow0,'finishtime >' => $today0),array('price'));
            }
            $todayResult = "";
            foreach ($todayAchievement as $key=>$val){
                if(!empty($val)){
                    foreach($val as $vk){
                        $todayResult += $vk['price'];
                    }
                }
            }
            $commission = $todayResult * 0.03 * (1-0.12);
            $credit = pdo_get("ewei_shop_member",array('id'=>$va['id']),array('credit2'));
            $result = $credit['credit2']+$commission;
            pdo_update("ewei_shop_member",array('credit2'=>$result),array('id'=>$va['id']));
            pdo_insert("ewei_shop_commission_list",array('uid' => 0, 'getcomid' => $va['id'], 'commission' => $commission, 'status' => 7, 'create_time' => time()));
        }
    }
}