<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\SubjectForm */

use backend\modules\reservation\Module;
use yii\helpers\Html;

/** @var \backend\modules\reservation\controllers\SubjectController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Subject');
$this->title = Module::t('res', 'Update {modelClass}: ', compact('modelClass')) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('res', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>