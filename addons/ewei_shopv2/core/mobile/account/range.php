<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Range_EweiShopV2Page extends MobilePage
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
        $i = 0;
        foreach ($member as $k => $v) {
            $record = pdo_getall('bob_record', array('uid' => $v['id']));
            foreach ($record as $k2 => $v2) {
                if (date('Y-m-d', $v2['time']) == date('Y-m-d')) {
                    $v['teamBonus'] = 0;
                }
            }
            if ($v['teamBonus'] > 0) {
                $user = pdo_get('ewei_shop_member', array('id' => $v['id']), array('nickname', 'realname', 'mobile'));
                $res = pdo_update('ewei_shop_member', array('credit2 +=' => $v['teamBonus']-($v['teamBonus'] * 0.12)), array('id' => $v['id']));
                if ($user['realname'] && $res) {
                    $data['uid'] = $v['id'];
                    $data['name'] = $user['realname'];
                    $data['mobile'] = $user['mobile'];
                    $data['tallage'] = $v['teamBonus'] * 0.12;
                    $data['teamBonus'] = $v['teamBonus'] - ($v['teamBonus'] * 0.12);
                    $data['time'] = time();
                    $res2 = pdo_insert('bob_record', $data);
                    if ($res2) {
                        $i++;
                    }
                } else {
                    $data['uid'] = $v['id'];
                    $data['name'] = $user['nickname'];
                    $data['mobile'] = $user['mobile'];
                    $data['tallage'] = $v['teamBonus'] * 0.12;
                    $data['teamBonus'] = $v['teamBonus'] - ($v['teamBonus'] * 0.12);
                    $data['time'] = time();
                    $res2 = pdo_insert('bob_record', $data);
                    if ($res2) {
                        $i++;
                    }
                }
            }
        }
        $countmember = count($member);

        if ($res && $res2) {
           pdo_update('ewei_shop_member', array('today_price'=> 0,'bob_num +='=>1));
            exit(json_encode(array('code' => 0, 'msg' => "需要拨比用户为$countmember 条 ,实际结算成功为 $i 条")));
        }
        exit(json_encode(array('code' => 1, 'msg' => "网络错误！请稍后重试！")));

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
            if ($v['MyProportion'] > 0) {
                $member[$k]['teamBonus'] = ($v['teamProportion'] * $v['teamTodayPrice']) - ($v['MyProportion'] * $v['lowerTodayPrice']);
            } else {
                $member[$k]['teamBonus'] = ($v['teamProportion'] * $v['teamTodayPrice']);
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

}