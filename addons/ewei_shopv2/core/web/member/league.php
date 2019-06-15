<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class League_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $member = pdo_getall('ewei_shop_member', array('is_league' => 1), array('id', 'nickname', 'is_agency', 'mobile'));

        foreach ($member as $k => $v) {
            $member[$k]['agency'] = pdo_get('agency_area', array('id' => $v['is_agency']));
        }

        include $this->template();
    }

    public function add()
    {
        $member = pdo_getall('ewei_shop_member', array('is_league' => 0), array('id', 'nickname'));
        $agency = pdo_getall('agency_area');
        include $this->template();
    }

    public function post()
    {
        global $_GPC;

        $res = pdo_update('ewei_shop_member', array('is_league' => $_GPC['is_league']), array('id' => $_GPC['user']));

        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '加盟设置成功')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '设置失败！网络错误')));

    }


}