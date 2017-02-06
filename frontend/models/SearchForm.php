<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SearchForm extends Model
{
    public $make;
    public $model;
    public $zip;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['make', 'required'],
            [['model', 'zip'], 'safe']
         ];
    }

  
}
