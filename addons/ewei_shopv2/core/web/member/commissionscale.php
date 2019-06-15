<?php if (!defined("IN_IA")) {
    exit("Access Denied");
}

class Commissionscale_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $scale = pdo_getall('ewei_shop_commission_scale',array(),array());

        foreach ($scale as $k => $v) {
            $scale[$k]['agency'] = pdo_get('agency_area', array('id' => $v['is_agency']));
        }

        include $this->template();
    }

    public function add()
    {
        global $_GPC;
        if($_GPC['id'] > 0){
            $info = pdo_get("ewei_shop_commission_scale",array('id'=>$_GPC['id']));
        }

        include $this->template();
    }


    public function post()
    {
        global $_GPC;
        if($_GPC['hid'] > 0){
            $res = pdo_update('ewei_shop_commission_scale', array('title' => $_GPC['title'],'scale'=>$_GPC['scale']),array('id'=>$_GPC['hid']));
        }else{
            $res = pdo_insert('ewei_shop_commission_scale', array('title' => $_GPC['title'],'scale'=>$_GPC['scale']));
        }

        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '设置佣金比例成功')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '设置失败！网络错误')));

    }

    public  function del(){
        global  $_GPC;
        $res = pdo_delete('ewei_shop_commission_scale',array('id'=>$_GPC['id']));
        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '删除成功')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '删除失败！网络错误')));
    }
}