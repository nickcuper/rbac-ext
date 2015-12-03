<?php

namespace app\components;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class PrivateRule extends Rule
{
    /** @var string $name **/
    public $name = 'private';

    /** @var array $private_id **/
    public $private_id = [];

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (\Yii::$app->user->isGuest) return null;

        $roleName = \app\models\User::getRole(\Yii::$app->user->getIdentity()->role)->name;

        if ($roleName && 
            isset($this->private_id[$roleName]) && 
            array_key_exists('deny', $this->private_id[$roleName]) && 
            in_array($params['post'], $this->private_id[$roleName]['deny'])
        ) {
                return false;
        }
        
        return true;
    }

}
