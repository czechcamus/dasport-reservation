<?php

namespace backend\modules\reservation\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Device]].
 *
 * @see Device
 */
class DeviceQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Device[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Device|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
