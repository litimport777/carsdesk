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

    

    private $meliage_data = [
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
        ];


    private $year_data = [
                2018,
                2017,
                2016,
                2015,
                2014,
                2013,
                2012,
                2011,
                2010,
                2009,
                2008,
                2007,
                2006,
                2005,
                2004,
                2003,
                2002,
                2001,
                2000,
                1999,
                1998,
                1997,
                1996,
                1995,
                1994,
                1993,
                1992,
                1991,
                1990,
                1989,
                1988,
                1987,
                1986,
                1985,
                1984,
                1983,
                1982,
                1981,
                1980,
                1979,
                1978,
                1977,
                1976,
                1975,
                1974,
                1973,
                1972,
                1971,
                1970,
                1969,
                1968,
                1967,
                1966,
                1965,
                1964,
                1963,
                1962,
                1961,
                1960,
            ];

    
    private $price_data = [
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
           80000 => '80000',
           85000 => '$85000',
           90000 => '$90000',
           95000 => '$95000',
           100000 => '$100000',
           9999999999 => 'nomax',
    ];


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
            [['price_from','price_to','meliage_from','meliage_to','year_from','year_to','body','color','transmission','engine'], 'number']
            [['body'], 'in', 'range' => [0, 1]],
            [['color'], 'in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]],
            [['transmission'], 'in', 'range' => [0, 1]],
            [['engine'], 'in', 'range' => [0, 1, 2, 3, 4, 5]],

            ['price_from', 'compare', 'compareAttribute' => 'price_to', 'operator' => '<=', 'type' => 'number'],
            ['meliage_from', 'compare', 'compareAttribute' => 'meliage_to', 'operator' => '<=', 'type' => 'number'],
            ['year_from', 'compare', 'compareAttribute' => 'year_to', 'operator' => '<=', 'type' => 'number'],
         ];
    }

  
}
