<?php
/* @var $this yii\web\View */
/* @var $model backend\models\UsageForm */
/* @var $form yii\bootstrap\ActiveForm */

use backend\assets\AngularJSAsset;
use backend\models\UsageForm;
use kartik\datecontrol\DateControl;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

AngularJSAsset::register( $this );

/** @noinspection PhpUndefinedFieldInspection */
$actionId      = $this->context->action->id;
$dayTimes      = $model->getDayTimes();
$timeFromTimes = array_slice( $dayTimes, 0, -1, true );
$timeToTimes   = array_slice( $dayTimes, 1, null, true );
?>

<div class="row">

	<div class="col-sm-12">

		<?php $form = ActiveForm::begin( [
			'fieldClass' => ActiveField::className()
		] ); ?>

		<div data-ng-app="usage" data-ng-controller="usageController">
		<div class="row">
			<div class="col-xs-12 col-md-6">

				<?= $form->field($model, 'subject_id')->dropDownList([], [
					'data'  => [
						'ng-model'   => 'subject',
						'ng-options' => 'x.name for x in subjects track by x.id',
					]]); ?>
				<?= $form->field($model, 'name', [
					'options' => [
						'data-ng-hide' => 'subject.id > 0'
				]])->textInput(['value' => '{{subject.name}}']); ?>
				<?= $form->field($model, 'email')->input('email',  ['value' => '{{subject.email}}']); ?>
				<?= $form->field($model, 'phone')->textInput(['value' => '{{subject.phone}}']); ?>

			</div>
			<div class="col-xs-12 col-md-6">
				<?= $form->field( $model, 'time_from' )->dropDownList( $timeFromTimes ); ?>
				<?= $form->field( $model, 'time_to' )->dropDownList( $timeToTimes ); ?>
				<?= $form->field( $model, 'repetition' )->dropDownList( $model->getRepeatOptions(), [
					'data-ng-model' => 'repetition'
				] ); ?>
				<?= $form->field($model, 'repetition_end_date', [
					'options' => [
						'data-ng-show' => 'repetition > ' . UsageForm::NO_REPEAT
				]])->widget( DateControl::className(), [
					'type'     => DateControl::FORMAT_DATE,
					'language' => Yii::$app->language
				] ); ?>
			</div>
		</div>
		</div>

		<?php
		$subjectDataUrl = Url::to( [ '/subject/json-data' ] );
		$this->registerJs( '
				var app = angular.module("usage", []);
				app.controller("usageController", function($scope, $http) {
                    $http.get("' . $subjectDataUrl . '")
                        .then(function(response) 
                        {$scope.subjects = response.data;});
				});',
			View::POS_HEAD );
		?>

		<?= $form->field( $model, 'notice' )->textarea() ?>
		<?= $form->field( $model, 'date' )->hiddenInput()->label(false); ?>

		<div class="form-group">
			<?= Html::submitButton( $actionId != 'update' ? Yii::t( 'back', 'Create' ) : Yii::t( 'back', 'Update' ), [
				'class' => $actionId == 'create' ? 'btn btn-success' : 'btn btn-primary'
			] ) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>