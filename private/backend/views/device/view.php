<?php

use backend\widgets\PlanList;
use backend\widgets\PriceList;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Device */

$this->title                   = $model->title;
$this->params['breadcrumbs'][] = [ 'label' => Yii::t( 'back', 'Devices' ), 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode( $this->title ) ?></h1>

	<p>
		<?= Html::a( Yii::t( 'back', 'Update' ), [ 'update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
		<?= Html::a( Yii::t( 'back', 'Delete' ), [ 'delete', 'id' => $model->id ], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Yii::t( 'back', 'Are you sure you want to delete this item?' ),
				'method'  => 'post',
			],
		] ) ?>
	</p>

	<?= DetailView::widget( [
		'model'      => $model,
		'attributes' => [
			'title',
			'text_id',
			'description',
		],
	] ) ?>

	<div class="row">
		<div class="col-xs-12 col-md-6">
			<?= Html::a( Yii::t( 'back', 'Add price' ), [ '/price/create', 'device_id' => $model->id ], [
				'class' => 'btn btn-success'
			] ); ?>
			<?= PriceList::widget( [ 'device_id' => $model->id ] ); ?>
		</div>
		<div class="col-xs-12 col-md-6">
			<?= Html::a( Yii::t( 'back', 'Add plan' ), [ '/plan/create', 'device_id' => $model->id ], [
				'class' => 'btn btn-success'
			] ); ?>
			<?= PlanList::widget( [ 'device_id' => $model->id ] ); ?>
		</div>
	</div>

	<?php if ( $model->plans ): ?>
		<div class="row">
			<div class="col-xs-12">

				<h2><?= Yii::t('back', 'Usage overview'); ?></h2>

				<?= Html::beginForm(['/device/dayList'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>

				<?= Html::label(Yii::t('back', 'First date'), 'firstDate'); ?>
				<?= DateControl::widget( [
					'name'  => 'firstDate',
					'value' => time(),
					'type'  => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ); ?>

				<?= Html::label(Yii::t('back', 'Last date'), 'lastDate'); ?>
				<?= DateControl::widget( [
					'name'  => 'lastDate',
					'value' => time(),
					'type'  => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ); ?>

				<?= Html::hiddenInput('device_id', $model->id); ?>

				<?= Html::submitButton(Yii::t('back', 'ok'), [
					'class' => 'btn btn-default'
				]) ?>

				<?php Html::endForm(); ?>

			</div>
		</div>
	<?php endif; ?>

</div>