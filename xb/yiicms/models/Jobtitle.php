<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ww_jobtitle".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Jobtitle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ww_jobtitle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
