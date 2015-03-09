<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orderstatustype".
 *
 * @property integer $Id
 * @property string $Type
 *
 * @property Order[] $orders
 */
class OrderStatusType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orderstatustype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Type'], 'required'],
            [['Type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['Status' => 'Id']);
    }
}
