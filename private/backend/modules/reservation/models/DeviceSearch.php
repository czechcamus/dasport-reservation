<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 9:45
 */

namespace backend\modules\reservation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class DeviceSearch extends Device
{
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title', 'text_id'], 'safe']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 * @param $params
	 * @return ActiveDataProvider
	 */
	public function search( $params ) {
		$query = parent::find();

		if (!isset($params['sort']))
			$query->orderBy(['title' => SORT_ASC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'title', $this->title]);
		$query->andFilterWhere(['like', 'text_id', $this->text_id]);

		return $dataProvider;
	}

}