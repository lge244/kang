<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Range_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $list = pdo_getall('team_range');
        include($this->template());
    }

    public function add()
    {
        include($this->template('team/range/post'));
    }

    public function post()
    {
        global $_GPC;
        $data['total'] = (int)trim($_GPC['total']);
        $data['ratio'] = (int)trim($_GPC['ratio']);
        $res = pdo_get('team_range', array('total' => $data['total']));
        if ($res) {
            exit(json_encode(array('code'=>1,'msg'=>'该级差等级已经存在! 请勿重复添加!')));
        }
        $res = pdo_insert('team_range',$data);
        if ($res) {
            exit(json_encode(array('code'=>0,'msg'=>'添加成功')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'网络错误! 添加失败! ')));

    }
}