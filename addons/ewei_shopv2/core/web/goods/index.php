<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage {

    function main($goodsfrom='sale') {

        global $_W, $_GPC;

        if(empty($_W['shopversion'])){
            $goodsfrom = strtolower(trim($_GPC['goodsfrom']));
            if(empty($goodsfrom)){
                header('location: ' . webUrl('goods', array('goodsfrom'=>'sale')));
            }
        }else{
            if(!empty($_GPC['goodsfrom'])){
                header('location: ' . webUrl('goods/'. $_GPC['goodsfrom']));
            }
        }

        //多商户
        $merch_plugin = p('merch');
        $merch_data = m('common')->getPluginset('merch');
        if ($merch_plugin && $merch_data['is_openmerch']) {
            $is_openmerch = 1;
        } else {
            $is_openmerch = 0;
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $sqlcondition = $groupcondition = '';
        $condition = ' WHERE g.`uniacid` = :uniacid and g.type<>9';
        $params = array(':uniacid' => $_W['uniacid']);
        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);

            $sqlcondition = ' left join ' . tablename('ewei_shop_goods_option') . ' op on g.id = op.goodsid';
            if ($merch_plugin) {
                $sqlcondition .= " left join " . tablename('ewei_shop_merch_user') . " merch on merch.id = g.merchid and merch.uniacid=g.uniacid";
            }

            $groupcondition = ' group by g.`id`';

            $condition .= ' AND (g.`id` = :id or g.`title` LIKE :keyword or g.`keywords` LIKE :keyword or g.`goodssn` LIKE :keyword or g.`productsn` LIKE :keyword or op.`title` LIKE :keyword or op.`goodssn` LIKE :keyword or op.`productsn` LIKE :keyword';
            if ($merch_plugin) {
                $condition .= ' or merch.`merchname` LIKE :keyword';
            }
            $condition .= ' )';

            $params[':keyword'] = '%' . $_GPC['keyword'] . '%';
            $params[':id'] = $_GPC['keyword'];
        }

        if (!empty($_GPC['cate'])) {
            $_GPC['cate'] = intval($_GPC['cate']);
            $condition .= " AND FIND_IN_SET({$_GPC['cate']},cates)<>0 ";
        }

        if(!empty($_GPC['attribute'])){
                if($_GPC['attribute'] == 'new'){
                    $condition .= " AND `isnew`=1 ";
                }elseif ($_GPC['attribute'] == 'hot'){
                    $condition .= " AND `ishot`=1 ";
                }elseif ($_GPC['attribute'] == 'recommand'){
                    $condition .= " AND `isrecommand`=1 ";
                }elseif ($_GPC['attribute'] == 'discount'){
                    $condition .= " AND `isdiscount`=1 ";
                }elseif ($_GPC['attribute'] == 'time'){
                    $condition .= " AND `istime`=1 ";
                }elseif ($_GPC['attribute'] == 'sendfree'){
                    $condition .= " AND `issendfree`=1 ";
                }elseif ($_GPC['attribute'] == 'nodiscount'){
                    $condition .= " AND `isdiscount`=1 ";
                }
        }

        empty($goodsfrom) && $_GPC['goodsfrom'] = $goodsfrom = 'sale';
        $_GPC['goodsfrom'] = $goodsfrom;

        if ($goodsfrom == 'sale') {
            $condition .= ' AND g.`status` > 0 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0';
            $status = 1;
        } else if ($goodsfrom == 'out') {
            $condition .= ' AND g.`status` > 0 and g.`total` <= 0 and g.`deleted`=0 and g.type!=30';
            $status = 1;
        } else if ($goodsfrom == 'stock') {
            $status = 0;
            $condition .= ' AND (g.`status` = 0 or g.`checked`=1) and g.`deleted`=0';
        } else if ($goodsfrom == 'cycle') {
            $status = 0;
            $condition .= ' AND g.`deleted`=1';
        }else if ($goodsfrom == 'verify') {
            $status = 0;
            $condition .= ' AND g.`deleted`=0 and merchid>0 and checked=1';
        }


        $sql = 'SELECT g.id FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition;
        $total_all = pdo_fetchall($sql, $params);
        $total = count($total_all);
        unset($total_all);
        if (!empty($total)) {
            $sql = 'SELECT g.* FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition . ' ORDER BY g.`status` DESC, g.`displayorder` DESC,
                g.`id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql, $params);
            foreach($list as $key => &$value){
                $value['allcates'] = explode(",",$value['cates']);
                $value['allcates']=array_unique($value['allcates']);
                $url = mobileUrl('goods/detail', array('id' => $value['id']),true);
                $value['qrcode'] = m('qrcode')->createQrcode($url);
                $sale_cpcount=pdo_fetch("SELECT sum(og.total)  as sale_count   FROM ims_ewei_shop_order_goods  og LEFT JOIN ims_ewei_shop_order o on og.orderid=o.id  WHERE og.goodsid=:gsid and o.`status`>=:status and o.refundid = 0 and og.uniacid=:uniacid",array(':gsid'=>$value['id'],':status'=>1,':uniacid'=>$_W['uniacid']));
                $value['sale_cpcount']=$sale_cpcount['sale_count'];
            }

            $pager = pagination2($total, $pindex, $psize);

            if ($merch_plugin) {
                $merch_user = $merch_plugin->getListUser($list,'merch_user');
                if (!empty($list) && !empty($merch_user)) {
                    foreach ($list as &$row) {
                        $row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
                    }
                }
            } 
        }

        $categorys = m('shop')->getFullCategory(true,true);
		$category = array();
		foreach($categorys as $cate){
			$category[$cate['id']] = $cate;
		}

		$goodstotal = intval($_W['shopset']['shop']['goodstotal']);
		$shopset = $_W['shopset']['shop'];

		include $this->template('goods');
    }

    function sale() {
        $this->main('sale');
    }
    function out() {
        $this->main('out');
    }
    function stock() {
        $this->main('stock');
    }
    function cycle() {
        $this->main('cycle');
    }
    function verify() {
        $this->main('verify');
    }

    function create() {
        global $_W, $_GPC;
        $merchid = intval($_W['merchid']);
        $com_virtual = com('virtual');

        /*会员等级*/
        $levels = m('member')->getLevels();
        foreach($levels as &$l){
            $l['key'] ='level'.$l['id'];
        }
        unset($l);

        if ($_W['ispost']) {
            $data = array(
                'uniacid' => intval($_W['uniacid']),
                'title' => trim($_GPC['goodsname']),//商品名称
                'unit' => trim($_GPC['unit']),//商品单位
                'keywords' => trim($_GPC['keywords']),//关键字
                'type' => intval($_GPC['type']),//商品类型
                'thumb_first' => intval($_GPC['thumb_first']),//详情显示缩略图
                'isrecommand' => intval($_GPC['isrecommand']),//推荐
                'isnew' => intval($_GPC['isnew']),//新品
                'ishot' => intval($_GPC['ishot']),//热卖
                'issendfree' => intval($_GPC['issendfree']),//包邮
                'isnodiscount' => intval($_GPC['isnodiscount']),//不参与会员折扣
                'marketprice' => floatval($_GPC['marketprice']),//售价
                'minprice' => floatval($_GPC['marketprice']),//售价
                'maxprice' => floatval($_GPC['marketprice']),//售价
                'productprice' => trim($_GPC['productprice']),//原价
                'costprice' => $_GPC['costprice'],//成本
                'virtualsend' => intval($_GPC['virtualsend']),//虚拟物品自动发货
                'virtualsendcontent' => trim($_GPC['virtualsendcontent']),//自动发货内容
                'virtual'=>intval($_GPC['type'])==3?intval($_GPC['virtual']):0,//多规格虚拟物品
                'cash' => intval($_GPC['cash']),//是否支持货到付款
                'cashier' => intval($_GPC['cashier']),//是否支持收银台
                'invoice' => intval($_GPC['invoice']),//是否支持发票
                'dispatchtype' => intval($_GPC['dispatchtype']),//运费类型
                'dispatchprice' => trim($_GPC['dispatchprice']),//统一运费
                'dispatchid' => intval($_GPC['dispatchid']),//运费模板ID
                'status' => intval($_GPC['status']),//上架

                'goodssn' => trim($_GPC['goodssn']),//编码
                'productsn' => trim($_GPC['productsn']),//条码
                'weight' => $_GPC['weight'],//重量
                'total' => intval($_GPC['total']),//库存
                'showtotal' => intval($_GPC['showtotal']),//是否显示库存
                'totalcnf' => intval($_GPC['totalcnf']),//减库存类型
                'hasoption' => intval($_GPC['hasoption']),//是否有规格

                'subtitle' => trim($_GPC['subtitle']),//商品副标题
                'shorttitle' => trim($_GPC['shorttitle']),//商品短标题
                'content' => m('common')->html_images($_GPC['content']),//商品详情


                'createtime' => TIMESTAMP,//创建时间
                'video'=>trim($_GPC['video'])
            );

            $discounts = array('type'=>0, 'default'=>'', 'default_pay'=>'');
            if(!empty($levels)){
                foreach($levels as $level){
                    $discounts[$level['key']] = '';
                    $discounts[$level['key']. '_pay'] = '';
                }
                unset($level);
            }
            $data['discounts'] = json_encode($discounts);

            /*
             * 商品分类
             * */
            $cateset = m('common')->getSysset('shop');
            $pcates = array();
            $ccates = array();
            $tcates = array();
            $fcates = array();
            $cates = array();
            $pcateid=0;
            $ccateid = 0;
            $tcateid = 0;
            if (is_array($_GPC['cates'])) {

                $cates = $_GPC['cates'];

                foreach ($cates as $key=>$cid) {

                    $c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

                    if($c['level']==1){ //一级
                        $pcates[] = $cid;
                    } else if($c['level']==2){  //二级
                        $ccates[] = $cid;
                    } else if($c['level']==3){  //三级
                        $tcates[] =$cid;
                    }

                    if($key==0){
                        //兼容 1.x
                        if($c['level']==1){ //一级
                            $pcateid = $cid;
                        }
                        else if($c['level']==2){
                            $crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
                            $pcateid = $crow['parentid'];
                            $ccateid = $cid;

                        }
                        else if($c['level']==3){
                            $tcateid = $cid;
                            $tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
                            $ccateid = $tcate['parentid'];
                            $ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
                            $pcateid = $ccate['parentid'];
                        }
                    }


                }

            }

            $data['pcate'] = $pcateid;
            $data['ccate'] = $ccateid;
            $data['tcate'] = $tcateid;
            $data['cates'] = implode(',', $cates);

            $data['pcates'] = implode(',', $pcates);
            $data['ccates'] = implode(',', $ccates);
            $data['tcates'] = implode(',', $tcates);
            /*保存图片*/
            if (is_array($_GPC['thumbs'])) {
                $thumbs = $_GPC['thumbs'];
                $thumb_url = array();
                foreach ($thumbs as $th) {
                    $thumb_url[] = trim($th);
                }
                //兼容1.x
                $data['thumb'] = save_media($thumb_url[0]);
                unset($thumb_url[0]);
                $data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
            }
            if($data['type']==4)
            {
                //批发商品 阶梯价格设置
                $intervalfloor = intval($_GPC['intervalfloor']);
                if($intervalfloor>3||$intervalfloor<1)
                {
                    show_json(0,'请至少添加一个区间价格！');
                }
                $intervalprices = array();
                if($intervalfloor>0)
                {
                    if(intval($_GPC['intervalnum1'])<=0)
                    {
                        show_json(0,'请设置起批发量！');
                    }
                    if(floatval($_GPC['intervalprice1'])<=0)
                    {
                        show_json(0,'批发价必须大于0！');
                    }
                    $intervalprices[]=array("intervalnum"=>intval($_GPC['intervalnum1']),"intervalprice"=>floatval($_GPC['intervalprice1']));
                }
                if($intervalfloor>1)
                {
                    if(intval($_GPC['intervalnum2'])<=0)
                    {
                        show_json(0,'请设置起批发量！');
                    }
                    if(intval($_GPC['intervalnum2'])<=intval($_GPC['intervalnum1']))
                    {
                        show_json(0,'批发量需大于上级批发量！');
                    }
                    if(floatval($_GPC['intervalprice2'])>=floatval($_GPC['intervalprice1']))
                    {
                        show_json(0,'批发价需小于上级批发价！');
                    }
                    $intervalprices[]=array("intervalnum"=>intval($_GPC['intervalnum2']),"intervalprice"=>floatval($_GPC['intervalprice2']));
                }
                if($intervalfloor>2)
                {
                    if(intval($_GPC['intervalnum3'])<=0)
                    {
                        show_json(0,'请设置起批发量！');
                    }
                    if(intval($_GPC['intervalnum3'])<=intval($_GPC['intervalnum2']))
                    {
                        show_json(0,'批发量需大于上级批发量！');
                    }
                    if(floatval($_GPC['intervalprice3'])>=floatval($_GPC['intervalprice2']))
                    {
                        show_json(0,'批发价需小于上级批发价！');
                    }

                    $intervalprices[]=array("intervalnum"=>intval($_GPC['intervalnum3']),"intervalprice"=>floatval($_GPC['intervalprice3']));
                }
                //加密
                $intervalprice = iserializer($intervalprices);

                $data['intervalfloor']  = $intervalfloor;
                $data['intervalprice']  = $intervalprice;

                $data['minbuy']  = $_GPC['intervalnum1'];
                $data['marketprice']  = $_GPC['intervalprice1'];
                $data['productprice']  = 0;
                $data['costprice']  = 0;
            }
            /*
             * 商品自动上架
             * */
            $data['isstatustime'] = intval($_GPC['isstatustime']);
            $data['statustimestart'] = strtotime($_GPC['statustime']['start']);
            $data['statustimeend'] = strtotime($_GPC['statustime']['end']);
            if($data['status']==1 && $data['isstatustime'] > 0){
                if(!($data['statustimestart'] < time() && $data['statustimeend'] > time())){
                    show_json(0,'上架时间不符合要求！');
                }
            }

            //show_json(0,$data);
            pdo_insert('ewei_shop_goods', $data);
            $id = pdo_insertid();
            plog('goods.add', "添加商品 ID: {$id}<br>".(!empty($data['nocommission']) ? "是否参与分销 -- 否" : "是否参与分销 -- 是"));
            //处理商品规格
            $files = $_FILES;
            $spec_ids = $_POST['spec_id'];
            $spec_titles = $_POST['spec_title'];
            $specids = array();
            $len = count($spec_ids);
            $specids = array();
            $spec_items = array();
            for ($k = 0; $k < $len; $k++) {
                $spec_id = "";
                $get_spec_id = $spec_ids[$k];
                $a = array(
                    "uniacid" => $_W['uniacid'],
                    "goodsid" => $id,
                    "displayorder" => $k,
                    "title" => $spec_titles[$get_spec_id]
                );
                if (is_numeric($get_spec_id)) {
                    pdo_update("ewei_shop_goods_spec", $a, array("id" => $get_spec_id));
                    $spec_id = $get_spec_id;
                } else {
                    pdo_insert("ewei_shop_goods_spec", $a);
                    $spec_id = pdo_insertid();
                }
                //子项
                $spec_item_ids = $_POST["spec_item_id_" . $get_spec_id];
                $spec_item_titles = $_POST["spec_item_title_" . $get_spec_id];
                $spec_item_shows = $_POST["spec_item_show_" . $get_spec_id];
                $spec_item_thumbs = $_POST["spec_item_thumb_" . $get_spec_id];
                $spec_item_oldthumbs = $_POST["spec_item_oldthumb_" . $get_spec_id];
                $spec_item_virtuals = $_POST["spec_item_virtual_" . $get_spec_id];

                $itemlen = count($spec_item_ids);
                $itemids = array();
                for ($n = 0; $n < $itemlen; $n++) {
                    $item_id = "";
                    $get_item_id = $spec_item_ids[$n];
                    $d = array(
                        "uniacid" => $_W['uniacid'],
                        "specid" => $spec_id,
                        "displayorder" => $n,
                        "title" => $spec_item_titles[$n],
                        "show" => $spec_item_shows[$n],
                        "thumb" => save_media($spec_item_thumbs[$n]),
                        "virtual" => $data['type'] == 3 ? $spec_item_virtuals[$n] : 0
                    );
                    $f = "spec_item_thumb_" . $get_item_id;
                    if (is_numeric($get_item_id)) {
                        pdo_update("ewei_shop_goods_spec_item", $d, array("id" => $get_item_id));
                        $item_id = $get_item_id;
                    } else {
                        pdo_insert("ewei_shop_goods_spec_item", $d);
                        $item_id = pdo_insertid();
                    }
                    $itemids[] = $item_id;
                    //临时记录，用于保存规格项
                    $d['get_id'] = $get_item_id;
                    $d['id'] = $item_id;
                    $spec_items[] = $d;
                }
                //删除其他的
                if (count($itemids) > 0) {
                    pdo_query("delete from " . tablename('ewei_shop_goods_spec_item') . " where uniacid={$_W['uniacid']} and specid=$spec_id and id not in (" . implode(",", $itemids) . ")");
                } else {
                    pdo_query("delete from " . tablename('ewei_shop_goods_spec_item') . " where uniacid={$_W['uniacid']} and specid=$spec_id");
                }
                //更新规格项id
                pdo_update("ewei_shop_goods_spec", array("content" => serialize($itemids)), array("id" => $spec_id));
                $specids[] = $spec_id;
            }
            //删除其他的
            if (count($specids) > 0) {
                pdo_query("delete from " . tablename('ewei_shop_goods_spec') . " where uniacid={$_W['uniacid']} and goodsid=$id and id not in (" . implode(",", $specids) . ")");
            } else {
                pdo_query("delete from " . tablename('ewei_shop_goods_spec') . " where uniacid={$_W['uniacid']} and goodsid=$id");
            }
            //保存规格
            $totalstocks = 0;
            $optionArray = json_decode($_POST['optionArray'],true);
            $option_idss = $optionArray['option_ids'];
            $len = count($option_idss);
            $optionids = array();
            for ($k = 0; $k < $len; $k++) {
                $option_id = "";
                $ids = $option_idss[$k];
                $get_option_id = $optionArray['option_id'][$k];

                $idsarr = explode("_", $ids);
                $newids = array();
                foreach ($idsarr as $key => $ida) {
                    foreach ($spec_items as $it) {
                        if ($it['get_id'] == $ida) {
                            $newids[] = $it['id'];
                            break;
                        }
                    }
                }

                $newids = implode("_", $newids);
                $a = array(
                    "uniacid" => $_W['uniacid'],
                    "title" => $optionArray['option_title'][$k],
                    "productprice" => $optionArray['option_productprice'][$k],
                    "costprice" => $optionArray['option_costprice'][$k],
                    "marketprice" => $optionArray['option_marketprice'][$k],
                    "stock" => $optionArray['option_stock'][$k],
                    "weight" => $optionArray['option_weight'][$k],
                    "goodssn" => $optionArray['option_goodssn'][$k],
                    "productsn" => $optionArray['option_productsn'][$k],
                    "goodsid" => $id,
                    "specs" => $newids,
                    'virtual' => $data['type'] == 3 ? $optionArray['option_virtual'][$k] : 0,
                );

                if($data['type']==4)
                {
                    $a['presellprice']=0;
                    $a['productprice']=0;
                    $a['costprice'] = 0;
                    $a['marketprice']=intval($_GPC['intervalprice1']);
                }

                $totalstocks+=$a['stock'];
                pdo_insert("ewei_shop_goods_option", $a);
                $option_id = pdo_insertid();

                $optionids[] = $option_id;
                if (count($optionids) > 0 && $data['hasoption'] !== 0) {
                    pdo_query("delete from " . tablename('ewei_shop_goods_option') . " where goodsid=$id and id not in ( " . implode(',', $optionids) . ")");

                    //更新最低价和最高价
                    $sql = "update ".tablename('ewei_shop_goods')." g set
                    g.minprice = (select min(marketprice) from ".tablename('ewei_shop_goods_option')." where goodsid = $id),
                    g.maxprice = (select max(marketprice) from ".tablename('ewei_shop_goods_option')." where goodsid = $id)
                    where g.id = $id and g.hasoption=1";

                    pdo_query($sql);
                } else {
                    pdo_query("delete from " . tablename('ewei_shop_goods_option') . " where goodsid=$id");
                    $sql = "update ".tablename('ewei_shop_goods')." set minprice = marketprice,maxprice = marketprice where id = $id and hasoption=0;";
                    pdo_query($sql);
                }
            }
            //如果是有促销,那么更新最大最小价格
            $sqlgoods = "SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,merchsale FROM " . tablename('ewei_shop_goods') . " where id=:id and uniacid=:uniacid limit 1";
            $goodsinfo = pdo_fetch($sqlgoods,array(':id'=>$id,':uniacid'=>$_W['uniacid']));
            $goodsinfo = m('goods')->getOneMinPrice($goodsinfo);

            pdo_update('ewei_shop_goods',array('minprice'=>$goodsinfo['minprice'],'maxprice'=>$goodsinfo['maxprice']),array('id'=>$id,'uniacid'=>$_W['uniacid']));
            //总库存
            if ($data['type'] == 3 && $com_virtual) {
                $com_virtual->updateGoodsStock($id);
            } else {
                if ($data['hasoption'] !== 0 && ($data['totalcnf'] != 2) && empty($data['unite_total'])) {
                    pdo_update("ewei_shop_goods", array("total" => $totalstocks), array("id" => $id));
                }
            }
            show_json(1,array('url'=>webUrl('goods/edit', array('id' => $id))));
        }
        $statustimestart = time();
        $statustimeend = strtotime('+1 month');
        $category = m('shop')->getFullCategory(true,true);
        $com_virtual = com('virtual');

        //查询快递模板
        $dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' =>$merchid));
        $levels =array_merge(array(
            array(
                'id'=>0,
                'key'=>'default',
                'levelname'=>empty($_W['shopset']['shop']['levelname'])?'默认会员':$_W['shopset']['shop']['levelname']
            )
        ),$levels);

        if ($com_virtual) {
            $virtual_types = pdo_fetchall("select * from " . tablename('ewei_shop_virtual_type') . " where uniacid=:uniacid and merchid=:merchid and recycled = 0 order by id asc", array(":uniacid" => $_W['uniacid'], ':merchid' =>0));
        }

        include $this->template('goods/create');
    }

    function add() {
        $this->post();
    }
    function edit() {
        $this->post();
    }

    protected function post() {

        require dirname(__FILE__)."/post.php";
    }

    function delete() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        $items = pdo_fetchall("SELECT id,title FROM " . tablename('ewei_shop_goods') . " WHERE id in( $id ) AND uniacid=" . $_W['uniacid']);
        foreach ($items as $item) {
            pdo_update('ewei_shop_goods', array('deleted' => 1), array('id' => $item['id']));
            plog('goods.delete', "删除商品 ID: {$item['id']} 商品名称: {$item['title']} ");
        }
        show_json(1, array('url' => referer()));
    }

    function status() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        //'新'字角标去除
        pdo_query("update ".tablename('ewei_shop_goods')." set newgoods = 0 where id in ( {$id} ) AND uniacid=" . $_W['uniacid']);

        $items = pdo_fetchall("SELECT id,title,status,isstatustime,statustimestart,statustimeend FROM " . tablename('ewei_shop_goods') . " WHERE id in( $id ) AND uniacid=" . $_W['uniacid']);

        foreach ($items as $item) {
            if($item['isstatustime']>0){
                if(intval($_GPC['status']) > 0 && $item['statustimestart'] < time() && $item['statustimeend'] > time()){

                }else{
                    show_json(0,"商品 [{$item['title']}] 上架时间不符合要求！");
                }
            }
            $goodsstatus = $_GPC['status'] == 1 ? '上架' : '下架';
            pdo_update('ewei_shop_goods', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
            plog('goods.edit', "修改商品状态<br/>ID: {$item['id']}<br/>商品名称: {$item['title']}<br/>状态: " .$goodsstatus);
        }
        show_json(1, array('url' => referer()));
    }

    function checked() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        $items = pdo_fetchall("SELECT id,title FROM " . tablename('ewei_shop_goods') . " WHERE id in( $id ) AND uniacid=" . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_goods', array('checked' => intval($_GPC['checked'])), array('id' => $item['id']));
            plog('goods.edit', "修改商品状态<br/>ID: {$item['id']}<br/>商品名称: {$item['title']}<br/>状态: " . $_GPC['checked'] == 0 ? '审核通过' : '审核中');
        }

        show_json(1, array('url' => referer()));
    }

    function delete1() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        $items = pdo_fetchall("SELECT id,title FROM " . tablename('ewei_shop_goods') . " WHERE id in( $id ) AND uniacid=" . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_delete('ewei_shop_goods', array('id' => $item['id']));
            plog('goods.edit', "从回收站彻底删除商品<br/>ID: {$item['id']}<br/>商品名称: {$item['title']}");
        }
        show_json(1, array('url' => referer()));
    }

    function restore() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
        }
        $items = pdo_fetchall("SELECT id,title FROM " . tablename('ewei_shop_goods') . " WHERE id in( $id ) AND uniacid=" . $_W['uniacid']);

        foreach ($items as $item) {
            pdo_update('ewei_shop_goods', array('deleted' => 0), array('id' => $item['id']));
            plog('goods.edit', "从回收站恢复商品<br/>ID: {$item['id']}<br/>商品名称: {$item['title']}");
        }
        show_json(1, array('url' => referer()));
    }

    function property() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $type = $_GPC['type'];
        $data = intval($_GPC['data']);
        if (in_array($type, array('new', 'hot', 'recommand', 'discount', 'time', 'sendfree', 'nodiscount'))) {

            pdo_update("ewei_shop_goods", array("is" . $type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
            if ($type == 'new') {
                $typestr = "新品";
            } else if ($type == 'hot') {
                $typestr = "热卖";
            } else if ($type == 'recommand') {
                $typestr = "推荐";
            } else if ($type == 'discount') {
                $typestr = "促销";
            } else if ($type == 'time') {
                $typestr = "限时卖";
            } else if ($type == 'sendfree') {
                $typestr = "包邮";
            } else if ($type == 'nodiscount') {
                $typestr = "不参与折扣状态";
            }
            plog('goods.edit', "修改商品{$typestr}状态   ID: {$id}");
        }
        if (in_array($type, array('status'))) {
            pdo_update("ewei_shop_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
            plog('goods.edit', "修改商品上下架状态   ID: {$id}");
        }
        if (in_array($type, array('type'))) {
            pdo_update("ewei_shop_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
            plog('goods.edit', "修改商品类型   ID: {$id}");
        }
        show_json(1);
    }

    function change() {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            show_json(0, array('message' => '参数错误'));
        }else{
            pdo_update('ewei_shop_goods',array('newgoods'=>0),array('id'=>$id));
        }
        $type = trim($_GPC['type']);
        $value = trim($_GPC['value']);
        if (!in_array($type, array('title', 'marketprice', 'total', 'goodssn', 'productsn', 'displayorder', 'dowpayment'))) {
            show_json(0, array('message' => '参数错误'));
        }
        $goods = pdo_fetch('select id,hasoption,marketprice,dowpayment,type from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
        if (empty($goods)) {
            show_json(0, array('message' => '参数错误'));
        }

        if($type=='dowpayment') {
            if($goods['marketprice']<$value){
                show_json(0, array('message' => '定金不能大于总价'));
            }
        }elseif ($type=='marketprice'){
            if($goods['dowpayment']>$value){
                show_json(0, array('message' => '总价不能小于定金'));
            }
        }

        if($type=='total' && $goods['type'] == 3){
            show_json(0, array('message' => '虚拟卡密产品不可直接修改库存'));
        }
        $result = pdo_update('ewei_shop_goods', array($type => $value), array('id' => $id));
        if($type=='total'&& $result){
            plog('goods.list', "编辑商品 ID: {$id}<br>库存量为".$value);
        }

        if ($goods['hasoption'] == 0 && $type != 'displayorder') {
            $sql = "update ".tablename('ewei_shop_goods')." set minprice = marketprice,maxprice = marketprice where id = {$goods['id']} and hasoption=0;";
            pdo_query($sql);
        }
        show_json(1);
    }

    function tpl() {
        global $_GPC, $_W;
        $tpl = trim($_GPC['tpl']);
        if ($tpl == 'option') {

            $tag = random(32);
            include $this->template('goods/tpl/option');
        } else if ($tpl == 'spec') {

            $spec = array("id" => random(32), "title" => $_GPC['title']);
            include $this->template('goods/tpl/spec');
        } else if ($tpl == 'specitem') {

            $spec = array("id" => $_GPC['specid']);
            $specitem = array("id" => random(32), "title" => $_GPC['title'], "show" => 1);
            include $this->template('goods/tpl/spec_item');
        } else if ($tpl == 'param') {

            $tag = random(32);
            include $this->template('goods/tpl/param');
        }
    }

    function query(){
        global $_W, $_GPC;
        $kwd = trim($_GPC['keyword']);
        $type = intval($_GPC['type']);

        $live = intval($_GPC['live']);

        $params = array();
        $params[':uniacid'] = $_W['uniacid'];
        $condition=" and status=1 and deleted=0 and uniacid=:uniacid";
        if (!empty($kwd)) {
            $condition.=" AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)";
            $params[':keywords'] = "%{$kwd}%";
        }
        if (empty($type)) {
            $condition.=" AND `type` != 10 ";
        }else{
            $condition.=" AND `type` = :type ";
            $params[':type'] = $type;
        }

        $ds = pdo_fetchall('SELECT id,title,thumb,marketprice,productprice,share_title,share_icon,description,minprice,costprice,total,sales,islive,liveprice FROM ' . tablename('ewei_shop_goods') . " WHERE 1 {$condition} order by createtime desc", $params);
        foreach($ds as &$value){
            $value['share_title'] = htmlspecialchars_decode($value['share_title']);
            unset($value);
        }
        $ds = set_medias($ds, array('thumb','share_icon'));
        if($_GPC['suggest']){
            die(json_encode(array('value'=>$ds)));
        }
        include $this->template();

    }

    function goodsprice()
    {
        global $_W;
        $sql = "update ".tablename('ewei_shop_goods')." g set 
g.minprice = (select min(marketprice) from ".tablename('ewei_shop_goods_option')." where g.id = goodsid),
g.maxprice = (select max(marketprice) from ".tablename('ewei_shop_goods_option')." where g.id = goodsid)
where g.hasoption=1 and g.uniacid=".$_W['uniacid'].";
update ".tablename('ewei_shop_goods')." set minprice = marketprice,maxprice = marketprice where hasoption=0 and uniacid=".$_W['uniacid'].";";
        pdo_run($sql);
        show_json(1);
    }



    // 批量分类模版显示
    function batchcates(){
        $categorys = m('shop')->getFullCategory(true);
        $category = array();
        foreach($categorys as $cate){
            $category[$cate['id']] = $cate;
        }
        include $this->template();
    }

    //批量修改分类
    function ajax_batchcates(){
        global $_W,$_GPC;

        //是否覆盖分类
        $iscover=$_GPC['iscover'];
        $goodsids=$_GPC['goodsids'];
        $cates=$_GPC['cates'];
        $data=array();

        //处理分类
        $reust_cates=$this->reust_cates($cates);

        foreach ($goodsids as $goodsid){
            //覆盖原有分类
            if(!empty($iscover)){
                $data=$reust_cates;
                $data['cates'] = implode(',', $data['cates']);
                $data['pcates'] = implode(',', $data['pcates']);
                $data['ccates'] = implode(',', $data['ccates']);
                $data['tcates'] = implode(',', $data['tcates']);

                pdo_update('ewei_shop_goods', $data, array('id' => $goodsid));
            }else{
                //不覆盖原有分类
                $goods = pdo_fetch('select pcate,ccate,tcate,cates,pcates,ccates,tcates  from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $goodsid, ':uniacid' => $_W['uniacid']));
                if (!empty($goods['cates'])){
                    $goods_cates=explode(',',$goods['cates']);
                    if(!empty($reust_cates['cates'])){
                        //合并去重复后将数组转换成字符串
                        $data['cates'] =implode(',', array_unique(array_merge($goods_cates,$reust_cates['cates']),SORT_NUMERIC ));
                    }
                }
                if (!empty($goods['pcates'])){
                    $goods_pcates=explode(',',$goods['pcates']);
                    if(!empty($reust_cates['pcates'])){
                        //合并去重复后将数组转换成字符串
                        $data['pcates'] =implode(',', array_unique(array_merge($goods_pcates,$reust_cates['pcates']),SORT_NUMERIC ));
                    }
                }
                if (!empty($goods['ccates'])){
                    $goods_ccates=explode(',',$goods['ccates']);
                    if(!empty($reust_cates['ccates'])){
                        //合并去重复后将数组转换成字符串
                        $data['ccates'] =implode(',', array_unique(array_merge($goods_ccates,$reust_cates['ccates']),SORT_NUMERIC ));
                    }
                }
                if (!empty($goods['tcates'])){
                    $goods_tcates=explode(',',$goods['tcates']);
                    if(!empty($reust_cates['tcates'])){
                        //合并去重复后将数组转换成字符串
                        $data['tcates'] =implode(',', array_unique(array_merge($goods_tcates,$reust_cates['tcates']),SORT_NUMERIC ));
                    }
                }

                if(!empty($reust_cates['pcate'])){
                    $data['pcate'] = $reust_cates['pcate'] ;
                }

                if(!empty($reust_cates['ccate'])){
                    $data['ccate'] = $reust_cates['ccate'];
                }

                if(!empty( $reust_cates['tcate'])){
                    $data['tcate'] = $reust_cates['tcate'];
                }

                pdo_update('ewei_shop_goods', $data, array('id' => $goodsid));

            }
        }
        show_json(1);
    }


    //返回处理过的分类信息--批量分类调用
    function  reust_cates($param_cates){
        global $_W;
        $pcates = array();
        $ccates = array();
        $tcates = array();
        $cates = array();
        $pcateid=0;
        $ccateid = 0;
        $tcateid = 0;
        if (is_array($param_cates)) {
            foreach ($param_cates as $key=>$cid) {
                $c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
                if($c['level']==1){ //一级
                    $pcates[] = $cid;
                } else if($c['level']==2){  //二级
                    $ccates[] = $cid;
                } else if($c['level']==3){  //三级
                    $tcates[] =$cid;
                }
                if($key==0){
                    //兼容 1.x
                    if($c['level']==1){ //一级
                        $pcateid = $cid;
                    }
                    else if($c['level']==2){
                        $crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
                        $pcateid = $crow['parentid'];
                        $ccateid = $cid;
                    }
                    else if($c['level']==3){
                        $tcateid = $cid;
                        $tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
                        $ccateid = $tcate['parentid'];
                        $ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
                        $pcateid = $ccate['parentid'];
                    }
                }
            }
        }
        $data['pcate'] = $pcateid;
        $data['ccate'] = $ccateid;
        $data['tcate'] = $tcateid;
        $data['cates'] = $param_cates;
        $data['pcates'] =$pcates;
        $data['ccates'] = $ccates;
        $data['tcates'] = $tcates;
        return $data;
    }

}
