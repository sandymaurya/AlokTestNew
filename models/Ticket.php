<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $Id
 * @property string $Time
 * @property integer $HotelId
 * @property integer $Quantity
 * @property string $BookingDate
 *
 * @property Order[] $orders
 * @property Hotel $hotel
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Time', 'HotelId', 'Quantity', 'BookingDate'], 'required'],
            [['HotelId', 'Quantity'], 'integer'],
            [['BookingDate'], 'safe'],
            [['Time'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Time' => 'Time',
            'HotelId' => 'Hotel ID',
            'Quantity' => 'Quantity',
            'BookingDate' => 'Booking Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['TicketId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['Id' => 'HotelId']);
    }
}
