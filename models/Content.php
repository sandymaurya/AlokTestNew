<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $Id
 * @property integer $TourId
 * @property integer $PositionId
 * @property integer $ContentTypeId
 * @property string $Value
 * @property integer $IsActive
 *
 * @property Tour $tour
 * @property Position $position
 * @property Contenttype $contentType
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TourId', 'PositionId', 'ContentTypeId', 'Value', 'IsActive'], 'required'],
            [['TourId', 'PositionId', 'ContentTypeId', 'IsActive'], 'integer'],
            [['Value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'TourId' => 'Tour ID',
            'PositionId' => 'Position ID',
            'ContentTypeId' => 'Content Type ID',
            'Value' => 'Value',
            'IsActive' => 'Is Active',
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
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['Id' => 'PositionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentType()
    {
        return $this->hasOne(Contenttype::className(), ['Id' => 'ContentTypeId']);
    }
}
