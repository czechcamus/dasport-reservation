<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$session = Yii::$app->session;

$this->title = Yii::t('back', 'Devices');
$this->params['breadcrumbs'][] = $this->title;
$modelClass = Yii::t('back', 'Device');
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('back', 'Create {modelClass}', compact('modelClass')), ['create'],
			[
				'class' => 'btn btn-success'
			]
		) ?>
	</p>

	<?php if ($session->hasFlash('info')): ?>
		<div class="alert alert-success">
			<?= $session->getFlash('info'); ?>
		</div>
	<?php endif; ?>

	<?= /** @noinspection PhpUnusedParameterInspection */
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'title',
			'text_id',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete} {copy} {view} {usage}',
				'buttons' => [
					'copy' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', [
							'device/copy',
							'id' => $key
						],
						[
							'title' => Yii::t('back', 'Copy'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					},
					'usage' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>', [
							'device/usage',
							'id' => $key
						],
						[
							'title' => Yii::t('back', 'Usage'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					}
				]
			]
		],
	]); ?>

</div>
