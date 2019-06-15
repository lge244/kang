<?php if (!defined("IN_IA")) {
	exit("Access Denied");
}

class Withdraw_EweiShopV2Page extends MobileLoginPage
{
	/**
	 * 模版
	 */
	public function main()
	{
		include($this->template());
	}

	/**
	 * 提现
	 */
	public function withdraw()
	{
		global $_W;
		global $_GPC;
		$price = $_GPC['price'];
		$name = $_GPC['name'];
		$number = intval($_GPC['number']);
		$safety = $_GPC['safety'];
		if (!is_numeric($price)) exit(show_json(0, ['msg' => '参数不合法']));
      	$set = pdo_get('ewei_shop_withdraw_set', ['id' => 1]);
      	if ($set['small_price'] != 0 && $set['big_price'] != 0) {
        	if ($price < $set['small_price']) exit(show_json(0, ['msg' => '提现金额不可小于' . $set['small_price']]));
            if ($price > $set['big_price']) exit(show_json(0, ['msg' => '提现金额不可大于' . $set['big_price']])); 
        }
		$member = pdo_get('ewei_shop_member', ['openid' => $_W['openid']]);
		if (md5($safety) != $member['safety']) exit(show_json(0, ['msg' => '安全密码错误']));
		if ($price > $member['credit2']) exit(show_json(0, ['msg' => '提现金额不可大于余额']));
		$res = pdo_insert('ewei_shop_withdraw', [
			'uid'         => $member['id'],
			'number'      => $number,
			'name'        => $name,
			'price'       => $price,
			'charge'      => $price * 0.05,
			'status'      => 1,
			'create_time' => time()
		]);
		if (!$res) exit(show_json(0, ['msg' => '提现失败']));
		exit(show_json(1, ['msg' => '提现成功，请等待管理员审核']));
	}
}

?>