<?php
/* @var $this yii\web\View */
/* @var $model backend\models\PlanForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\models\PlanForm;
use kartik\datecontrol\DateControl;
use kartik\time\TimePicker;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\Spinner;

/** @noinspection PhpUndefinedFieldInspection */
$actionId = $this->context->action->id;
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin( [
			'fieldClass' => ActiveField::className()
		] ); ?>

		<?= $form->field( $model, 'date_from' )->widget( DateControl::className(), [
			'type'     => DateControl::FORMAT_DATE,
			'language' => Yii::$app->language
		] ) ?>

		<?= $form->field( $model, 'date_to' )->widget( DateControl::className(), [
			'type'     => DateControl::FORMAT_DATE,
			'language' => Yii::$app->language
		] ) ?>

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

		<?= $form->field( $model, 'hour_length' )->widget( Spinner::className() ) ?>

		<div class="form-group">
			<?= Html::submitButton( $actionId != 'update' ? Yii::t( 'back', 'Create' ) : Yii::t( 'back', 'Update' ), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary'
			] ) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>