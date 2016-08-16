<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UsageForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\assets\AngularJSAsset;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

AngularJSAsset::register( $this );

/** @noinspection PhpUndefinedFieldInspection */
$actionId = $this->context->action->id;
$timeFromTimes = $timeToTimes = $model->getDayTimes();
array_pop($timeFromTimes);
array_shift($timeToTimes);
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin( [
			'fieldClass' => ActiveField::className()
		] ); ?>

		<div class="row">
			<div class="col-xs-12 col-md-6">

				<div data-ng-app="subjects" data-ng-controller="subjectController">
					<div class="form-group">
						<?= Html::label(Yii::t( 'back', 'Subject' ), 'usageform-subject_id'); ?>
						<?= Html::dropDownList('UsageForm[subject_id]', null, [], [
							'data' => [
								'ng-model' => 'subject',
								'ng-options' => 'x.name for x in subjects track by x.id',
							],
							'id' => 'usageform-subject_id',
							'class' => 'form-control'
						]); ?>
					</div>
					<div data-ng-hide="subject.id > 0" class="form-group">
						<?= Html::label(Yii::t( 'back', 'Name' ), 'usageform-name'); ?>
						<?= Html::textInput('UsageForm[name]', null, [
							'id' => 'usageform-name',
							'class' => 'form-control'
						]); ?>
						<?= Html::error($model, 'name', [
							'tag' => 'p',
							'class' => 'help-block help-block-error'
						]); ?>
					</div>
					<div class="form-group">
						<?= Html::label(Yii::t( 'back', 'Email' ), 'usageform-email'); ?>
						<?= Html::input('email', 'UsageForm[email]', '{{subject.email}}', [
							'id' => 'usageform-email',
							'class' => 'form-control'
						]); ?>
						<?= Html::error($model, 'email', [
							'tag' => 'p',
							'class' => 'help-block help-block-error'
						]); ?>
					</div>
					<div class="form-group">
						<?= Html::label(Yii::t( 'back', 'Phone' ), 'usageform-email'); ?>
						<?= Html::textInput('UsageForm[phone]', '{{subject.phone}}', [
							'id' => 'usageform-phone',
							'class' => 'form-control'
						]); ?>
						<?= Html::error($model, 'phone', [
							'tag' => 'p',
							'class' => 'help-block help-block-error'
						]); ?>
					</div>
				</div>

			</div>
			<div class="col-xs-12 col-md-6">
				<?= $form->field($model, 'time_from')->dropDownList($timeFromTimes); ?>
				<?= $form->field($model, 'time_to')->dropDownList($timeToTimes); ?>
				<?= $form->field($model, 'repetition')->dropDownList($model->getRepeatOptions()); ?>

			</div>
		</div>

		<?php
		$subjectDataUrl = Url::to( [ '/subject/json-data' ] );
		$this->registerJs( '
				var app = angular.module("subjects", []);
				app.controller("subjectController", function($scope, $http) {
                    $http.get("' . $subjectDataUrl . '")
                        .then(function(response) 
                        {$scope.subjects = response.data;});
				});',
			View::POS_HEAD );
		?>

		<?= $form->field( $model, 'notice' )->textarea() ?>

		<div class="form-group">
			<?= Html::submitButton( $actionId != 'update' ? Yii::t( 'back', 'Create' ) : Yii::t( 'back', 'Update' ), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary'
			] ) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>