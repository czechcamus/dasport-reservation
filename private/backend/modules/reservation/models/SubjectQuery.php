<?php

namespace backend\modules\reservation\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Subject]].
 *
 * @see Subject
 */
class SubjectQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Subject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
