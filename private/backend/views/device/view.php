
<?php

use backend\widgets\PriceList;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Device */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('back', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('back', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('back', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Yii::t('back', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'title',
			'text_id',
			'description',
		],
	]) ?>

	<div class="row">
		<div class="col-xs-12 col-md-6">
			<?= Html::a(Yii::t('back', 'Add price'), ['/price/create', 'device_id' => $model->id], [
				'class' => 'btn btn-success'
			]); ?>
			<?= PriceList::widget(['device_id' => $model->id]); ?>
		</div>
	</div>

</div>