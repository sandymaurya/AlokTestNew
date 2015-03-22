<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tour".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $Url
 * @property string $Price
 *
 * @property Content[] $contents
 * @property Tourhotel[] $tourhotels
 * @property Hotel[] $hotels
 */
class Tour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Url', 'Price'], 'required'],
            [['Price'], 'number'],
            [['Name'], 'string', 'max' => 500],
            [['Url'], 'string', 'max' => 2048]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Url' => 'Url',
            'Price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['TourId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourhotels()
    {
        return $this->hasMany(Tourhotel::className(), ['TourId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotels()
    {
        return $this->hasMany(Hotel::className(), ['Id' => 'HotelId'])->viaTable('tourhotel', ['TourId' => 'Id']);
    }
}
