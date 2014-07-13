<?php

namespace app\components;

use Yii;
use yii\rbac\Role;
use yii\helpers\ArrayHelper;

class PhpManager extends \yii\rbac\PhpManager
{
    /** @inheritdoc */
    public $itemFile = '@app/data/items.php';

    /** @inheritdoc */
    public $assignmentFile = '@app/data/assignments.php';

    /** @inheritdoc */
    public $ruleFile = '@app/data/rules.php';

    /** @var boolean $_isExecurerule If not null use for checkAccess **/
    private $_isExecurerule = null;

    /**
     * @inheritdoc
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
            $assignments = $this->getAssignments($userId);
            $_recAR = $this->checkAccessRecursive($userId, $permissionName, $params, $assignments);

            if (sizeof($params) && $this->_isExecurerule !== null) {
                return $this->_isExecurerule;
            } else return $_recAR;
    }

    /**
     * @inheritdoc
     */
    protected function checkAccessRecursive($user, $itemName, $params, $assignments)
    {
            if (!isset($this->items[$itemName])) {
                return false;
            }

            /* @var $item Item */
            $item = $this->items[$itemName];
            Yii::trace($item instanceof Role ? "Checking role: $itemName" : "Checking permission : $itemName", __METHOD__);

            if ($this->_isExecurerule === null && $item->ruleName !== null) {
                $this->_isExecurerule = $this->executeRule($user, $item, $params);
            }

            if (!$this->executeRule($user, $item, $params)) {
                return false;
            }

            if (isset($assignments[$itemName]) || in_array($itemName, $this->defaultRoles)) {
                return true;
            }

            foreach ($this->children as $parentName => $children) {
                if (isset($children[$itemName]) && $this->checkAccessRecursive($user, $parentName, $params, $assignments)) {
                    return true;
                }
            }

            return false;
    }

    /**
     * @return array
     */
    public function getRoleListData()
    {
            $roles = $this->getRoles();
            return ArrayHelper::map($roles, 'name', 'name');
    }

    /**
     * @return array
     */
    public function getRuleListData()
    {
            $items = $this->getItems(2);
            foreach ($items as $k => $_item)
            {
                    if ($_item->ruleName == null)
                            unset($items[$k]);
            }

            return ArrayHelper::map($items, 'name', 'name');
    }

    /**
     * Update RBAC rules with Post request
     * @param array $rules
     * @param string $ruleName This actions name
     * @see \app\commands\RbacController
     * @return true;
     */
    public function customUpdateRule($rules, $ruleName)
    {
            $rule = new \app\components\PrivateRule;
            $rule->name = $ruleName;
            foreach ($this->getRoles() as $role) {
                    $this->preppareRules($rules, $role->name);
            }
            $rule->private_id = $rules;

            $this->removeRule($rule);
            $this->addRule($rule);
            return true;
    }

    /**
     * Explode params (allow|deny)
     * @param array $rules
     */
    protected function preppareRules(&$rules, $role)
    {
            if (!isset($rules[$role])) return;

            if (isset($rules[$role]['allow']) && !empty($rules[$role]['allow']))
                $rules[$role]['allow'] = array_map('intval', explode (',', $rules[$role]['allow']));
            else unset($rules[$role]['allow']);

            if (isset($rules[$role]['deny']) && !empty($rules[$role]['deny']))
                $rules[$role]['deny'] = array_map('intval', explode (',', $rules[$role]['deny']));
            else unset($rules[$role]['deny']);

            if (!isset($rules[$role]['allow']) && !isset($rules[$role]['deny']))
                unset($rules[$role]);


    }

}
