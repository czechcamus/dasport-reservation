<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 9:06
 */

namespace backend\models;


use common\models\Subject;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SubjectSearch extends Subject {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'name', 'email', 'phone' ], 'safe' ]
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
	 *
	 * @param $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search( $params ) {
		$query = parent::find();

		if ( ! isset( $params['sort'] ) ) {
			$query->orderBy( [ 'name' => SORT_ASC ] );
		}

		$dataProvider = new ActiveDataProvider( [
			'query' => $query,
		] );

		$this->load( $params );

		if ( ! $this->validate() ) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere( [ 'like', 'name', $this->name ] );
		$query->andFilterWhere( [ 'like', 'email', $this->email ] );
		$query->andFilterWhere( [ 'like', 'phone', $this->phone ] );

		return $dataProvider;
	}

}