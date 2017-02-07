<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use frontend\models\Search;
use yii\db\Query;

/**
 * Signup form
 */
class SearchForm extends Search
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
            [['make', 'model', 'zip'], 'string'],

            [['model', 'zip'], 'default', 'value'=>null],

            [
                ['model','zip'],'filter','filter'=> function($value){
                    if ($value == '0')
                        return null;
                    else return $value;
                }
            ],

         ];
    }

  
}
