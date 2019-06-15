<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    /**
     * 拿到所有没有邀请过好友的用户信息
     * 如果是砖石会员再判断总业绩是否成立
     * 再根据总业绩极差比例
     * 让日业绩相乘
     * 如果不是砖石会员 直接放入数组
     * 接着再找相同上级的用户 整个团队的业绩是否符合
     */
    public function main()
    {
//        获取没有邀请过好友的用户
        $member = pdo_getall('ewei_shop_member', array('inviter ' => 0), array('id', 'fid', 'level', 'today_price', 'sum_price'));
//        获取级差规则
        $team_range = pdo_getall('team_range');
//        级差格式化
        foreach ($team_range as $k => $v) {
            $range[$k]['total'] = $v['total'] * 10000;
            $range[$k]['ratio'] = $v['ratio'] / 100;
        }
//        相同上级的好友合并为团队
        foreach ($member as $k => $v) {
            if (!isset($tem[$v['fid']])) {
                $tem[$v['fid']][$v['id']] = $v;
            } else {
                $tem[$v['fid']][$v['id']] = $v;
            }
        }
//         计算团队的总业绩 以及团队产生的当天业绩 团队享受的级差比例
        foreach ($tem as $k => $v) {
            if ($k <= 0) {
                unset($tem[$k]);
            }
//            计算团队的总业绩 以及当天业绩
            foreach ($v as $key => $value) {
                $tem[$k]['teamTodayPrice'] += $value['today_price'];
                $tem[$k]['teamSumPrice'] += $value['sum_price'];
            }
//            计算团队享受的级差比例
            foreach ($range as $key => $value) {
                if ($tem[$k]['teamSumPrice'] >= $range[$key]['total'] && $tem[$k]['teamSumPrice'] < $range[$key + 1]['total']) {
                    $tem[$k]['teamProportion'] = $range[$key]['ratio'];
                } else {
                    $tem[$k]['teamProportion'] = 0;
                }
            }
        }
        $member = $this->main2($range, $tem);
        $members = pdo_getall('ewei_shop_member', array(), array('id', 'fid', 'level', 'nickname', 'mobile'));
        $level = pdo_getall('ewei_shop_member_level', array(), array('id', 'levelname'));
        foreach ($members as $k => $v) {
            foreach ($level as $k2=>$v2){
                if ($v['level'] == $v2['id']){
                    $members[$k]['level'] = $v2['levelname'];
                }
            }
        }
        foreach ($members as $k => $v) {
            foreach ($member as $key => $value) {
                if ($v['id'] == $value['id']) {
                    unset($value['id']);
                    unset($value['fid']);
                    unset($value['level']);
                    $members[$k]['info'] = $value;
                }
            }
        }
        include($this->template());
    }

    public function main2($range, $tem)
    {
        $member = pdo_getall('ewei_shop_member', array('inviter >' => 0, 'id !=' => 1), array('id', 'fid', 'level', 'today_price', 'sum_price'));
        foreach ($member as $k => $v) {
            foreach ($tem as $key => $value) {
                if ($v['id'] == $key) {
                    $member[$k]['teamSumPrice'] += $member[$k]['sum_price'] + $value['teamSumPrice'];
                    $member[$k]['teamTodayPrice'] += $member[$k]['today_price'] + $value['teamTodayPrice'];
                    $member[$k]['teamProportion'] = $value['teamProportion'];
                    $member[$k]['lowerSumPrice'] += $value['teamSumPrice'];
                    $member[$k]['lowerTodayPrice'] += $value['teamTodayPrice'];
                } else {
                    $member[$k]['teamSumPrice'] += 0;
                    $member[$k]['teamTodayPrice'] += 0;
                    $member[$k]['teamProportion'] = 0;
                }
            }
            foreach ($range as $key2 => $value2) {
                if ($member[$k]['lowerSumPrice'] >= $range[$key2]['total'] && $member[$k]['lowerSumPrice'] < $range[$key2 + 1]['total']) {
                    $member[$k]['MyProportion'] = $range[$key2]['ratio'];
                    break;
                } else {
                    $member[$k]['MyProportion'] = 0;
                }
            }
        }
        $member = $this->digui($member, $range);
        return $member;
    }

    public function digui($member, $range)
    {
        foreach ($member as $k => $v) {
            foreach ($member as $key => $value) {
                if ($v['id'] == $value['fid']) {
                    $total = $this->digui2($value['id'], $member);
                    $a = $total['sumPrice'] + $value['teamSumPrice'];
                    $a2 = $total['todayPrice'] + $value['teamTodayPrice'];
                    $member[$k]['teamSumPrice'] += $a;
                    $member[$k]['teamTodayPrice'] += $a2;
                    $member[$k]['lowerTodayPrice'] = $a2;

                    foreach ($range as $key2 => $value2) {
                        if ($a >= $range[$key2]['total'] && $a < $range[$key2 + 1]['total']) {
                            $member[$k]['MyProportion'] = $range[$key2]['ratio'];
                            break;
                        } else {
                            $member[$k]['MyProportion'] = $member[$k]['MyProportion'] + 0;
                        }
                    }
                }
            }
            foreach ($range as $key2 => $value2) {
                if ($member[$k]['teamSumPrice'] >= $range[$key2]['total'] && $member[$k]['teamSumPrice'] < $range[$key2 + 1]['total']) {
                    $member[$k]['teamProportion'] = $range[$key2]['ratio'];
                    break;
                } else {
                    $member[$k]['teamProportion'] = 0;
                }
            }
        }
        foreach ($member as $k => $v) {
            if ($v['level'] == 6 || $v['level'] > 6) {
                if ($v['MyProportion'] > 0) {
                    if ($v['teamProportion'] == $v['MyProportion']) {
                        $member[$k]['teamBonus'] = ($v['teamProportion'] * $v['teamTodayPrice']);
                    } else {
                        $member[$k]['teamBonus'] = ($v['teamProportion'] - $v['MyProportion']) * $v['teamTodayPrice'];
                    }
                } else {
                    $member[$k]['teamBonus'] = ($v['teamProportion'] * $v['teamTodayPrice']);
                }
            }
        }
        return $member;
    }

    public function digui2($fid, $member, $status = 1)
    {
        if ($status == 1) {
            static $sumPrice;
            static $todayPrice;
            $sumPrice = 0;
            $todayPrice = 0;
        }
        static $sumPrice = 0;
        static $todayPrice = 0;

        foreach ($member as $k => $v) {
            if ($v['fid'] == $fid) {
                $sumPrice += $v['teamSumPrice'];
                $todayPrice += $v['teamTodayPrice'];
                foreach ($member as $key => $value) {
                    if ($value['fid'] == $v['id']) {
                        $this->digui2($v['id'], $member, $status = 0);
                    }
                }
            }

        }
        return array('sumPrice' => $sumPrice, 'todayPrice' => $todayPrice);
    }

