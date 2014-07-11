<?php

namespace app\components;

use Yii;
use yii\rbac\Role;

class PhpManager extends \yii\rbac\PhpManager 
{
    /** @var array $privateRules **/
    public $privateRules = [];

    /** @inheritdoc */
    public $authFile = '@app/data/rbac.php';

}