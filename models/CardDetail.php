<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carddetail".
 *
 * @property integer $Id
 * @property integer $CardType
 * @property string $CardHolderName
 * @property string $CardNumber
 * @property integer $ExpiryMonth
 * @property integer $ExpiryYear
 * @property integer $CV2Number
 *
 * @property Cardtype $cardType
 * @property Payment[] $payments
 */
class CardDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carddetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CardType', 'CardHolderName', 'CardNumber', 'ExpiryMonth', 'ExpiryYear', 'CV2Number'], 'required'],
            [['CardNumber', 'ExpiryMonth', 'ExpiryYear', 'CV2Number'], 'integer'],
            [['CardHolderName'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'CardType' => 'Card Type',
            'CardHolderName' => 'Card Holder Name',
            'CardNumber' => 'Card Number',
            'ExpiryMonth' => 'Expiry Month',
            'ExpiryYear' => 'Expiry Year',
            'CV2Number' => 'Cv2 Number',
        ];
    }
//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getCardType()
//    {
//        return $this->hasOne(Cardtype::className(), ['Id' => 'CardType']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['CardDetailId' => 'Id']);
    }
}
