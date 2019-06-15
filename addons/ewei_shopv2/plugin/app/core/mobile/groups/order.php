<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';

class Order_EweiShopV2Page extends AppMobilePage
{
    public function main()
    {
        global $_W, $_GPC;
        $list = array();
        $openid = $_W['openid'];
        $uniacid =$_W['uniacid'];
        $pindex = max(1, intval($_GPC['page']));
        $psize = 5;
        $status = $_GPC['status'];
        if($status == ''){
            $condition = " and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted and o.source = :source";
            $params = array(
                ':uniacid' => $uniacid,
                ':openid' => $openid,
                ':deleted' => 0,
                ':source' => 1
            );
        }else{
            $condition = " and o.openid=:openid  and o.uniacid=:uniacid and o.status = :status and o.deleted = :deleted and o.source = :source";
            $params = array(
                ':uniacid' => $uniacid,
                ':openid' => $openid,
                ':deleted' => 0,
                ':source' => 1
            );
            if($status == 0){
                $params[':status'] = 0;
            }elseif($status == 1){
                $condition = " and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted and o.status = :status and o.isverify = 0 and (o.is_team = 0 or o.success = 1) and o.source = :source ";
                $params[':status'] = 1;
            }elseif($status == 2){
                $condition = " and o.openid=:openid  and o.uniacid=:uniacid and o.deleted = :deleted and (o.status = :status or (o.status = :status2 and o.isverify = 1)) and (o.is_team = 0 or o.success = 1 or (o.isverify = 1 and success = 0)) and o.source = :source ";
                $params[':status'] = 2;
                $params[':status2'] = 1;
            }elseif($status == 3){
                $params[':status'] = 3;
            }
        }

        $sql = "select o.id,o.orderno,o.createtime,o.price,o.freight,o.creditmoney,o.goodid,o.teamid,o.status,o.is_team,o.success,o.teamid,o.openid,o.goods_price,
				g.title,g.thumb,g.units,g.goodsnum,g.description,g.groupsprice,g.singleprice,o.verifynum,o.verifytype,o.isverify,o.uniacid,o.verifycode,g.thumb_url
				from " . tablename('ewei_shop_groups_order') . " as o
				left join ".tablename('ewei_shop_groups_goods')." as g on g.id = o.goodid
				where 1 {$condition} order by o.createtime desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize;

        $orders = pdo_fetchall( $sql , $params);
        $total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . " as o where 1 {$condition}", $params);

