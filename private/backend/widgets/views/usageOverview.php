<?php
/* @var $this yii\web\View */
/* @var $periodModel \backend\models\PeriodForm */
/* @var $device \common\models\Device */

use common\models\Day;
use common\models\Plan;
use common\models\Usage;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>

<div class="row">
	<?php
	$device = $periodModel->device;
	for ( $i = Yii::$app->formatter->asTimestamp( $periodModel->firstDate ); $i <= Yii::$app->formatter->asTimestamp( $periodModel->lastDate ); $i += 86400 ) {
		if ( $plan = Plan::find()->where( [ 'device_id' => $device->id ] )->andWhere( [
			'<=',
			'date_from',
			date( 'Y-m-d', $i )
		] )->andWhere( [ '>=', 'date_to', date( 'Y-m-d', $i ) ] )->one()
		) {
			if ( $day = Day::find()->where( [ 'plan_id' => $plan->id ] )->andWhere( [
				'day_nr' => date( 'N', $i )
			] )->one()
			) {
				if ( $day->is_open == 1 ) {
					echo '<div class="col-xs-6 col-md-4 col-lg-3"><table class="table table-bordered table-striped table-condensed">';
					echo '<tr><th colspan="3">' . $day->getDayName() . ' ' . date( 'd.m.Y', $i ) . '</th></tr>';
					for (
						$j = strtotime( date( 'Y-m-d',
								$i ) . ' ' . $plan->time_from ), $k = 1; $j < strtotime( date( 'Y-m-d',
							$i ) . ' ' . $plan->time_to ); $j += $plan->hour_length * 60
					) {
						if ( date( 'H:i', $j ) >= date( 'H:i', strtotime( $day->time_from ) ) && date( 'H:i',
								$j ) < date( 'H:i', strtotime( $day->time_to ) )
						) {
							$usage = Usage::find()->where( [ 'device_id' => $device->id ] )->andWhere( [
								'date' => date( 'Y-m-d', $i )
							] )->andWhere( [ 'hour_nr' => $k ] )->one();
							echo '<tr' . ($usage ? ' class="used"' : '') .  '>';
							echo '<td style="width: 3em;">' . date( 'H:i', $j ) . '</td>';
							echo '<td>' . ( $usage ? Html::tag('span',StringHelper::truncate($usage->subject->name, 12), [
									'data' => [
										'toggle' => 'tooltip',
										'placement' => 'top',
										'html' => true,
										'title' => $usage->subject->name . '<br />' . $usage->subject->email . '<br />' . $usage->subject->phone
									]
								]) : '&nbsp;' ) . '</td>';
							echo '<td style="text-align: center; width: 4em;">';
							if ( $usage ) {
								echo Html::a( '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', [
									'/usage/update',
									'plan_id'   => $plan->id,
									'id' => $usage->id
								], [
									'title' => Yii::t( 'back', 'Update usage' ),
									'class' => 'btn btn-link',
									'style' => 'padding: 0;'
								] );
								echo Html::a( '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', [
									'/usage/delete',
									'plan_id'   => $plan->id,
									'id' => $usage->id
								], [
									'title' => Yii::t( 'back', 'Delete usage' ),
									'class' => 'btn btn-link',
									'style' => 'padding: 0;',
				                    'data-confirm' => Yii::t('back', 'Are you sure you want to delete this item?'),
				                    'data-method' => 'post',
				                    'data-pjax' => '0'
								] );
							} else {
								echo Html::a( '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', [
									'/usage/create',
									'plan_id'   => $plan->id,
									'date'      => date( 'Y-m-d', $i ),
									'hour_nr'   => $k
								], [
									'title' => Yii::t( 'back', 'Add usage' ),
									'class' => 'btn btn-link',
									'style' => 'padding: 0;'
								] );
							}
							echo '</td>';
							echo '</tr>';
						} else {
							echo '<tr><td colspan="3" style="text-align: center;"><span class="glyphicon glyphicon-minus btn" aria-hidden="true" style="padding: 0; cursor: default;"></span></td></tr>';
						}
						++ $k;
					}
					echo '</table></div>';
				}
			}
		}
	}
	?>
</div>