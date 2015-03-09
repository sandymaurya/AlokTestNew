<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $Id
 * @property integer $TicketId
 * @property integer $TravelerId
 * @property integer $PaymentId
 * @property integer $Date
 * @property string $SpecialNeed
 * @property string $InitialAmount
 * @property string $DiscountedAmount
 * @property string $PromoCode
 * @property string $FinalAmount
 * @property integer $Status
 *
 * @property Ticket $ticket
 * @property Traveler $traveler
 * @property Payment $payment
 * @property Orderstatustype $status
 * @property Payment[] $payments
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TicketId', 'TravelerId', 'PaymentId', 'Date', 'InitialAmount', 'DiscountedAmount', 'PromoCode', 'FinalAmount', 'Status'], 'required'],
            [['TicketId', 'TravelerId', 'PaymentId', 'Date', 'Status'], 'integer'],
            [['InitialAmount', 'DiscountedAmount', 'PromoCode', 'FinalAmount'], 'number'],
            [['SpecialNeed'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'TicketId' => 'Ticket ID',
            'TravelerId' => 'Traveler ID',
            'PaymentId' => 'Payment ID',
            'Date' => 'Date',
            'SpecialNeed' => 'Special Need',
            'InitialAmount' => 'Initial Amount',
            'DiscountedAmount' => 'Discounted Amount',
            'PromoCode' => 'Promo Code',
            'FinalAmount' => 'Final Amount',
            'Status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['Id' => 'TicketId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraveler()
    {
        return $this->hasOne(Traveler::className(), ['Id' => 'TravelerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['Id' => 'PaymentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Orderstatustype::className(), ['Id' => 'Status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['OrderId' => 'Id']);
    }
}
