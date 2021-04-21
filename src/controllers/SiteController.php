<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2016 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers;

use dmstr\modules\pages\models\Tree;
use dmstr\web\traits\AccessBehaviorTrait;
use yii\web\Controller;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    use AccessBehaviorTrait;

    /**
     * Renders the start page.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRootNode()
    {
        $rootNodeQuery = Tree::find()->where(['domain_id' => 'root']);
        $rootNode = $rootNodeQuery->one();
        return $this->run('/pages/default/page', ['pageId' => $rootNode->id]);
    }
}
