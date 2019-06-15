<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Share_EweiShopV2Model
{
    function getPid($pid)
    {
        global $_W;
        return pdo_getcolumn('users', array('uid' => $pid), 'pid', 1);
    }

    function getLaval($uid)
    {
        global $_W;
        return pdo_getcolumn('users', array('uid' => $uid), 'laval', 1);
    }

    //获取上级fid；grade表示分销级别.0表示顶级分销人员，1是一级分销

    function getMemberGrade($fid,$grade = 1){
        $info = pdo_get("ewei_shop_member",array('id'=>$fid),array('fid'));
        $info['grade'] = $grade;
        if ($info['fid'] != 0) {
            $info['grade'] += 1;
            $info = $this->getMemberGrade($info['fid'], $info['grade']);
        }
        return $info;
    }

    //获取用户父级的会员等级
    public function getMemberFLevel($fid)
    {
        if ($fid) {
            $level = pdo_get("ewei_shop_member", array("id" => $fid), array('level'));
            return pdo_get("ewei_shop_member_level", array('id' => $level['level']), array('level'));
        }
    }

    //获取父级的id
    public function getFId($fid)
    {
        return pdo_get("ewei_shop_member", array('id' => $fid), array('id'));
    }

    //获取父级的总消费金额
    public function getFPriceAll($fid)
    {
        if ($fid) {
            $openid = $this->getOpenid('1', $fid);
            $memberPrice = pdo_getall("ewei_shop_order", array('openid' => $openid['openid']), array('price'));
            $priceAll = 0;
            //循环计算推荐人的总金额
            foreach ($memberPrice as $v) {
                $priceAll += $v['price'];
            }
            return $priceAll;
        }
    }

    //分享奖佣金
    public function shareCommission($level = "", $orderid = "")
    {
        global $_W;
        $member = m("member")->getMember($_W["openid"], true);
        $scale = pdo_get("ewei_shop_commission_scale",array('id'=>2),array('scale'));

        if($level == 0){
            return false;
        }else{

            $price = pdo_get("ewei_shop_order",array('id'=>$orderid),array('price','id'));

            //判断自身的消费金额和父级总消费金额的大小进行比较
            $priceAll = $this->getFPriceAll($member['fid']); //获取父级消费总额
            if($price['price'] <= $priceAll){
                return $price['price'] * $scale['scale'];
            }else{
                //如果自身消费金额比父级总消费金额大，佣金比例为父级总消费金额的40%
                return $priceAll * $scale['scale'];
            }
        }
    }

    //获取openid
    public function getOpenid($grade = "", $fid)
    {
        if ($grade == 1) {
            return pdo_get("ewei_shop_member", array('id' => $fid), array('openid'));
        } elseif ($grade == 2) {
            $openid = $this->getOpenid('1', $fid);
            $grade2 = m("member")->getMember($openid['openid'], true);
            return pdo_get("ewei_shop_member", array('id' => $grade2['fid']), array('openid'));
        } else {
            $openid = $this->getOpenid('2', $fid);
            $grade3 = m("member")->getMember($openid['openid'], true);
            return pdo_get("ewei_shop_member", array('id' => $grade3['fid']), array('openid'));
        }
    }

    //管理奖二级分销佣金获取

    public  function grade2Commission($fid,$price){
        $openid = $this->getOpenid('1',$fid);
        $scale = pdo_get("ewei_shop_commission_scale",array('id'=>3),array('scale'));
        $Fmember = m("member")->getMember($openid['openid'], true);
        $priceAll =  $this->getFPriceAll($fid);//父级的消费金额
        $FpriceAll = $this->getFPriceAll($Fmember['fid']);

        $level = $this->getMemberFLevel($Fmember['fid']);
        if($priceAll != 0){
            if ($level['level'] > 1) {
                if ($price <= $FpriceAll) {
                    return $price * $scale['scale'];
                } else {
                    return $FpriceAll * $scale['scale'];
                }
            } else {
                return false;
            }
        }else{
            return false;
        }


    }

    //管理奖佣金三级分销获取
    public function  grade3Commission($fid,$price){
        $openid = $this->getOpenid('2',$fid);
        $priceAll = $this->getFPriceAll($fid);

        $scale1 = pdo_get("ewei_shop_commission_scale",array('id'=>4),array('scale'));
      
        $scale2 = pdo_get("ewei_shop_commission_scale",array('id'=>6),array('scale'));
     
        $member = m("member")->getMember($openid['openid'], true);
        $fpriceAll = $this->getFPriceAll($member['id']);
     
        $FpriceAll = $this->getFPriceAll($member['fid']);
        $level = $this->getMemberFLevel($member['fid']);
      
        if($priceAll != 0 && $fpriceAll != 0){
         
            if ($level['level'] == 2) {
              
                if ($price <= $FpriceAll) {
                 
                    return $price * $scale1['scale'];
                } else {
                 
                    return $FpriceAll * $scale1['scale'];
                }
            } elseif ($level['level'] == 3) {

                if ($price <= $FpriceAll) {
                    return $price * $scale2['scale'];
                } else {
                    return $FpriceAll * $scale2['scale'];
                }
            } else {

                return false;
            }
        }else{
         
            return false;
        }


    }

    //管理奖佣金
    public function manageCommission($level = "", $orderid = "")
    {
        global $_W;
        $member = m("member")->getMember($_W["openid"], true);
        $price = pdo_get("ewei_shop_order",array('id'=>$orderid),array('price'));
        if($level <= 1){
            return false;
        } else if ($level == 2) { //当存在二级分销的时候
            return $this->grade2Commission($member['fid'], $price['price']);
        } else if ($level >= 3) {//当前为三级分销
            $grade3Commission = $this->grade3Commission($member['fid'], $price['price']);
            $grade2Commission = $this->grade2Commission($member['fid'], $price['price']);
            return ['grade2Commission' => $grade2Commission, 'grade3Commission' => $grade3Commission];
        }
    }

    //团队业绩
    public function teamAchievement($uid)
    {
        $today = date('Y-m-d', time());
        $tomorrow = date('Y-m-d', strtotime("+1 day", time()));
        $today0 = strtotime($today);
        $tomorrow0 = strtotime($tomorrow);
        $openids = $this->digui($uid);
        for ($i = 0; $i < count($openids); $i++) {
            $groupids[] = pdo_get("ewei_shop_member", array('id' => $openids[$i]), array('openid'));
        }
        foreach ($groupids as $k => $v) {
            $todayAchievement[] = pdo_getall("ewei_shop_order", array('openid' => $v['openid'], 'status' => 3, "finishtime <" => $tomorrow0, 'finishtime >' => $today0), array('price'));
            $allAchievement[] = pdo_getall("ewei_shop_order", array('openid' => $v['openid'], 'status' => 3), array('price'));
        }
        $todayResult = "";
        $allResult = "";
        foreach ($todayAchievement as $key => $val) {
            if (!empty($val)) {
                foreach ($val as $vk) {
                    $todayResult += $vk['price'];
                }
            }
        }
        foreach ($allAchievement as $ka => $va) {
            if (!empty($va)) {
                foreach ($va as $vk) {
                    $allResult += $vk['price'];
                }
            }
        }
        return ['todayResult' => $todayResult, 'allResult' => $allResult];
    }

    //递归id
    public function digui($uid)
    {
        static $id = [];
        $id[] = $uid;
        $f_member = pdo_getall('ewei_shop_member', array('fid' => $uid), array('id', 'fid'));
        foreach ($f_member as $k => $v) {
            $id[] = $v['id'];
            $ff_member = pdo_getall('ewei_shop_member', array('fid' => $v['id']), array('id', 'fid'));
            if (count($ff_member) > 0) {
                foreach ($ff_member as $key => $value) {
                    $id[] = $value['id'];
                    $this->digui($value['id']);
                }
            }
        }

        return array_unique($id);
    }

    //获取用户所属团队订单的总额
    public function getTeamPerformance($uid, $openid)
    {
        static $my_Performances = 0;
        $my_Performance = pdo_getall('ewei_shop_order', array('openid' => $openid, 'status' => 3), array('price'));
        foreach ($my_Performance as $k1 => $v2) {
            $my_Performances += $v2['price'];
        }
        $subordinate = pdo_getall('ewei_shop_member', array('fid' => $uid), array('id', 'openid'));
        foreach ($subordinate as $k => $v) {
            $price = pdo_getall('ewei_shop_order', array('openid' => $v['openid'], 'status' => 3), array('price'));
            foreach ($price as $k2 => $v3) {
                $my_Performances += $v3['price'];
            }
            $aa = pdo_getall('ewei_shop_member', array('fid' => $v['id']), array('id', 'openid'));
            if (count($aa) > 0) {
                foreach ($aa as $key => $value) {
                    $this->getTeamPerformance($value['id'], $value['openid']);
                }
            }
        }
        return $my_Performances;
    }
    //推广奖
    public function pushCommission($fid)
    {
        static $id=0;
        $inf = pdo_get("ewei_shop_member", array('id' => $fid), array('id', 'fid', 'is_league'));
        if ($inf) {
            if ($inf['is_league'] != 0) {
                $id += $inf['id'];
            } else {
                $this->pushCommission($inf['fid']);
            }
        }
        return $id;
    }

}

?>