<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('back', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
$modelClass = Yii::t('back', 'Subject');
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

	<?= /** @noinspection PhpUnusedParameterInspection */
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'name',
			'email',
			'phone',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete} {copy}',
				'buttons' => [
					'copy' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', [
							'/subject/copy',
							'id' => $key
						],
						[
							'title' => Yii::t('back', 'Copy'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					}
				]
			]
		],
	]); ?>

</div>
