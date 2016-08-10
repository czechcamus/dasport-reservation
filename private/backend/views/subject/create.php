<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \backend\models\SubjectForm */

/** @var \backend\controllers\SubjectController $controller */
$controller = $this->context;
$modelClass = Yii::t('back', 'Subject');
$this->title = Yii::t('back', 'Create {modelClass}', compact('modelClass'));
$this->params['breadcrumbs'][] = [ 'label' => Yii::t( 'back', 'Subjects' ), 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>
