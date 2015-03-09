<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travelertype".
 *
 * @property integer $Id
 * @property string $Type
 *
 * @property Traveler[] $travelers
 */
class TravelerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travelertype';
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
    public function getTravelers()
    {
        return $this->hasMany(Traveler::className(), ['TravelerType' => 'Id']);
    }
}
