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
    
	const COUNT_COLUMN_NEWS_IN_INDEX_PAGE = 2;
	
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
				$filename = $this->imageFile->baseName . time() . '.' . $this->imageFile->extension;
				$this->imageFile->saveAs('uploads/' . $filename);
				$this->img = $filename;
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
