<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paymentstatustype".
 *
 * @property integer $Id
 * @property string $Type
 */
class PaymentStatusType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paymentstatustype';
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
}
