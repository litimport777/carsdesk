<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SearchAdvancedForm extends Model
{
    public $make;
    public $model;
    public $zip;

    public $body;
    public $color;
    public $transmission;
    public $engine;

    public $price_from;
    public $price_to;

    public $meliage_from;
    public $meliage_to;

    public $year_from;
    public $year_to;


    //

    private $body_data = [
        0 => 'STANDARD CAB',
        1 => 'CREW CAB',
    ];

    private $color_data = [
        0 => 'ANY',
        1 => 'BEIGE',
        2 => 'BLACK',
        3 => 'BLUE',
        4 => 'BRONZE',
        5 => 'BROWN',
        6 => 'GOLD',
        7 => 'GRAY',
        8 => 'GREEN',
        9 => 'ORANGE',
        10 => 'PINK',
        11 => 'PURPLE',
        12 => 'RED',
        13 => 'SILVER',
        14 => 'TURQUOISE',
        15 => 'WHITE',
        16 => 'YELLOW',
    ];


    private $transmission_data = [
        0 => 'AUTOMATIC',
        1 => 'MANUAL',
    ];


    private $engine_data = [
        0 => 'DIESEL',
        1 => 'GAS',
        2 => 'FLEX FUEL',
        3 => 'PROPANE',
        4 => 'HYBRID',
        5 => 'ETHANOL',
    ];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['make', 'required'],
            [['make', 'model', 'zip'], 'string']
            [['price_from', 'price_to', 'meliage_from', 'meliage_to', 'year_from', 'year_to'], 'number']
         ];
    }

  
}
