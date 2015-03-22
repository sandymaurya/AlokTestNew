<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourhotel".
 *
 * @property integer $TourId
 * @property integer $HotelId
 *
 * @property Tour $tour
 * @property Hotel $hotel
 */
class TourHotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourhotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TourId', 'HotelId'], 'required'],
            [['TourId', 'HotelId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TourId' => 'Tour ID',
            'HotelId' => 'Hotel ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['Id' => 'TourId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['Id' => 'HotelId']);
    }
}
