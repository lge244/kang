<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Transfer_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$start_page = $_GPC['page'];
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 20;
		$total = count(pdo_getall('ewei_shop_member_transfer'));
		$list = pdo_getall('ewei_shop_member_transfer', '', '', '', '', [$start_page, 20]);
		$member_list = pdo_getall('ewei_shop_member');
		$mobile = [];
		foreach ($member_list as $v) {
			$mobile[$v['id']] = $v['mobile'];
		}
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
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
		$res = pdo_delete('ewei_shop_member_transfer', ['id' => $id]);
		if (!$res) exit(show_json(0, ['msg' => '删除失败']));
		exit(show_json(1, ['msg' => '删除成功']));
	}
}