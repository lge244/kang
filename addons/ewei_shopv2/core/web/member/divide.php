<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Divide_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $divide = pdo_get('league_divide');

        include $this->template();
    }


    public function post()
    {
        global $_GPC;

        $res = pdo_update('league_divide', array('divide' => $_GPC['divide']));

        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '加盟设置成功')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '设置失败！网络错误')));

    }


}