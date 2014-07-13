<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

class RbacController extends Controller {

    public function actionInit()
    {
            $auth = Yii::$app->authManager;

            $auth->removeAll(); //remove previous rbac.php files under console/data

            // add "createPost" permission
            $createPost = $auth->createPermission('createPost');
            $createPost->description = 'Create a post';
            $auth->add($createPost);

            // add "rbacPost" permission
            $rbacPost = $auth->createPermission('rbacPost');
            $rbacPost->description = 'Rbac Post';
            $auth->add($rbacPost);

            // add "createPost" permission
            $viewPost = $auth->createPermission('viewPost');
            $viewPost->description = 'View a post';
            $viewPost->ruleName = 'view';
                    $rule = new \app\components\PrivateRule;
                    $rule->name = $viewPost->ruleName;
                    $rule->private_id = [
                        'admin' => [
                            'allow' => [6,8,10],
                            'deny' =>  [5,7,9],
                        ],
                        'author' => [
                            'deny' => [6,10],
                            'allow' =>  [5,7,9],
                        ],
                        'rbac' => [
                            'deny' => [8],
                        ]
                    ];
                    $auth->add($rule);
            $auth->add($viewPost);

            // add "deletePost" permission
            $deletePost = $auth->createPermission('deletePost');
            $deletePost->description = 'Delete post';
            $deletePost->ruleName = 'delete';
                    $rule = new \app\components\PrivateRule;
                    $rule->name = $deletePost->ruleName;
                    $auth->add($rule);
            $auth->add($deletePost);

            // add "updatePost" permission
            $updatePost = $auth->createPermission('updatePost');
            $updatePost->description = 'Update post';
            $updatePost->ruleName = 'update';
                    $rule = new \app\components\PrivateRule;
                    $rule->name = $updatePost->ruleName;
                    $auth->add($rule);
            $auth->add($updatePost);

            // add "author"
            $author = $auth->createRole('author');
            $auth->add($author);
            $auth->addChild($author, $createPost);
            $auth->addChild($author, $viewPost);

            // add "admin"
            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->addChild($admin, $updatePost);
            $auth->addChild($admin, $deletePost);
            $auth->addChild($admin, $author);

            // add "rbac"
            $rbac = $auth->createRole('rbac');
            $auth->add($rbac);
            $auth->addChild($rbac, $rbacPost);
            $auth->addChild($rbac, $viewPost);

            // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
            // usually implemented in your User model.
            $auth->assign($author, 101); //demo::demo
            $auth->assign($admin, 100);
            $auth->assign($rbac, 102);
    }

}
