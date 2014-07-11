<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use app\models\Posts;
use app\models\LoginForm;

class SiteController extends Controller
{

	/*public function behaviors()
	{
		return [
			'access' => [
				'class' => 'yii\filters\AccessControl',
				'only' => ['save', 'delete', 'logout'],
				'rules' => [
                                [
                                        'actions' => ['index', 'save', 'delete', 'view'],
                                        'allow' => true,
                                        'roles' => ['@'],
                                ],
				],
			]
                    
		];
	}*/

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			]
		];
	}

	public function actionLogin()
	{
		$this->layout = 'signin';

		if (!\Yii::$app->user->isGuest) {
                           return $this->redirect(\Yii::$app->urlManager->createUrl('site/index'));
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->redirect(\Yii::$app->urlManager->createUrl('site/index'));
	}

	/**
	 * Allows us to view records
	 */
	public function actionIndex()
	{
		$models = Posts::find()->all();
		return $this->render('index', array('models' => $models));
	}

	/**
	 * Handles update of our models
	 * @param int $id 	The $id of the model we want to updated
	 */
	public function actionUpdate($id=NULL)
	{
            if (!\Yii::$app->user->can('updatePost', ['post' => $id])) throw new HttpException(403, 'You are not authorize');
            
                $model = $this->loadModel($id);
                
		if (isset($_POST['Posts']))
		{
			if ($model->load(Yii::$app->request->post()) && $model->save())
			{
				Yii::$app->session->setFlash('success', 'Model has been saved');
				return $this->redirect(\Yii::$app->urlManager->createUrl('site/index'));
			}
			else
				Yii::$app->session->setFlash('error', 'Model could not be saved');
		}

		return $this->render('save', ['model' => $model]);
	}
        
	/**
	 * Create new record
	 */
	public function actionCreate()
	{
                if (!\Yii::$app->user->can('createPost')) throw new HttpException(403, 'You are not authorize');
                
                $model = new Posts;
		
		if (isset($_POST['Posts']))
		{
			if ($model->load(Yii::$app->request->post()) && $model->save())
			{
				Yii::$app->session->setFlash('success', 'Model has been saved');
				return $this->redirect(\Yii::$app->urlManager->createUrl('site/index'));
			}
			else
				Yii::$app->session->setFlash('error', 'Model could not be saved');
		}

		return $this->render('save', ['model' => $model]);
	}
        
	/**
	 * Handles deletion of our models
	 * @param int $id 	The $id of the model we want to delete
	 */
	public function actionView($id=NULL)
	{
                if(!\Yii::$app->user->can('viewPost')) throw new HttpException(403, 'You are not authorize');
		
		$model = $this->loadModel($id);

		return $this->render('view', ['model' => $model]);
	}

	/**
	 * Handles deletion of our models
	 * @param int $id 	The $id of the model we want to delete
	 */
	public function actionDelete($id=NULL)
	{
                if(!\Yii::$app->user->can('deletePost')) throw new HttpException(403, 'You are not authorize');
                    
		$model = $this->loadModel($id);

		if (!$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete model');

		$this->redirect(\Yii::$app->urlManager->createUrl('site/index'));
	}

	/**
	 * Loads our model and throws an exception if we encounter an error
	 * @param int $id 	The $id of the model we want to delete
	 */
	private function loadModel($id)
	{
		$model = Posts::findOne($id);

		if ($model == NULL)
			throw new HttpException(404, 'Model not found.');

		return $model;
	}
}