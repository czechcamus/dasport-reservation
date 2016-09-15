<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reservation\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\modules\reservation\Module;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Module::t('res', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
$modelClass = Module::t('res', 'Subject');
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Module::t('res', 'Create {modelClass}', compact('modelClass')), ['create'],
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
							'title' => Module::t('res', 'Copy'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					}
				]
			]
		],
	]); ?>

</div>