        foreach ($orders as $key => $value) {
            $verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . " where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ",
                array(':orderid'=>$value['id'],':openid'=>$value['openid'],':uniacid'=>$value['uniacid'],':verifycode'=>$value['verifycode']));
            if(!$verifytotal){
                $verifytotal = 0;
            }
            $orders[$key]['vnum'] = $value["verifynum"] - intval($verifytotal);
            $orders[$key]['amount'] = $value['price'] + $value['freight'] - $value['creditmoney'];
        }
        $orders = set_medias($orders, 'thumb');
        app_json(array('list'=>$orders,'pagesize'=>$psize,'total'=>$total));

    }

    public function details()
    {
        global $_W, $_GPC;
        $openid = $_W['openid'];
        $uniacid = $_W['uniacid'];
        $orderid = intval($_GPC['orderid']);
        $order = pdo_fetch("select * from " . tablename('ewei_shop_groups_order') . "
				where openid=:openid  and uniacid=:uniacid and id = :orderid order by createtime desc ",array(
            ':uniacid' => $uniacid,
            ':openid' => $openid,
            ':orderid' => $orderid,
        ));
        //商品信息
        $goods = pdo_fetch("select * from " . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $order['goodid'],':uniacid' => $uniacid,':status' => 1));

        $goods = set_medias( $goods,'thumb' );
        //是否支持核销
        if(!empty($order['isverify'])){
            //核销单 所有核销门店
            $storeids = array();
            $merchid = 0;
            if (!empty($goods['storeids'])) {
                $merchid = $goods['merchid'];
                $storeids = array_merge(explode(',', $goods['storeids']), $storeids);
            }
            if (empty($storeids)) {
                //门店加入支持核销的判断
                if ($merchid > 0) {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
                } else {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
                }
            } else {
                if ($merchid > 0) {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
                } else {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
                }
            }
            //核销次数
            $verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_verify') . " where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ",
                array(':orderid'=>$order['id'],':openid'=>$order['openid'],':uniacid'=>$order['uniacid'],':verifycode'=>$order['verifycode']));
            if($order['verifytype']==0){
                $verify = pdo_fetch("select isverify from ". tablename('ewei_shop_groups_verify') ." where orderid = :orderid and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ",
                    array(':orderid'=>$order['id'],':openid'=>$order['openid'],':uniacid'=>$order['uniacid'],':verifycode'=>$order['verifycode']));
            }
            $verifynum = $order["verifynum"] - $verifytotal;
            if($verifynum<0){
                $verifynum = 0;
            }
        }else{
            //收货地址
            $address = false;
            if (!empty($order['addressid'])) {
                $address = iunserializer($order['address']);
                if (!is_array($address)) {
                    $address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
                }
            }

        }
        //自定义表单
        if (!empty($order['diyformfields']) && !empty($order['diyformdata'])) {
            $order_fields = iunserializer($order['diyformfields']);
            $order_data = iunserializer($order['diyformdata']);
        }
        $newFields = array();
        if (is_array($order_fields)&&!empty($order_fields)){
            foreach ($order_fields as $k=>$v){
                $v['diy_type'] = $k;
                $newFields[] = $v;
                if($v['data_type']==5 && !empty($order_data[$k]) && is_array($order_data[$k])){
                    $order_data[$k] = set_medias($order_data[$k]);
                }
            }
        }

