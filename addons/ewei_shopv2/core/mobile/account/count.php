<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Count_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        $todayMoney = 0;
        $todayRecord = pdo_getall('bob_record', array('date' => date('Y-m-d')), array('teamBonus'));
        $totalMoney = pdo_getall('ewei_shop_member',array('credit2 !='=>0),array('credit2'));

        foreach ($totalMoney as $k=>$v){
            $todayMoney += $v['credit2'];
        }
        $day = date('Y-m-d',strtotime("-1 days"));
        $Totalbonuspayment = pdo_get('ewei_statistics',array('date' =>$day),array('Totalbonuspayment'));
        $todayMoney = $todayMoney - $Totalbonuspayment['Totalbonuspayment'];

        $totalTodayMoney = 0;
        $total = pdo_getall('ewei_shop_member',array(),array('today_price2'));
        foreach ($total as $k => $v) {
            $totalTodayMoney += $v['today_price2'];
        }
		if($totalTodayMoney == 0){
        $totalTodayMoney =1;
        }
        $todayRange = ($todayMoney/$totalTodayMoney)*100;
if($totalTodayMoney == 1){
        $todayRange =100;
        }
        $data['Totalbonuspayment'] = $todayMoney;
        $data['TodayPerformance'] = $totalTodayMoney;
        $data['partitionRatio'] = $todayRange;
        $data['time'] = time();
        $data['date'] = date('Y-m-d');

        pdo_insert('ewei_statistics',$data);

        pdo_update('ewei_shop_member',array('today_price2'=>0));
    }
}