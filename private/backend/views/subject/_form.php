<?php
/* @var $this yii\web\View */
/* @var $model backend\models\SubjectForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\models\SubjectForm;
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

		<?= $form->field($model, 'name')->textInput(['size' => 50, 'maxlength' => 50]) ?>
		<?= $form->field($model, 'email')->textInput(['size' => 50, 'maxlength' => 50]) ?>
		<?= $form->field($model, 'phone')->textInput(['size' => 20, 'maxlength' => 20]) ?>

		<div class="form-group">
			<?= Html::submitButton($actionId != 'update' ? Yii::t('back', 'Create') : Yii::t('back', 'Update'), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>