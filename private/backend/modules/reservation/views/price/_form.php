<?php
/* @var $this yii\web\View */
/* @var $model backend\modules\reservation\models\PriceForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\modules\reservation\models\PriceForm;
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

		<?= $form->field($model, 'title')->textInput(['size' => 50, 'maxlength' => 50]) ?>
		<?= $form->field($model, 'price')->textInput(['size' => 5, 'maxlength' => 5]) ?>
		<?= $form->field($model, 'notice')->textarea() ?>

		<div class="form-group">
			<?= Html::submitButton($actionId != 'update' ? Module::t('res', 'Create') : Module::t('res', 'Update'), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>