<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo  Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body style="margin-top: 100px;";>
<?php $this->beginBody() ?>
	<?php
		NavBar::begin([
			'brandLabel' => 'Home',
			'brandUrl' => '/',
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
		]);
                if (Yii::$app->user->isGuest) {
                    $menuItems = [
                        [
                            'label' => Yii::t('app', 'Login'), 
                            'url' => ['site/login']
                        ],
                    ];

                } else {
                    $menuItems = [
                        [
                            'label' => Yii::t('app','Logout ('. Yii::$app->user->identity->username.')'),
                            'url' => ['site/logout'],
                        ],
                    ];

                }
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $menuItems,
                    'encodeLabels'=>false,
                ]);
                
		NavBar::end();
	?>

	<div class="container">
		<?php if (Yii::$app->session->hasFlash('success')): ?>
			<div class="alert alert-success">
				<?php echo Yii::$app->session->getFlash('success'); ?>
			</div>
		<?php elseif (Yii::$app->session->hasFlash('error')): ?>
			<div class="alert alert-danger">
				<?php echo Yii::$app->session->getFlash('error'); ?>
			</div>
		<?php endif; ?>
		<?php echo  $content ?>
	</div>

	<footer class="footer">
		<div class="container">
			
			
		</div>
	</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>