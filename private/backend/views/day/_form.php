<?php
/* @var $this yii\web\View */
/* @var $model backend\models\DayForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\models\DayForm;
use kartik\time\TimePicker;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @noinspection PhpUndefinedFieldInspection */
$actionId = $this->context->action->id;
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin( [
			'fieldClass' => ActiveField::className()
		] ); ?>

		<?= $form->field( $model, 'is_open' )->checkbox() ?>

		<?= $form->field( $model, 'time_from' )->widget( TimePicker::className(), [
			'pluginOptions' => [
				'defaultTime'  => false,
				'showSeconds'  => false,
				'showMeridian' => false
			],
			'options'       => [
				'class' => 'form-control'
			]
		] ) ?>

		<?= $form->field( $model, 'time_to' )->widget( TimePicker::className(), [
			'pluginOptions' => [
				'defaultTime'  => false,
				'showSeconds'  => false,
				'showMeridian' => false
			],
			'options'       => [
				'class' => 'form-control'
			]
		] ) ?>

		<div class="form-group">
			<?= Html::submitButton( $actionId != 'update' ? Yii::t( 'back', 'Create' ) : Yii::t( 'back', 'Update' ), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary'
			] ) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>