<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $admin_role = $auth->createRole('admin');
        $admin_role->description = 'admin';
        $auth->add($admin_role);

        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'admin@admin.admin';
        $admin->generateAuthKey();
        $admin->setPassword('admin');
        $admin->save();

        $auth->assign($admin_role, $admin->id);
    }
}
