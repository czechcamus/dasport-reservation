<?php
/* @var $this yii\web\View */
/* @var $model backend\models\DeviceForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\models\DeviceForm;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/** @noinspection PhpUndefinedFieldInspection */
$actionId = $this->context->action->id;
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin([
			'fieldClass' => ActiveField::className()
		]); ?>

		<?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>
		<?= $form->field($model, 'text_id')->textInput(['maxlength' => 50]) ?>
		<?= $form->field($model, 'description')->textarea() ?>

		<div class="form-group">
			<?= Html::submitButton($actionId == 'create' ? Yii::t('back', 'Create') : Yii::t('back', 'Update'), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>