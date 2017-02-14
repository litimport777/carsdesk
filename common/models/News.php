<?php

namespace common\models;
use yii\web\UploadedFile;

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
     * @var UploadedFile
     */
    public $imageFile;
	
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
            [['name', 'data'], 'required'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 1028],
			[['imageFile'], 'file', 'skipOnEmpty' => true],
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
            'imageFile' => 'Img',
        ];
    }
		

    public function upload()
    {
 		if ($this->validate()) {
            if($this->imageFile != null){
				$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
				$this->img = $this->imageFile->baseName . time() . '.' . $this->imageFile->extension;
			} else {
				$this->img = '';
			}
            return true;
        } else {
            return false;
        }
    }
	
	public function getNewsToIndexPage()
	{
		return News::find()->orderBy('id DESC')->limit(6)->asArray()->all();
	}
}
