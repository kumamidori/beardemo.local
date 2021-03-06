<?php
/**
 * App
 *
 * @category   BEAR
 * @package    bear.demo
 * @subpackage Page
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: @package_version@ $Id:$
 * @link       http://@link_url@
 */

require_once 'App.php';

/**
 * リソースリンクページ
 *
 * <pre>
 * ユーザー -> （写真、ブログ ）-> 記事　->　（トラックバック、コメント）->　コメント評価リソースとリンクされています。
 * 括弧内は並列でリンクされているリソースですが以降のリンクは最後のリソースからリンクされます。
 * </pre>
 *
 * @category   BEAR
 * @package    bear.demo
 * @subpackage Page
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: @package_version@ $Id:$
 * @link       http://@link_url@
 */
class Page_Resource_Link extends App_Page
{

    /**
     * Inject
     *
     * @return void
     */
    public function onInject()
    {
        parent::onInject();
        $this->injectGet('id', 'id', 1);
    }

    /**
     * Init
     *
     * @requied id
     *
     * @return void
     */
    public function onInit(array $args)
    {
        $params = array(
            'uri' => 'User',
            'values' => array('id' => $args['id']),
            'options' => array(
                'template' => 'link/blog',
                'cache' => array('life' => 10, 'link' => true)
            )
        );
        $this->_resource->read($params)->link(array('photo', 'blog'))->link('entry')->link(array('trackback', 'comment'))->link('thumb')->set('blog', 'object');
    }

    /**
     * Output
     *
     * @return void
     */
    public function onOutput()
    {
        $this->display('/resource/link/list/template.tpl');
    }
}

App_Main::run('Page_Resource_Link');
