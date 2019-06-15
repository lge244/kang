<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

class FixQiniu_EweiShopV2Page extends WebPage
{

    public function main()
    {
        global $_W, $_GPC;

        // 如果是post请求,那么处理请求
        $_W['ispost'] && $this->handler();

        include $this->template();

    }


    protected function handler()
    {
        global $_W, $_GPC;

        // 原始域名
        $originDomain = $_GPC['originDomain'];
        // 新的七牛域名
        $newDomain = $_GPC['newDomain'];
        // TODO

        if (empty($originDomain) || empty($newDomain)) {
            show_json(0, '原始域名和现在域名不能为空');
        }

        $originDomain = trim($originDomain, '/');
        $newDomain = trim($newDomain, '/');

        if(strpos($originDomain, 'http') === false && strpos($originDomain, 'https') === false) {
            show_json(0, '原域名请带http或https协议头');
        }
        if(strpos($newDomain, 'http') === false && strpos($newDomain, 'https') === false) {
            show_json(0, '新域名请带http或https协议头');
        }

        // 商品表
        $goodsTable = tablename("ewei_shop_goods");
        // 分类表
        $categoryTable = tablename("ewei_shop_category");
        // 栏目问题表
        $questionTable = tablename('ewei_shop_qa_question');


        // 创建表副本
        try {
            $this->createTableCopyIfNotExists( $goodsTable, time() );
            $this->createTableCopyIfNotExists($categoryTable, time());
            p('qa') && $this->createTableCopyIfNotExists($questionTable, time());
        } catch (Exception $exception) {
            show_json(0, $exception->getMessage());
        }

        // 更新商品表的sql
        $updateGoodsTableSQL = <<<FUCK
            update {$goodsTable} 
            set 
              `thumb` = replace(`thumb`, '{$originDomain}', '{$newDomain}'),
              `content` = replace(`content`, '{$originDomain}', '{$newDomain}'),
              `thumb_url` = replace(`thumb_url`, '{$originDomain}', '{$newDomain}')
            where 
              `uniacid` = {$_W['uniacid']}
FUCK;

        // 更新栏目表的sql
        $updateCategorySQL = <<<SHIT
            update {$categoryTable} 
            set 
              `thumb` = replace(`thumb`, '{$originDomain}', '{$newDomain}')
            where 
              `uniacid` = {$_W['uniacid']}
SHIT;

        // 更新帮助中心内容帮助页的sql
        $updateQuestionSQL = <<<QUESTION
            update {$questionTable} 
            set 
              `content` = replace(`content`, '{$originDomain}', '{$newDomain}')
            where 
              `uniacid` = {$_W['uniacid']}
QUESTION;




        // 更新原表数据
        pdo_run($updateGoodsTableSQL);
        pdo_run($updateCategorySQL);
        p('qa') && pdo_run($updateQuestionSQL);

        $account = pdo_fetchcolumn("select name from ".tablename('account_wechats'). " where uniacid = {$_W['uniacid']}");

        $logInfo = array(
            'sql'   =>
                "\nupdateGoods:\n".
                $updateGoodsTableSQL .PHP_EOL .
                "updateCategory:\n".
                $updateCategorySQL,
            'originDomain'  => $originDomain,
            'newDomain' => $newDomain,
            'uniacid'   => $_W['uniacid'],
            'account'   => $account,
        );

        p('qa') && $logInfo .= "\nupdateQuestion:\n".$updateQuestionSQL;


        $this->log($logInfo);


        show_json(1, "修复成功");
    }

    /**
     * 生成备份表
     * ims_ewei_shop_member (原表名称)
     * 生成后
     * ims_ewei_shop_member_copy_{$hash}表名 (备份表名)
     * @param $tableName string 表名
     * @param $hash number|string 随机字符串
     * @return bool
     * @throws Exception string
     */
    protected function createTableCopyIfNotExists($tableName, $hash)
    {
        $tableCopyName = trim($tableName, '`');
        $tableCopyPrefixName = $tableCopyName . "_copy_";
        $tableCopyName .= "_copy_" . $hash;
        $tableCopyExists = pdo_fetch("show tables like '{$tableCopyPrefixName}%'");
        if (!$tableCopyExists) {
            pdo_run("create table {$tableCopyName} select * from {$tableName} where 1");
            $tableCopyExists = pdo_fetch("show tables like '{$tableCopyPrefixName}%'");
            if (!$tableCopyExists) {
                throw new Exception("备份失败,请检查当前数据库用户是否有创建表权限!");
            }
        }

        return true;
    }


    /**
     * @param $log array 要写入的数据内容
     * @param $append bool 是否开启追加模式
     */
    protected function log($log, $append = true)
    {

        $logPath = IA_ROOT . "/addons/ewei_shopv2/data/backup";

        if(!is_dir($logPath)) {
            mkdir($logPath);

        }
        $currentDay = date('Ymd', time());

        $logFile = $logPath . "/fixQiniu{$currentDay}.log";

        // 日志记录时间
        $logTime = date("Y-m-d H:i:s", time());

        $logFormat = <<<EOF
[时间]{$logTime},
[sql]{$log['sql']},
[修复前域名]{$log['originDomain']}
[修复后域名]{$log['newDomain']}
[公众号ID]{$log['uniacid']}
[公众号名称]{$log['account']}
EOF;
        $logFormatContent = $logFormat .PHP_EOL."-----------------------------------------------\n";

        $append = $append == true ? FILE_APPEND : 0;
        file_put_contents($logFile,$logFormatContent, $append);
    }

}
