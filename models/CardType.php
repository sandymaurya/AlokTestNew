<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cardtype".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $Type
 *
 * @property Carddetail[] $carddetails
 */
class CardType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cardtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Type'], 'required'],
            [['Name', 'Type'], 'string', 'max' => 20]
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
            'Type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarddetails()
    {
        return $this->hasMany(Carddetail::className(), ['CardType' => 'Id']);
    }
}
