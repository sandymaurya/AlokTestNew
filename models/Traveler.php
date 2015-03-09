<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "traveler".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $Address
 * @property string $DoB
 * @property string $Email
 * @property integer $TravelerType
 * @property integer $PersonCount
 * @property string $PersonNames
 *
 * @property Order[] $orders
 * @property Travelertype $travelerType
 */
class Traveler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traveler';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Address', 'DoB', 'Email', 'TravelerType', 'PersonCount'], 'required'],
            [['DoB'], 'safe'],
            [['TravelerType', 'PersonCount'], 'integer'],
            [['Name', 'Email'], 'string', 'max' => 500],
            [['Address', 'PersonNames'], 'string', 'max' => 2000]
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
            'Address' => 'Address',
            'DoB' => 'Do B',
            'Email' => 'Email',
            'TravelerType' => 'Traveler Type',
            'PersonCount' => 'Person Count',
            'PersonNames' => 'Person Names',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['TravelerId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelerType()
    {
        return $this->hasOne(Travelertype::className(), ['Id' => 'TravelerType']);
    }
}
