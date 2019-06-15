<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Withdraw_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$start_page = $_GPC['page'];
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 20;
		$total = count(pdo_getall('ewei_shop_withdraw'));
		$list = pdo_getall('ewei_shop_withdraw', '', '', '', 'status ASC,create_time DESC', [$start_page, 20]);
		$member_list = pdo_getall('ewei_shop_member');
		$mobile = [];
		foreach ($member_list as $v) {
			$mobile[$v['id']] = $v['mobile'];
		}
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	/**
	 * 提现审核通过
	 */
	public function pass()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}
		$record = pdo_get('ewei_shop_withdraw', ['id' => $id]);
		$member = pdo_get('ewei_shop_member', ['id' => $id]);
		$member_credit2 = $member['credit2'] - $record['price'] - $record['charge'];
		pdo_fetchall('set AUTOCOMMIT=0');//关闭自动提交
		pdo_fetchall('START TRANSACTION');//启动一个新事务
		$res1 = pdo_update('ewei_shop_withdraw', ['status' => 2], ['id' => $id]);
		$res2 = pdo_update('ewei_shop_member', ['credit2' => $member_credit2], ['id' => $id]);
		if (!$res1 || !$res2) {
			pdo_fetchall('ROLLBACK');//事务回滚
			$this->message('请求失败');
		}
		pdo_fetchall('COMMIT');//事务提交
		$this->message('请求成功', webUrl('member/withdraw'));
	}

	/**
	 * 删除
	 */
	public function del()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}
		$res = pdo_delete('ewei_shop_withdraw', ['id' => $id]);
		if (!$res) exit(show_json(0, ['msg' => '删除失败']));
		exit(show_json(1, ['msg' => '删除成功']));
	}
  
  	/**
	 * 提现配置
	 */
  	public function set ()
    {
      	global $_W;
      	global $_GPC;
        if (isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
          	$id = $_GPC['set_id'];
        	$small_price = $_GPC['small_price'];
          	$big_price = $_GPC['big_price'];
          	if (empty($small_price) || empty($big_price)) $this->message('请将信息填写完整');
          	$res = pdo_update('ewei_shop_withdraw_set', ['small_price' => $small_price, 'big_price' => $big_price], ['id' => $id]);
        	if (!$res) $this->message('保存失败');
          	$this->message('保存成功');
        }
      	$info = pdo_get('ewei_shop_withdraw_set');
    	include $this->template();
    }
}