<?php
/**
 * App
 *
 * @category   BEAR
 * @package    bear.demo
 * @subpackage Ro
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: @package_version@ $Id:$
 * @link       http://@link_url@
 */

/**
 * リソースエラーサンプル
 *
 * @category   BEAR
 * @package    bear.demo
 * @subpackage Ro
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: @package_version@ $Id:$
 * @link       http://@link_url@
 */
class App_Ro_Sample_Error_More extends App_Ro
{
    /**
     * Read - Bad Requestエラー (assert)
     *
     * @param array $values values
     *
     * @return string
     * @required num
     */
    public function onRead($values)
    {
        $this->assert($values['num'] != 0, 'num must be not zero.'); //メッセージ指定あり
        $this->assert($values['num'] > 0); //メッセージ指定なし
        return "{$values['num']}は０より大きい数です";
    }

    /**
     * 商品リソース
     *
     * 404 Not foundのHTTP画面を出力します。
     *
     * @param array $values
     *
     * @return void
     * @throws Panda_Exception 商品はありません例外
     */
    public function onCreate($values)
    {
        throw new Panda_Exception('その商品はありません', 404);
    }

    /**
     * Update - リソース内部エラー
     *
     * リソース内部でエラーが起きたときはコード500(=BEAR::CODE_ERROR)の例外を発生させます。
     *
     * @param array $values
     *
     * @return void
     * @throws App_Ro_Sample_Error_More_Exception 更新不可例外
     */
    public function onUpdate($values)
    {
        $msg = '現在一切の更新はできません';
        $info = array('date' => _BEAR_DATETIME);
        throw $this->_exception(
            $msg, array(
            'code' => BEAR::CODE_ERROR,
            'info' => $info)
        );
    }


    /**
     * Delete - PEARエラー発生
     *
     * PEARエラーはそのまま返すとクライントはエラーRoオブジェクトで受け取ります。
     * PEARライブラリ使用の時に結果を確認することなくreturnしても、受け取った側はエラーRoオブジェクトとして処理できます。
     *
     * @param array $values
     *
     * @return BEAR_Ro
     */
    public function onDelete($values)
    {
        $array = $_SERVER;
        $ro = BEAR::factory('App_Ro')->setHeader('count', count($array))->setBody($array);
        return $ro;
    }
}