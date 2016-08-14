<?php

use backend\widgets\PlanList;
use backend\widgets\PriceList;
use backend\widgets\UsageOverview;
use kartik\datecontrol\DateControl;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\models\Device */
/* @var $periodModel \backend\models\PeriodForm */

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

	<?php if ( $periodModel->existsActualPlans( $model->id ) ): ?>
		<div class="row">
			<div class="col-xs-12">

				<h2><?= Yii::t( 'back', 'Usage overview' ); ?></h2>

				<?php $form = ActiveForm::begin( [
					'layout'      => 'inline',
					'fieldClass'  => ActiveField::className(),
					'fieldConfig' => [
						'labelOptions' => [ 'class' => '' ],
						'enableError'  => true,
					]
				] ); ?>

				<?= $form->field( $periodModel, 'firstDate' )->widget( DateControl::className(), [
					'type'     => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ) ?>

				<?= $form->field( $periodModel, 'lastDate' )->widget( DateControl::className(), [
					'type'     => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ) ?>

				<?= Html::submitButton( Yii::t( 'back', 'OK' ), [
					'class' => 'btn btn-default',
					'style' => 'position: relative; top: -5px;'
				] ) ?>

				<?php ActiveForm::end(); ?>

			</div>
		</div>

		<?= UsageOverview::widget( [ 'periodModel' => $periodModel ] ); ?>

	<?php endif; ?>

</div>