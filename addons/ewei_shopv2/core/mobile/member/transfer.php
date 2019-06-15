<?php if (!defined("IN_IA")) {
	exit("Access Denied");
}

class Transfer_EweiShopV2Page extends MobileLoginPage
{
	/**
	 * 模版
	 */
	public function main()
	{
		include($this->template());
	}

	/**
	 * 转账
	 */
	public function transfer()
	{
		global $_W;
		global $_GPC;
		// 手机号码
		$mobile = $_GPC['mobile'];
		// 转账金额
		$price = $_GPC['price'];
		// 交易密码
		$safety = $_GPC['safety'];
		if (empty($mobile) || empty($price)) exit(show_json(0, ['msg' => '请将信息填写完整']));
		if (!preg_match("/^1[3456789]\d{9}$/", $mobile)) exit(show_json(0, ['msg' => '请填写正确的手机号码']));
		if (!is_numeric($price)) exit(show_json(0, ['msg' => '请填写正确的转账金额']));
		$member = pdo_get('ewei_shop_member', ['openid' => $_W['openid']]);
		if (md5($safety) != $member['safety']) exit(show_json(0, ['msg' => '安全密码错误']));
		if ($member['credit2'] < $price) exit(show_json(0, ['msg' => '转账金额不可大于余额']));
		if ($member['mobile'] == $mobile) exit(show_json(0, ['msg' => '收款人不能是自己']));
		$payee = pdo_get('ewei_shop_member', ['mobile' => $mobile]);
		if (!$payee) exit(show_json(0, ['msg' => '收款人不存在']));
		$mem_credit2 = $member['credit2'] - $price;
		$payee_credit2 = $payee['credit2'] + $price;
		// 事务
		pdo_fetchall('set AUTOCOMMIT=0');//关闭自动提交
		pdo_fetchall('START TRANSACTION');//启动一个新事务
		$member_res = pdo_update('ewei_shop_member', ['credit2' => $mem_credit2], ['id' => $member['id']]);
		$payee_res = pdo_update('ewei_shop_member', ['credit2' => $payee_credit2], ['id' => $payee['id']]);
		if (!$member_res || !$payee_res) {
			pdo_fetchall('ROLLBACK');//事务回滚
			exit(show_json(0, ['msg' => '转账失败']));
		}
		pdo_fetchall('COMMIT');//事务提交
		pdo_insert('ewei_shop_member_transfer', [
			'transferor'  => $member['id'],
			'payee'       => $payee['id'],
			'price'       => $price,
			'create_time' => time(),
		]);
		exit(show_json(1, ['msg' => '转账成功']));
	}
}

?>