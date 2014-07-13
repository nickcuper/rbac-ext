<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
        const  ROLE_GUEST = 0;
        const  ROLE_AUTHOR = 1;
        const  ROLE_ADMIN = 2;
        const  ROLE_RBAC = 3; //can edit only rbac rules

        /** @var integer $id **/
	public $id;

        /** @var string $username **/
	public $username;

        /** @var string $name **/
	public $name;

        /** @var string $password **/
	public $password;

        /** @var integer $role **/
	public $role;

        /** @var string $password **/
	public $authKey;

        /** @var array $users **/
	private static $users = [
		'100' => [
			'id' => 100,
			'name' => 'admin',
			'username' => 'admin',
			'password' => 'admin',
			'role' => self::ROLE_ADMIN,
			'authKey' => 'test100key',
		],
		'101' => [
			'id' => 101,
			'name' => 'demo',
			'username' => 'demo',
			'password' => 'demo',
			'role' => self::ROLE_AUTHOR,
			'authKey' => 'test101key',
		],
		'102' => [
			'id' => 102,
			'name' => 'rbac',
			'username' => 'rbac',
			'password' => 'rbac',
			'role' => self::ROLE_RBAC,
			'authKey' => 'test102key',
		],
	];

        /** @var array $roles **/
	private static $roles = [
		self::ROLE_ADMIN => ['name'=> 'admin'],
		self::ROLE_AUTHOR => ['name'=> 'author'],
		self::ROLE_RBAC => ['name'=> 'rbac'],
		self::ROLE_GUEST => ['name'=> 'guest'],
	];

        /**
         * @param integer $id
         * @return array|null
         */
	public static function findIdentity($id)
	{
		return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
	}

        /**
         * @param string $username
         * @return \static|null
         */
	public static function findByUsername($username)
	{
		foreach (self::$users as $user) {
			if (strcasecmp($user['username'], $username) === 0) {
				return new static($user);
			}
		}
		return null;
	}

        /**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	public function getId()
	{
		return $this->id;
	}

        /**
         * Return role name
         * @param integer $roleId
         * @return string|null
         */
	public static function getRole($roleId)
	{
		return isset(self::$roles[$roleId]) ? new static(self::$roles[$roleId]) : null;
	}

	public function getAuthKey()
	{
		return $this->authKey;
	}

	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	public function validatePassword($password)
	{
		return $this->password === $password;
	}


}
