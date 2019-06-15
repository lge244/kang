<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Share_EweiShopV2Page extends MobileLoginPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $member = m('member')->getMember($_W['openid'], true);
        $info = m('share')->getFid($member['fid'],true);
        $level = m('member')->getLevel($_W['openid']);//获取用户的会员等级
        $fmember = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where id=:id limit 1', array(':id' => $member['fid']));
        $url ="http://".$_SERVER['SERVER_NAME']."/app/index.php?i=5&c=entry&m=ewei_shopv2&do=mobile&r=account.register"."&uid=".$member['id'];
        $team = m("share")->digui($member['id']);
        $price = m("share")->getTeamPerformance($member['id'],$member['openid']);
        $num = count($team);
        include $this->template();
    }
}
?>