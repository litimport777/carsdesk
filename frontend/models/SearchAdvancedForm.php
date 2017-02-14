<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use frontend\models\Search;
use yii\db\Query;

/**
 * Signup form
 */
class SearchAdvancedForm extends Search
{
    
    const CURRENT_FROM_YEAR = 10;

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



    protected static $meliage_data = [
               0 => 0,
               10000 => 10000,
               20000 => 20000,
               30000 => 30000,
               40000 => 40000,
               50000 => 50000,
               60000 => 60000,
               70000 => 70000,
               80000 => 80000,
               90000 => 90000,
               100000 => 100000,
               200000 => 200000,
               300000 => 300000,
               400000 => 400000,
               500000 => 500000,
               1000000 => 1000000,
            ];


    protected static $year_data = [];
           
       
    protected static $price_data = [ 
                  0 => '$0',
               1000 => '$1000',
               2000 => '$2000',
               3000 => '$3000',
               4000 => '$4000',
               5000 => '$5000',
               6000 => '$6000',
               7000 => '$7000',
               8000 => '$8000',
               9000 => '$9000',
               10000 =>'$10000',
               11000 => '$11000',
               12000 => '$12000',
               13000 => '$13000',
               14000 => '$14000',
               15000 => '$15000',
               16000 => '$16000',
               17000 => '$17000',
               18000 => '$18000',
               19000 => '$19000',
               20000 => '$20000',
               21000 => '$21000',
               22000 => '$22000',
               23000 => '$23000',
               24000 => '$24000',
               25000 => '$25000',
               30000 => '$30000',
               35000 => '$35000',
               40000 => '$40000',
               45000 => '$45000',
               50000 => '$50000',
               55000 => '$55000',
               60000 => '$60000',
               65000 => '$65000',
               70000 => '$70000',
               75000 => '$75000',
               80000 => '$80000',
               85000 => '$85000',
               90000 => '$90000',
               95000 => '$95000',
               100000 => '$100000',
               9999999999 => 'nomax',
    ];


    //

    protected static $body_data = [
        0 => 'ANY',
        1 => 'STANDARD CAB',
        2 => 'CREW CAB',
    ];

    protected static $color_data = [
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


    protected static $transmission_data = [
            0 => 'ANY',
            1 => 'AUTOMATIC',
            2 => 'MANUAL',
    ];


    protected static $engine_data = [
            0 => 'ANY',
            1 => 'DIESEL',
            2 => 'GAS',
            3 => 'FLEX FUEL',
            4 => 'PROPANE',
            5 => 'HYBRID',
            6 => 'ETHANOL',
    ];


    public function init()
    {
        parent::init();
        static::createYearArray();        
    }

    private static function createYearArray()
    {
        $currentYear = date('Y');
        $lastYear = 1960;
        for($i = $currentYear; $i >= $lastYear; $i--){
            static::$year_data[] = $i;
        }

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['make', 'required'],
            [['make', 'model', 'zip'], 'string'],
            [['price_from','price_to','meliage_from','meliage_to','year_from','year_to','body','color','transmission','engine'], 'number'],
            [['body'], 'in', 'range' => [0, 1, 2]],
            [['color'], 'in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]],
            [['transmission'], 'in', 'range' => [0, 1, 2]],
            [['engine'], 'in', 'range' => [0, 1, 2, 3, 4, 5, 6]],

            ['price_from', 'compare', 'compareAttribute' => 'price_to', 'operator' => '<=', 'type' => 'number'],
            ['meliage_from', 'compare', 'compareAttribute' => 'meliage_to', 'operator' => '<=', 'type' => 'number'],
            ['year_from', 'compare', 'compareAttribute' => 'year_to', 'operator' => '>=', 'type' => 'number'],

             [['model', 'zip'], 'default', 'value'=>null],

            [
                ['model','zip','body','color','transmission','engine','price_from','price_to','meliage_from','meliage_to','year_from','year_to'],
                'filter','filter'=> function($value){
                    if ($value == '0')
                        return null;
                    else return $value;
                }
            ],
         ];
    }

    public static function getBodyData()
    {
        return self::$body_data;
    }

    public static function getColorData()
    {
        return self::$color_data;
    }

    public static function getTransmissionData()
    {
        return self::$transmission_data;
    }

    public static function getEngineData()
    {
        return self::$engine_data;
    }

    public static function getMeliageData()
    {
        return self::$meliage_data;
    }

   
    public static function getYearData()
    {
        if (!in_array(date('Y'), self::$year_data))
            array_unshift(self::$year_data, date('Y'));
        return self::$year_data;
    }

    public static function getPriceFromData()
    {
        unset(self::$price_data[9999999999]);
        return self::$price_data;
    }

    public static function getPriceToData()
    {
        self::$price_data[9999999999] = 'nomax';
        return self::$price_data;
    }


}
