<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property string $name
 * @property string $data
 * @property string $img
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'data', 'img'], 'required'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 1028],
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
            'data' => 'Data',
            'img' => 'Img',
        ];
    }
}
