<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UsageForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\models\UsageForm;
use common\models\Subject;
use kartik\datecontrol\DateControl;
use yii\bootstrap\ActiveField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/** @noinspection PhpUndefinedFieldInspection */
$actionId      = $this->context->action->id;
$dayTimes      = $model->getDayTimes();
$subjectsList =  ArrayHelper::merge(['0' => '== ' . Yii::t('back', 'new') . ' =='], Subject::getSubjects());
$timeFromTimes = array_slice( $dayTimes, 0, -1, true );
$timeToTimes   = array_slice( $dayTimes, 1, null, true );
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin( [
			'fieldClass' => ActiveField::className()
		] ); ?>

		<div class="row">
			<div class="col-xs-12 col-md-6">

				<?= $form->field($model, 'subject_id')->dropDownList($subjectsList); ?>
				<?= $form->field($model, 'name')->textInput([
					'value' => $model->subject_id > 0 ? $subjectsList[$model->subject_id] : '',
					'disabled' => $model->subject_id > 0 ? true : false
				]); ?>
				<?= $form->field($model, 'email')->input('email'); ?>
				<?= $form->field($model, 'phone')->textInput(); ?>

			</div>
			<div class="col-xs-12 col-md-6">
				<?= $form->field( $model, 'time_from' )->dropDownList( $timeFromTimes ); ?>
				<?= $form->field( $model, 'time_to' )->dropDownList( $timeToTimes ); ?>
				<?= $form->field( $model, 'repetition' )->dropDownList( $model->getRepeatOptions()); ?>
				<?= $form->field($model, 'repetition_end_date')->widget( DateControl::className(), [
					'type'     => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ); ?>
			</div>
		</div>

		<?= $form->field( $model, 'notice' )->textarea() ?>
		<?= $form->field( $model, 'date' )->hiddenInput()->label(false); ?>

		<div class="form-group">
			<?= Html::submitButton( $actionId != 'update' ? Yii::t( 'back', 'Create' ) : Yii::t( 'back', 'Update' ), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary'
			] ) ?>
		</div>

		<?php ActiveForm::end(); ?>

		<?php
		$urlSubjectData = Url::to(['subject/json-data']);
		$this->registerJs(
<<< EOT_JS
$(document).on('change', '#usageform-subject_id', function(e) { 
	var subjectId = $('#usageform-subject_id').val();
	if (subjectId > 0) {
		$.get('{$urlSubjectData}', { 'id' : subjectId }, function(data) {
			$('#usageform-name').val(data.name);
			$('#usageform-email').val(data.email);
			$('#usageform-phone').val(data.phone);
			$('#usageform-name').prop('disabled', true);
		});
	} else {
		$('#usageform-name').val('');
		$('#usageform-email').val('');
		$('#usageform-phone').val('');
		$('#usageform-name').prop('disabled', false);
	}
});
EOT_JS
		); ?>

	</div>

</div>