//        $grodiyform = array();
        $order['diyformfields'] =  empty($newFields) ? array() : $newFields;
        $order['diyformdata'] =  empty($order_data) ? array() : $order_data;

        //联系人
        $carrier = @iunserializer($order['carrier']);
        if (!is_array($carrier) || empty($carrier)) {
            $carrier = false;
        }

        switch ($order['status']){
            case '-1' :
                $order['status_str'] = '交易关闭';
                break;
            case '0' :
                if ($order['paytype']==3){
                    $order['status_str'] = '货到付款，等待发货';
                }else{
                    $order['status_str'] = '等待付款';
                }
                break;
            case '1' :
                $order['status_str'] = '买家已付款';
                break;
            case '2' :
                $order['status_str'] = '卖家已发货';
                break;
            case '3' :
                $order['status_str'] = '交易完成';
                break;
        }

        if($order['refundstate'] > 0){
            $order['refundtext'] = '商品维权中';
        }else {
            $order['refundtext'] = '已维权';
        }

        //规格
        $spec = array();
        //如果是多规格
        if( $order['more_spec'] == 1 ){
            $order['option'] = pdo_get( 'ewei_shop_groups_order_goods' ,array( 'groups_order_id' => $order['id'] )  );
        }

        //如果是阶梯团
        if( $order['is_ladder'] == 1 ){
            $order['ladder'] = pdo_get( 'ewei_shop_groups_ladder' , array( 'id' => $order['ladder_id'] ) );
        }


        $order['createtime'] = date( 'Y-m-d H:i:s' , $order['createtime'] );
        $order['paytime'] = $order['paytime']?date( 'Y-m-d H:i:s' , $order['paytime'] ):'';
        $order['sendtime'] = $order['sendtime']?date( 'Y-m-d H:i:s' , $order['sendtime'] ):'';
        $order['finishtime'] = $order['finishtime']?date( 'Y-m-d H:i:s' , $order['finishtime'] ):'';

        $money = price_format( $order['price'] - $order['creditmoney'] + $order['freight'] , 2);
        $order['money'] = $money > 0.00 ? $money : 0.00;

        $express = m('util')->getExpressList($order['express'], $order['expresssn']);

        //商品是否禁止退换货
        $goodRefund = false;
        $groupsSet = pdo_fetch("select goodsid,refundday from " . tablename('ewei_shop_groups_set') . 'where uniacid = :uniacid ',array(':uniacid' => $uniacid));
        if(in_array($order['goodid'], explode(",",$groupsSet['goodsid']))){
            $goodRefund = true;
        }

        app_json( array(
            'express' => $express,
            'goodRefund' => $goodRefund,
            'order' => $order,
            'address' => $address,
            'store' => $stores,
            'verifytotal' => $verifytotal,
            'verifynum' => $verifynum,
            'carrier' => $carrier,
            'verify' => $verify,
            'goods' => $goods,
        ) );

    }

    public function create_order()
    {
        global $_W, $_GPC;

        //$openid = $_W['openid'];
        $openid = empty($_W['openid'])?$_W['openid']:$_W['openid'];
        
        // 检查参数
        if(!isset($openid) || empty($openid)) {
            $openid = $_GPC['openid'];
        }
        
        if(empty($openid)){
            app_error( AppError::$ParamsError );
        }
        $uniacid = $_W['uniacid'];
        //是否为核销单
        $isverify = false;
        $goodid = intval($_GPC['id']);
        $groups_option_id = intval($_GPC['group_option_id']);
        $ladder_id = intval($_GPC['ladder_id']);
        $is_ladder = 0;
        $type = $_GPC['type'];
        $heads = intval($_GPC['heads']);
        $teamid = intval($_GPC['teamid']);

        /**
         * 截取openid:
         * sns_wa_oX-v90I0_dN0qRw_hgc6K0s5akqY
         * 截取后为:
         * oX-v90I0_dN0qRw_hgc6K0s5akqY
         * 如果是false,则说明无openid
         */

        $originalOpenid = substr($openid, strripos($openid, '_') + 1);

        if(!$originalOpenid) {
            app_error(-1, "授权后才可进行操作");
        }
        $member = m('member')->getMember($openid);

        $credit = array(); //积分抵扣
        $ladder = array(); //阶梯团
        $groups_option = array(); //多规格



        //商品详情
        $goods = pdo_fetch("select * from " . tablename('ewei_shop_groups_goods') . '
				where id = :id and uniacid = :uniacid and deleted = 0 order by displayorder desc',
            array(':id' => $goodid,':uniacid' => $uniacid));

        if (empty($goods['status'])) {
            app_error( 1,'您选择的商品已经下架，请浏览其他商品或联系商家！' );
        }

        //规格
        $groups_option = pdo_get( 'ewei_shop_groups_goods_option' , array('id' => $groups_option_id) );

        $ordernum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . " as o
			where openid = :openid and status >= :status and goodid = :goodid and uniacid = :uniacid and is_team = 1",
                array(':openid'=>$openid,':status'=>0,':goodid'=>$goodid,':uniacid'=>$uniacid));

        if(!empty($goods['purchaselimit']) && $goods['purchaselimit']<=$ordernum){
            app_error( 1,'您已到达此商品购买上限，请浏览其他商品或联系商家！' );
        }


        //如果开启了阶梯团
        if( $goods['is_ladder'] == 1 && $type == 'groups' ){
            if( empty($ladder_id) && empty( $teamid ) ){
                app_error( 1,'缺少阶梯团ID' );
            }

            $is_ladder = 1;
            //查询阶梯数据
            $ladder = pdo_get( 'ewei_shop_groups_ladder' , array('id' => $ladder_id) );

            $sql = 'select count(1) from ' . tablename('ewei_shop_groups_order') . " as o
			where openid = :openid and status >= :status and goodid = :goodid and uniacid = :uniacid  and ladder_id=:ladder_id";
            $params = array(
                ':openid'=>$openid,
                ':status'=>0,
                ':goodid'=>$goodid,
                ':uniacid'=>$uniacid,
                ':ladder_id'=>$ladder_id,
            );
            if(!empty( $teamid ) ){
                $sql .= ' and teamid = :team_id';
                $params['team_id'] = $teamid;
            }
            $ladder_ordernum = pdo_fetchcolumn($sql,$params);
        }

        $order = pdo_fetch("select * from " . tablename('ewei_shop_groups_order') . '
					where goodid = :goodid and status >= 0 and  openid = :openid and uniacid = :uniacid and success = 0 and deleted = 0 ',
            array(':goodid' => $goodid,':openid'=>$openid,':uniacid' => $uniacid));
        if($order && $order['status']== 0){
            app_error( 1,'您的订单已存在，请尽快完成支付！' );
        }
        if($order && $order['is_team'] == 1 && $type != 'single' && $order['status']== 1){
            app_error( 1,'您已经参与了该团，请等待拼团结束后再进行购买！' );
        }

        //如果开启了阶梯团
        if( $goods['is_ladder'] == 0 ){
            if($order && $ordernum >= $order['groupnum'] && $order['is_team'] == 1 && $type != 'single'){
                app_error( 1,'该团人数已达上限，请浏览其他商品或联系商家！(1)' );
            }
        }else{

            //查询阶梯团限制人数
            if($order && $ladder_ordernum >= $ladder['ladder_num'] && $order['is_team'] == 1 && $type != 'single'){
                app_error( 1,'该团人数已达上限，请浏览其他商品或联系商家！(2)' );
            }
        }


        //组团
        if(!empty($teamid)){
            $orders = pdo_fetchall("select * from " . tablename('ewei_shop_groups_order') . '
					where teamid = :teamid and uniacid = :uniacid ',
                array(':teamid'=>$teamid,':uniacid' => $uniacid));
            foreach($orders as $key => $value){
                if($orders && $value['success']== -1){
                    app_error( 1,'该活动已过期，请浏览其他商品或联系商家！' );
                }
                if($orders && $value['success']==1){
                    app_error( 1,'该活动已结束，请浏览其他商品或联系商家！' );
                }
            }

            if( $goods['is_ladder'] == 0 ){
                $num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . " where teamid = :teamid and status > :status and goodid = :goodid and uniacid = :uniacid ",
                    array(':teamid'=>$teamid,':status'=>0,':goodid'=>$goods['id'],':uniacid'=>$uniacid));
                if($num>=$goods['groupnum']){
                    app_error( 1,'该活动已成功组团，请浏览其他商品或联系商家！' );
                }
            }else{
                $num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . " where teamid = :teamid and status > :status and goodid = :goodid and uniacid = :uniacid and ladder_id = :ladder_id",
                    array(':teamid'=>$teamid,':status'=>0,':goodid'=>$goods['id'],':uniacid'=>$uniacid , ':ladder_id' => $ladder_id ));
                if($num>=$ladder['ladder_num']){
                    app_error( 1,'该活动已成功组团，请浏览其他商品或联系商家！' );
                }
            }

        }
        //组团end
            //是拼团还是单买
            if($type=='groups' && $goods['more_spec'] == 0 && $is_ladder == 0){ //团购普通
                if($goods['stock']<=0){
                    app_error( 1,'您选择的商品库存不足，请浏览其他商品或联系商家！' );
                }
                $price = $goods['groupsprice'];
                $groupnum = intval($goods['groupnum']);//团购人数
                $is_team = 1;
            }elseif($type=='groups' && $goods['more_spec'] == 1 && $is_ladder == 0){ //团购多规格
                if($groups_option['stock']<=0){
                    app_error( 1,'您选择的商品库存不足，请浏览其他商品或联系商家！(1)' );
                }
                $goods['groupsprice'] = $groups_option['price'];
                $price = $groups_option['price'];
                $groupnum = intval($goods['groupnum']);//团购人数
                $is_team = 1;
            }elseif( $type=='groups' && $goods['more_spec'] == 0 && $is_ladder == 1 ){ //团购阶梯团
                $goods['groupsprice'] = $ladder['ladder_price'];
                $price = $ladder['ladder_price'];
                $groupnum = intval($ladder['ladder_num']);//团购人数
                $is_team = 1;
            }elseif($type=='single' && $goods['more_spec'] == 0){ //单购普通
                if($goods['stock']<=0){
                    app_error( 1,'您选择的商品库存不足，请浏览其他商品或联系商家！' );
                }
                $goods['groupsprice'] = $goods['singleprice'];
                $price = $goods['singleprice'];
                $groupnum = 1;
                $is_team = 0;
                $teamid = 0;
            }else { //单购多规格

                if($groups_option['stock']<=0){
                    app_error( 1,'您选择的商品库存不足，请浏览其他商品或联系商家！(2)' );
                }
                $price = $groups_option['single_price'];
                $groupnum = 1;
                $is_team = 0;
                $teamid = 0;
            }
            //多规格库存

        //优惠之前的价格
        $goods_price = $price;

        //团长优惠设置
        $set = pdo_fetch("select discount,headstype,headsmoney,headsdiscount from ".tablename('ewei_shop_groups_set')."
					where uniacid = :uniacid ", array(':uniacid' => $uniacid));
        if(!empty($set['discount']) && $heads == 1){
                if(!empty($goods['discount'])){//商品单独设置团长优惠
                    if(!empty($goods['headstype'])){//优惠折扣
                        if($goods['headsdiscount']>0){
                            if($goods['headsdiscount'] ==100){
                                $goods['headsmoney'] = $goods['groupsprice'];
                            }else{
                                $goods['headsmoney'] = $goods['groupsprice'] - price_format($goods['groupsprice'] * $goods['headsdiscount']/100,2);
                            }
                        }
                    }
                }else{//统一团长优惠
                    if(empty($set['headstype'])){//优惠金额
                        $goods['headsmoney'] = $set['headsmoney'];
                    }else{//优惠折扣
                        if($set['headsdiscount']>0) {
                            if($set['headsdiscount'] ==100){
                                $goods['headsmoney'] = $goods['groupsprice'];
                            }else{
                                $goods['headsmoney'] =  $goods['groupsprice'] - price_format($goods['groupsprice'] * $set['headsdiscount'] / 100, 2);
                            }
                        }
                    }
                    $goods['headstype'] = $set['headstype'];
                    $goods['headsdiscount'] = $set['headsdiscount'];
                }
                if($goods['headsmoney']>$goods['groupsprice']){
                    $goods['headsmoney'] = $goods['groupsprice'];
                }
                $price = $price - $goods['headsmoney'];
                if($price<0){
                    $price = 0;
                }
        }else{
            $goods['headsmoney'] = 0;
        }
        //团长优惠结束


        //是否支持核销
        if(!empty($goods['isverify'])){
            $isverify = true;
            $goods['freight'] = 0;
            //核销单 所有核销门店
            $storeids = array();
            $merchid = 0;
            if (!empty($goods['storeids'])) {
                $merchid = $goods['merchid'];
                $storeids = array_merge(explode(',', $goods['storeids']), $storeids);
            }
            if (empty($storeids)) {
                //门店加入支持核销的判断
                if ($merchid > 0) {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
                } else {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
                }
            } else {
                if ($merchid > 0) {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
                } else {
                    $stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
                }
            }
            $verifycode = "PT".random(8, true);
            while (1) {
                $count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_groups_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));
                if ($count <= 0) {
                    break;
                }
                $verifycode = "PT".random(8, true);
            }
            $verifynum = !empty($goods['verifytype'])?$verifynum = $goods['verifynum']:1;
        }else{
            //默认地址
            $address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . '
				where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1'
                , array(':uniacid' => $uniacid, ':openid' => $openid));
        }

        /*积分抵扣*/
        $creditdeduct = pdo_fetch("SELECT creditdeduct,groupsdeduct,credit,groupsmoney FROM" . tablename('ewei_shop_groups_set') .  "WHERE uniacid = :uniacid ",array(':uniacid'=>$uniacid));
        if(intval($creditdeduct['creditdeduct'])){//是否开启积分抵扣
            /*判断是否使用拼团积分抵扣比例*/
            if(intval($creditdeduct['groupsdeduct'])){
                //商品最多抵扣金额,
                if($goods['deduct']>0){
                    $credit['deductprice'] = round((intval($member['credit1']) * $creditdeduct['groupsmoney']), 2);
                    if($credit['deductprice'] >= $price){//抵扣金额、团购金额
                        $credit['deductprice'] = $price;
                    }
                    if($credit['deductprice'] >= $goods['deduct']){//抵扣金额、商品最多抵扣金额
                        $credit['deductprice'] = $goods['deduct'];
                    }
                    $credit['credit'] = floor($credit['deductprice'] / $creditdeduct['groupsmoney']);
                    if($credit['credit']<1){
                        $credit['credit'] = 0;
                        $credit['deductprice'] = 0;
                    }
                    $credit['deductprice'] = $credit['credit'] * $creditdeduct['groupsmoney'];
                }else{
                    $credit['deductprice'] = 0;
                }
            }else{
                /*人人商城积分抵扣比例*/
                $sys_data = m('common')->getPluginset('sale');
                //商品最多抵扣金额,
                if($goods['deduct']>0){
                    $credit['deductprice'] = round((intval($member['credit1']) * $sys_data['money']), 2);
                    if($credit['deductprice'] >= $price){
                        $credit['deductprice'] = $price;
                    }
                    if($credit['deductprice'] >= $goods['deduct']){
                        $credit['deductprice'] = $goods['deduct'];
                    }
                    $credit['credit'] = floor($credit['deductprice'] / $sys_data['money']);
                    if($credit['credit']<1){
                        $credit['credit'] = 0;
                        $credit['deductprice'] = 0;
                    }
                    $credit['deductprice'] = $credit['credit'] * $sys_data['money'];
                }else{
                    $credit['deductprice'] = 0;
                }
            }
        }

