<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_hospitial".
 *
 * @property string $id
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $mobile
 * @property string $name
 * @property string $desc
 * @property string $img
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Hospitial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_hospital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['province'], 'string', 'max' => 8],
            [['city', 'district'], 'string', 'max' => 16],
            [['address', 'mobile', 'name', 'desc', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => 'Province',
            'city' => 'City',
            'district' => 'District',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'desc' => 'Desc',
            'img' => 'Img',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
