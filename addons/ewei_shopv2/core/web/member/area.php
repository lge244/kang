<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Area_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $agency = pdo_getall('agency_area');
        include $this->template();
    }

    public function add()
    {
        $city = pdo_getall('ims_region', array('REGION_TYPE' => 1), array('id', 'REGION_NAME'));
        include $this->template();
    }

    public function getAddress()
    {
        global $_GPC;

        $city = pdo_getall('ims_region', array('REGION_TYPE' => $_GPC['id']), array('id', 'REGION_NAME'));
        $city2 = '';
        foreach ($city as $k => $v) {
            $id = $v['id'];
            $city2 .= <<<HEREDOC
              <option value="$id" >{$v['REGION_NAME']}</option>
HEREDOC;
        }

        exit(json_encode(array('code' => 0, 'city_list' => $city2)));

    }

    public function post()
    {
        global $_GPC;
        $data['proportion'] = $_GPC['proportion'];
        $data['address'] = $_GPC['address'];
        $res = pdo_insert('agency_area',$data);
        if ($res){
            exit(json_encode(array('code'=>0,'msg'=>'添加成功')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'网络错误')));
    }
}