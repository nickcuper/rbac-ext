<?php

namespace app\models;

use \yii\db\ActiveRecord;
/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $data
 * @property string $create_time
 * @property string $update_time
 */
class Posts extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'posts';
	}

	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
                                'attributes' => [
                                    ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
                                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                                ],
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['title', 'data'], 'required'],
			[['data'], 'string'],
			[['create_time', 'update_time'], 'safe'],
			[['title'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'title' => 'Title',
			'data' => 'Data',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		];
	}
}
