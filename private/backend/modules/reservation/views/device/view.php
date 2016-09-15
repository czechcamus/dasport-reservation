<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\Device */
/* @var $periodModel \backend\modules\reservation\models\PeriodForm */

use backend\modules\reservation\Module;
use backend\modules\reservation\widgets\PlanList;
use backend\modules\reservation\widgets\PriceList;
use backend\modules\reservation\widgets\UsageOverview;
use kartik\datecontrol\DateControl;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title                   = $model->title;
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Devices' ), 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode( $this->title ) ?></h1>

	<p>
		<?= Html::a( Module::t('res', 'Update' ), [ 'update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
		<?= Html::a( Module::t('res', 'Delete' ), [ 'delete', 'id' => $model->id ], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Module::t('res', 'Are you sure you want to delete this item?' ),
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
			<?= Html::a( Module::t('res', 'Add price' ), [ '/reservation/price/create', 'device_id' => $model->id ], [
				'class' => 'btn btn-success'
			] ); ?>
			<?= PriceList::widget( [ 'device_id' => $model->id ] ); ?>
		</div>
		<div class="col-xs-12 col-md-6">
			<?= Html::a( Module::t('res', 'Add plan' ), [ '/reservation/plan/create', 'device_id' => $model->id ], [
				'class' => 'btn btn-success'
			] ); ?>
			<?= PlanList::widget( [ 'device_id' => $model->id ] ); ?>
		</div>
	</div>

	<?php if ( $periodModel->existsActualPlans( ) ): ?>
		<div class="row">
			<div class="col-xs-12">

				<h2><?= Module::t('res', 'Usage overview' ); ?></h2>

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

				<?= Html::submitButton( Module::t('res', 'OK' ), [
					'class' => 'btn btn-default',
					'style' => 'position: relative; top: -5px;'
				] ) ?>

				<?php ActiveForm::end(); ?>

			</div>
		</div>

		<?= UsageOverview::widget( [ 'periodModel' => $periodModel ] ); ?>

	<?php endif; ?>

</div>