<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $Id
 * @property integer $OrderId
 * @property integer $CardDetailId
 * @property string $Date
 * @property string $PaidAmount
 * @property integer $Status
 *
 * @property Order[] $orders
 * @property Order $order
 * @property Carddetail $cardDetail
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CardDetailId', 'Date', 'PaidAmount', 'Status'], 'required'],
            [['CardDetailId', 'Status'], 'integer'],
            [['Date'], 'safe'],
            [['PaidAmount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'CardDetailId' => 'Card Detail ID',
            'Date' => 'Date',
            'PaidAmount' => 'Paid Amount',
            'Status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['PaymentId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardDetail()
    {
        return $this->hasOne(Carddetail::className(), ['Id' => 'CardDetailId']);
    }
}
