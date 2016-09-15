<?php
/* @var $this yii\web\View */
/* @var $model backend\modules\reservation\models\DeviceForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\modules\reservation\models\DeviceForm;
use backend\modules\reservation\Module;
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

		<?= $form->field($model, 'title')->textInput(['size' => 50, 'maxlength' => true]) ?>
		<?= $form->field($model, 'text_id')->textInput(['size' => 50, 'maxlength' => true]) ?>
		<?= $form->field($model, 'description')->textarea() ?>

		<div class="form-group">
			<?= Html::submitButton($actionId != 'update' ? Module::t('res', 'Create') : Module::t('res', 'Update'), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>