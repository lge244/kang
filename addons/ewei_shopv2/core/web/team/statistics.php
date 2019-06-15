<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Statistics_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $day = date('Y-m-d',strtotime("-1 days"));
        $Totalbonuspayment = pdo_get('ewei_statistics',array('date' =>$day),array('Totalbonuspayment'));
        $totalTodayMoney = 0;
        $sumPrice = 0;
        $total = pdo_getall('ewei_shop_member',array('sum_price !='=>0),array('sum_price','today_price2'));

        foreach ($total as $k => $v) {
            $totalTodayMoney += $v['today_price2'];
            $sumPrice += $v['sum_price'];
        }
        $sum = ($Totalbonuspayment['Totalbonuspayment']/$sumPrice)*100;

        $statistics = pdo_getall('ewei_statistics');
        foreach ($statistics as $k=>$v){
               $data[$k]['id'] = $statistics[$k]['id'];
               $data[$k]['Totalbonuspayment'] = $statistics[$k]['Totalbonuspayment'] - $statistics[$k-1]['Totalbonuspayment'];
               $data[$k]['TodayPerformance'] = $statistics[$k]['TodayPerformance'];
               $data[$k]['partitionRatio'] = $statistics[$k]['partitionRatio'];
               $data[$k]['time'] = $statistics[$k]['time'];
        }
        include $this->template();
    }
}