//    public function main()
//    {
//        $member = pdo_getall('ewei_shop_member', array(), array('id', 'fid', 'openid'));
//
//        $member = pdo_getall('ewei_shop_member', array('inviter' => 0), array('id', 'fid', 'openid'));
//        $today = date('Y-m-d', time());
//        $tomorrow = date('Y-m-d', strtotime("+1 day", time()));
//        $today0 = strtotime($today);
//        $tomorrow0 = strtotime($tomorrow);
//
//        foreach ($member as $k => $v) {
//            $formance[$v['id']] = $this->getTeamPerformance($v['id'], $v['openid']);
//            $my_Performance = pdo_getall("ewei_shop_order", array('openid' => $v['openid'], 'status' => 3, "paytime <" => $tomorrow0, 'paytime >' => $today0), array('price'));
//            $sum_performance = pdo_getall("ewei_shop_order", array('openid' => $v['openid'], 'status' => 3), array('price'));
//            if (count($my_Performance) > 0) {
//                foreach ($my_Performance as $k1 => $v2) {
//                    $member[$k]['order_total'] += $v2['price'];
//                }
//                if ($member[$k]['order_total'] < 30000) {
//                    $member[$k]['ratio'] = 0;
//                }
//                if ($member[$k]['order_total'] >= 30000 && $member[$k]['order_total'] < 60000) {
//                    $member[$k]['ratio'] = 2;
//                }
//                if ($member[$k]['order_total'] >= 60000 && $member[$k]['order_total'] < 120000) {
//                    $member[$k]['ratio'] = 3;
//                }
//                if ($member[$k]['order_total'] >= 120000 && $member[$k]['order_total'] < 300000) {
//                    $member[$k]['ratio'] = 4;
//                }
//                if ($member[$k]['order_total'] >= 300000 && $member[$k]['order_total'] < 600000) {
//                    $member[$k]['ratio'] = 5;
//                }
//                if ($member[$k]['order_total'] >= 600000 && $member[$k]['order_total'] < 1200000) {
//                    $member[$k]['ratio'] = 6;
//                }
//                if ($member[$k]['order_total'] >= 1200000 && $member[$k]['order_total'] < 3000000) {
//                    $member[$k]['ratio'] = 7;
//                }
//                if ($member[$k]['order_total'] >= 3000000 && $member[$k]['order_total'] < 6000000) {
//                    $member[$k]['ratio'] = 9;
//                }
//                if ($member[$k]['order_total'] >= 6000000 && $member[$k]['order_total'] < 12000000) {
//                    $member[$k]['ratio'] = 11;
//                }
//                if ($member[$k]['order_total'] >= 1200000) {
//                    $member[$k]['ratio'] = 13;
//                }
//            } else {
//                $member[$k]['order_total'] = 0;
//                $member[$k]['ratio'] = 0;
//            }
//            if (count($sum_performance) > 0) {
//                foreach ($sum_performance as $k1 => $v2) {
//                    $member[$k]['sum_performance'] += $v2['price'];
//                }
//            } else {
//                $member[$k]['sum_performance'] = 0;
//            }
//        }
//        $member = $this->getTeamAward($member);
//
//        foreach ($member as $k => $val) {
//            if ($val['fid'] != 0) {
//                $arr[] = $val;
//                if ($val['lower_ratio']) {
//                    $practical = $val['group_money'] - $val['performance'];
//                    if ($val['ratio']) {
//                        $a = ($val['ratio'] - $val['lower_ratio']) * $practical / 100;
//                        $aa = $a + ($val['performance'] * $val['ratio'] / 100);
//                    }
//                } else {
//                    if ($val['ratio']) {
//                        $arr2[$k]['team_brokerage'] = ($val['ratio'] * $val['group_money']) / 100;
//                    }
//                }
//            } else {
//                $arr2[$k] = $val;
//                if ($val['lower_ratio']) {
//                    $practical = $val['group_money'] - $val['performance'];
//                    if ($val['ratio']) {
//                        $a = ($val['ratio'] - $val['lower_ratio']) * $practical / 100;
//                        $aa = $a + ($val['performance'] * $val['ratio'] / 100);
//                    }
//                } else {
//                    if ($val['ratio']) {
//                        $arr2[$k]['team_brokerage'] = ($val['ratio'] * $val['group_money']) / 100;
//                    }
//                }
//            }
//        }
//        $member2 = array_merge($arr, $arr2);
//        $member = pdo_getall('ewei_shop_member', array(), array('id', 'fid', 'nickname'));
//        foreach ($member2 as $k => $v) {
//            $member2[$k]['share'] = 0;
//            $member2[$k]['manage'] = 0;
//            $share = pdo_getall('ewei_shop_commission_list', array('getcomid' => $v['id'], 'status' => 1));
//            foreach ($share as $k2 => $v2) {
//                $member2[$k]['share'] += $v2['commission'];
//            }
//            $manage = pdo_getall('ewei_shop_commission_list', array('getcomid' => $v['id'], 'status' => 2));
//            foreach ($manage as $k2 => $v2) {
//                $member2[$k]['manage'] += $v2['commission'];
//            }
//        }
//        foreach ($member as $k => $v) {
//            foreach ($member2 as $key => $value) {
//                if ($v['id'] == $value['id']) {
//                    $member[$k]['performance'] = $value;
//                }
//            }
//        }
//
//        include $this->template();
//    }
//
//
//    protected function getTeamAward($arr = array())
//    {
//        foreach ($arr as $k => $val) {
//            if (!isset($tmp[$val['fid']])) {
//                $tmp[$val['fid']][$val['id']] = array('id' => $val['id'], 'fid' => $val['fid'], 'order_total' => $val['order_total'],);
//            } else {
//                $tmp[$val['fid']][$val['id']] = array('id' => $val['id'], 'fid' => $val['fid'], 'order_total' => $val['order_total'],);
//            }
//        }
//        // 计算无下级 团队中的用户总业绩 以及极差
//        foreach ($tmp as $k => $v) {
//            foreach ($v as $key => $value) {
//                $tmp[$k]['group_money'] += $value['order_total'];
//            }
//            if ($tmp[$k]['group_money'] >= 30000 && $tmp[$k]['group_money'] < 60000) {
//                $tmp[$k]['ratio'] = 2;
//            }
//            if ($tmp[$k]['group_money'] >= 60000 && $tmp[$k]['group_money'] < 120000) {
//                $tmp[$k]['ratio'] = 3;
//            }
//            if ($tmp[$k]['group_money'] >= 120000 && $tmp[$k]['group_money'] < 300000) {
//                $tmp[$k]['ratio'] = 4;
//            }
//            if ($tmp[$k]['group_money'] >= 300000 && $tmp[$k]['group_money'] < 600000) {
//                $tmp[$k]['ratio'] = 5;
//            }
//            if ($tmp[$k]['group_money'] >= 600000 && $tmp[$k]['group_money'] < 1200000) {
//                $tmp[$k]['ratio'] = 6;
//            }
//            if ($tmp[$k]['group_money'] >= 1200000 && $tmp[$k]['group_money'] < 3000000) {
//                $tmp[$k]['ratio'] = 7;
//            }
//            if ($tmp[$k]['group_money'] >= 3000000 && $tmp[$k]['group_money'] < 6000000) {
//                $tmp[$k]['ratio'] = 9;
//            }
//            if ($tmp[$k]['group_money'] >= 6000000 && $tmp[$k]['group_money'] < 12000000) {
//                $tmp[$k]['ratio'] = 11;
//            }
//            if ($tmp[$k]['group_money'] >= 1200000) {
//                $tmp[$k]['ratio'] = 13;
//            }
//        }
//        foreach ($tmp as $k => $v) {
//            if ($v['ratio']) {
//                $tmp[$k]['brokerage'] = ($v['ratio'] * $v['group_money']) / 100;
//            } else {
//                $tmp[$k]['brokerage'] = 0;
//            }
//        }
//        $today = date('Y-m-d', time());
//        $tomorrow = date('Y-m-d', strtotime("+1 day", time()));
//        $today0 = strtotime($today);
//        $tomorrow0 = strtotime($tomorrow);
//
//        $member = pdo_getall('ewei_shop_member', array('inviter >' => 0), array('id', 'fid', 'openid'));
//        $order_total = 0;
//        foreach ($member as $k => $v) {
//            $my_Performance = pdo_getall("ewei_shop_order", array('openid' => $v['openid'], 'status' => 3, "paytime <" => $tomorrow0, 'paytime >' => $today0), array('price'));
//            foreach ($my_Performance as $key => $value) {
//                $order_total += $value['price'];
//            }
//            if (count($tmp[$v['id']]) > 0) {
//                $member[$k]['performance'] = $order_total;
//                $member[$k]['group_money'] = $order_total + $tmp[$v['id']]['group_money'];
//                $member[$k]['lower_ratio'] = $tmp[$v['id']]['ratio'];
//                if ($member[$k]['group_money'] >= 30000 && $member[$k]['group_money'] < 60000) {
//                    $member[$k]['ratio'] = 2;
//                }
//                if ($member[$k]['group_money'] >= 60000 && $member[$k]['group_money'] < 120000) {
//                    $member[$k]['ratio'] = 3;
//                }
//                if ($member[$k]['group_money'] >= 120000 && $member[$k]['group_money'] < 300000) {
//                    $member[$k]['ratio'] = 4;
//                }
//                if ($member[$k]['group_money'] >= 300000 && $member[$k]['group_money'] < 600000) {
//                    $member[$k]['ratio'] = 5;
//                }
//                if ($member[$k]['group_money'] >= 600000 && $member[$k]['group_money'] < 1200000) {
//                    $member[$k]['ratio'] = 6;
//                }
//                if ($member[$k]['group_money'] >= 1200000 && $member[$k]['group_money'] < 3000000) {
//                    $member[$k]['ratio'] = 7;
//                }
//                if ($member[$k]['group_money'] >= 3000000 && $member[$k]['group_money'] < 6000000) {
//                    $member[$k]['ratio'] = 9;
//                }
//                if ($member[$k]['group_money'] >= 6000000 && $member[$k]['group_money'] < 12000000) {
//                    $member[$k]['ratio'] = 11;
//                }
//                if ($member[$k]['group_money'] >= 1200000) {
//                    $member[$k]['ratio'] = 13;
//                }
//            }
//        }
//
//        return $member;
//    }
//
//
//    //获取用户所属团队订单的总额
//    public function getTeamPerformance($uid, $openid, $status = 1)
//    {
//        if ($status == 1) {
//            static $TeamPerformance;
//            $TeamPerformance = 0;
//        }
//        static $TeamPerformance = 0;
//        $my_Performance = pdo_getall('ewei_shop_order', array('openid' => $openid, 'status' => 3), array('price'));
//        foreach ($my_Performance as $k1 => $v2) {
//            $TeamPerformance += $v2['price'];
//        }
//        $subordinate = pdo_getall('ewei_shop_member', array('fid' => $uid), array('id', 'openid'));
//        foreach ($subordinate as $k => $v) {
//            $price = pdo_getall('ewei_shop_order', array('openid' => $v['openid'], 'status' => 3), array('price'));
//            foreach ($price as $k2 => $v3) {
//                $TeamPerformance += $v3['price'];
//            }
//            $aa = pdo_getall('ewei_shop_member', array('fid' => $v['id']), array('id', 'openid'));
//            if (count($aa) > 0) {
//                foreach ($aa as $key => $value) {
//                    $this->getTeamPerformance($value['id'], $value['openid'], $status = 0);
//                }
//            }
//        }
//        return $TeamPerformance;
//    }
}