//自定义表单
        $diyform_plugin = p('diyform');
        $formInfo = false;
        $set_config = false;
        $diyform_id = 0;
        $fields = array();
        $f_data = array();
        if ($diyform_plugin) {
            $set_config = $diyform_plugin->getSet();
            $groups_diyform_open = $set_config['groups_diyform_open'];
            if ($groups_diyform_open == 1) {
                $diyform_id = $set_config['groups_diyform'];
                if (!empty($diyform_id)) {
                    $formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
                    $fields = $formInfo['fields'];
                    $diyform_data = array();
                    $f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
                }
            }
        }

        $appDatas = array();
        if ($diyform_plugin)
        {
            $appDatas = $diyform_plugin->wxApp($fields, $f_data, $this->member);
            $fields = $appDatas['fields'];
        }

        //生成订单号
        $ordersn = m('common')->createNO('groups_order', 'orderno', 'PT');

        if ($_W['ispost'] == true) {
            if(empty($_GPC['aid']) && !$isverify){
                app_error(1,'请选择收货地址！');
            }
            if($isverify){
                if(empty($_GPC['realname']) || empty($_GPC['mobile'])){
                    app_error( 1,'联系人或联系电话不能为空！' );
                }
            }
            if(intval($_GPC['aid'])>0 && !$isverify){
                //默认地址
                $order_address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1'
                    , array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => intval($_GPC['aid'])));
                if (empty($order_address)) {
                    app_error( 1,'未找到地址' );
                } else {
                    if (empty($order_address['province']) || empty($order_address['city'])) {
                        app_error( 1,'地址请选择省市信息' );
                    }
                }
            }

            $data = array(
                'uniacid' => $_W['uniacid'],
                'groupnum' => $groupnum,
                'openid' => $openid,
                'paytime' => 0,//支付成功时间
                'orderno' => $ordersn,
                'credit' => $_GPC['deduct'] == 'true' ? $_GPC['deduct'] : 0 ,
                'creditmoney' => $_GPC['deduct'] == 'true'?$credit['deductprice']:0  ,
                'price' => $price,
                'freight' => $goods['freight'],
                'status' => 0,//订单状态，-1取消状态，0普通状态，1为已付款，2为已发货，3为成功
                'goodid' => $goodid,
                'is_ladder' => $is_ladder,
                'ladder_id' => $ladder_id,
                'more_spec' => $goods['more_spec'],
                'teamid'=>$teamid,
                'is_team' => $is_team,
                'heads' => $heads,
                'discount' => !empty($heads)?$goods['headsmoney']:0,
                'addressid' => intval($_GPC['aid']),
                'address' => iserializer($order_address),
                'message' => trim($_GPC['message']),
                'realname' => $isverify?trim($_GPC['realname']):'',
                'mobile' => $isverify?trim($_GPC['mobile']):'',
                'endtime' => $goods['endtime'],
                'isverify' => intval($goods['isverify']),
                'verifytype' => intval($goods['verifytype']),
                'verifycode' => !empty($verifycode)?$verifycode:0,
                'verifynum' => !empty($verifynum)?$verifynum:1,
                'createtime' => TIMESTAMP,
                'source' => 1,
                'goods_price' => $goods_price
            );
            if ($diyform_plugin) {
                $diydata = $_GPC['diydata'];
                if (is_string($diydata)){
                    $diyformdatastring = htmlspecialchars_decode(str_replace('\\','', $diydata));
                    $diydata= @json_decode( $diyformdatastring  ,true);
                }
                if (is_array($diydata) && !empty($formInfo)) {
                    $diyform_data = $diyform_plugin->getInsertData($fields, $diydata, true);
                    $idata = $diyform_data['data'];
                    // 小程序、APP保存时需要把fields 转换
                    $data['diyformfields'] = $diyform_plugin->getInsertFields($fields);
                    $data['diyformdata'] = $idata;
                    $data['diyformid'] = $formInfo['id'];
                }

            }

            $order_insert = pdo_insert('ewei_shop_groups_order', $data);
            if(!$order_insert){
                app_error( 1,'生成订单失败！' );
            }
            $orderid = pdo_insertid();
            if(empty($teamid) && $type=='groups'){
                pdo_update('ewei_shop_groups_order',array('teamid' => $orderid), array('id' => $orderid));
            }

            if( !empty($goods['more_spec']) ){
                $groups_order_goods = array(
                    'uniacid' => $_W['uniacid'],
                    'goods_id' => $groups_option['goodsid'],
                    'groups_goods_id' => $groups_option['groups_goods_id'],
                    'groups_goods_option_id' => $groups_option['id'],
                    'groups_order_id' => $orderid,
                    'price' => $type == 'groups'? $groups_option['price'] : $groups_option['single_price'],
                    'option_name' => $groups_option['title'],
                    'create_time' => TIMESTAMP
                );
                pdo_insert( 'ewei_shop_groups_order_goods' , $groups_order_goods );
            }

            $order = pdo_fetch("select * from " . tablename('ewei_shop_groups_order') . '
						where id = :id and uniacid = :uniacid ',array(':id' => $orderid,':uniacid' => $uniacid));

            app_json( array('teamid' => empty($teamid) ? $order["teamid"] : $teamid,'orderid'=>$orderid) );
        }

        //组成新数组以便小程序调用
        $new_goods = array();
        $new_goods['title'] = $goods['title'];
        $new_goods['thumb'] = tomedia($goods['thumb']);
        $new_goods['units'] = $goods['units'];
        $new_goods['goods_num'] = $goods['goodsnum'];

        if( $goods['more_spec'] == 1 ){
            if( $type == 'single' ){
                $new_goods['price'] = $groups_option['single_price'];
            }else{
                $new_goods['price'] = $groups_option['price'];
            }
            $new_goods['spec_name'] = $groups_option['title'];
        }else{

            $new_goods['price'] = $goods['groupsprice'];
            $new_goods['spec_name'] = '';
        }

        $data = array(
            'is_verify' => $isverify ? 1 : 0,
            'is_ladder' => $is_ladder,
            'is_more_spec' => $goods['more_spec'],
            'type' => $type,
            'teamid' => $teamid,
            'heads' => $heads,
            'headsmoney'=> $goods['headsmoney'],
            'credit'=>$credit,
            'ladder'=>$ladder,
            'goods' => $new_goods,
            'stores' => $stores,
            'address' => $address,
            'freight' => $goods['freight'],
            'price' => round(floatval($price+$goods['freight']),2),
            'f_data' => $appDatas['f_data'],
            'fields' => $appDatas['fields'],
        );
        app_json( array( 'data' => $data ) );
    }

    /**
     * 确认收货
     * @global type $_W
     * @global type $_GPC
     */
    function finish() {

        global $_W, $_GPC;
        $open_id = $_W['openid'];
        $orderid = intval($_GPC['id']);
        $order = pdo_fetch("select * from " . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1'
            , array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $open_id));
        if (empty($order)) {
            app_error(1, '订单未找到');
        }
        if ($order['status'] != 2) {
            app_error(1, '订单不能确认收货');
        }
        if ($order['refundstate'] > 0 && !empty($order['refundid'])) {

            $change_refund = array();
            $change_refund['refundstatus'] = -2;
            $change_refund['refundtime'] = time();
            pdo_update('ewei_shop_groups_order_refund', $change_refund, array('id' => $order['refundid'], 'uniacid' => $_W['uniacid']));
        }

        pdo_update('ewei_shop_groups_order', array('status' => 3, 'finishtime' => time(), 'refundstate' => 0), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));

        //模板消息
        p('groups')->sendTeamMessage($orderid);

        app_json();
    }
    /**
     * 删除订单
     * @global type $_W
     * @global type $_GPC
     */
    function delete() {
        global $_W, $_GPC;

        //删除订单
        $open_id = $_W['openid'];
        $orderid = intval($_GPC['id']);
        $order = pdo_fetch("select id,status from " . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1'
            , array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $open_id));
        if (empty($order)) {
            app_error(1, '订单未找到!');
        }
        if ($order['status'] != 3 && $order['status'] != -1) {
            app_error(1, '无法删除');
        }

        pdo_update('ewei_shop_groups_order', array('deleted' => 1), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
        app_json();
    }

    /**
     * 取消订单
     * @global type $_W
     * @global type $_GPC
     */
    function cancel() {
        global $_W, $_GPC;
            $orderid = intval($_GPC['id']);
            $cancel_reason = $_GPC['cancel_reason'];
            $order = pdo_fetch("select id,orderno,openid,status,credit,teamid,groupnum,creditmoney,price,freight,pay_type,discount,success from " . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1'
                , array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
            $total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . "  where teamid = :teamid  "
                ,array(':teamid'=>$order['teamid']));
            if (empty($order)) {
                app_error(1, '订单未找到');
            }
            if ($order['status'] != 0) {
                app_error(1, '订单不能取消');
            }
            pdo_update('ewei_shop_groups_order', array('status' => -1, 'canceltime' => time() , 'cancel_reason' => $cancel_reason), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
            //模板消息
            p('groups')->sendTeamMessage($orderid);
            app_json();
    }

    /*
	 * 查看物流
	 * */
    function express() {
        global $_W, $_GPC;
        $openid = $_W['openid'];
        $uniacid = $_W['uniacid'];
        $orderid = intval($_GPC['id']);

        if (empty($orderid)) {
            app_error( 1,'请传入orderid' );
        }
        $order = pdo_fetch("select * from " . tablename('ewei_shop_groups_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1'
            , array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
        if (empty($order)) {
            app_error(1,'订单未查到!');
        }
        if (empty($order['addressid'])) {
            app_error(1,'订单非快递单，无法查看物流信息!');
        }
        if ($order['status'] < 2) {
            app_error(1,'订单未发货，无法查看物流信息!');
        }
        //商品信息
        $goods = pdo_fetch("select *  from " . tablename('ewei_shop_groups_goods') . "  where id=:id and uniacid=:uniacid ", array(':uniacid' => $uniacid, ':id' => $order['goodid']));
        $expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
        $status = '';
        if (!empty($expresslist)) {
            if (strexists($expresslist[0]['step'], '签收')) {
                $status = '已签收';
            } else if (count($expresslist) <= 2) {
                $status = '备货中';
            } else {
                $status = '配送中';
            }
        }


        app_json(array(
            'com' => $order['expresscom'],
            'sn' => $order['expresssn'],
            'status' => $status,
            'count' => count($goods),
            'thumb' => tomedia($goods['thumb']),
            'expresslist' => $expresslist
        ));
    }


}