<?php
/* @var $this yii\web\View */
/* @var $periodModel \backend\models\PeriodForm */
/* @var $device \common\models\Device */

use common\models\Day;
use common\models\Plan;
use common\models\Usage;
use yii\helpers\Html;

?>

<div class="row">
	<?php
	$device = $periodModel->device;
	for ($i = strtotime($periodModel->firstDate); $i <= strtotime($periodModel->lastDate); $i += 86400) {
		echo $i . ' - ' . strtotime($periodModel->firstDate);
		if ($plan = Plan::find()->where(['device_id' => $device->id])->andWhere(['<=', 'date_from', date('Y-m-d', $i)])->andWhere(['>=', 'date_to', date('Y-m-d', $i)])->one()) {
			if ($day = Day::find()->where(['plan_id' => $plan->id])->andWhere(['day_nr' => date('N', $i)])->one()) {
				echo '<div class="col-xs-6 col-md-4 col-lg-3"><table class="table table-bordered table-striped table-condensed">';
				echo '<tr><th colspan="3">' . $day->getDayName() . ' ' . date('d.m.Y', $i) . '</th></tr>';
				for ($j = strtotime(date('Y-m-d', $i) . ' ' . $plan->time_from), $k = 1; $j <= strtotime(date('Y-m-d', $i) . ' ' . $plan->time_to); $j += $plan->hour_length * 60) {
					if ( date('H:i', $j) >= date('H:i', strtotime($day->time_from)) && date('H:i', $j) <= date('H:i', strtotime($day->time_to)) ) {
						echo '<tr>';
						echo '<td>' . date('H:i', $j) . '</td>';
						echo '<td';
						if ($usage = Usage::find()->where(['device_id' => $device->id])->andWhere(['date' => date('Y-m-d', $i)])->andWhere(['hour_nr' => $k])->one()) {
							echo ' class="used"';
						}
						echo ' style="width: 70%">' . ($usage ? $usage->subject->name : '&nbsp;') . '</td>';
						echo '<td>';
						if ($usage) {
							echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', [
								'/usage/update',
								'id' => $usage->id
							], [
								'title' => Yii::t('back', 'Update usage'),
								'class' => 'btn btn-link',
							]);
							echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', [
								'/usage/delete',
								'id' => $usage->id
							], [
								'title' => Yii::t('back', 'Delete usage'),
								'class' => 'btn btn-link',
							]);
						} else {
							echo Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', [
								'/usage/create',
								'device_id' => $device->id,
								'date' => date('Y-m-d', $i),
								'hour_nr' => $k
							], [
								'title' => Yii::t('back', 'Add usage'),
								'class' => 'btn btn-link',
							]);
						}
						echo '</td>';
						echo '</tr>';
					} else {
						echo '<tr><td colspan="3" style="padding: 12px;">&nbsp;</td></tr>';
					}
					++$k;
				}
				echo '</table></div>';
			}
		}
	}
	?>
</div>