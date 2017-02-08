<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * Signup form
 */
class AccauntForm extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['username', 'email'], 'required'],
            //[['status', 'created_at', 'updated_at'], 'integer'],
            //[['username', 'email'], 'string', 'max' => 255],
            //[['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            //[['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCars()
    {
        return $this->hasMany(UserCar::className(), ['user_id' => 'id']);
    }

    public function getAccauntSaveData($user_id)
    {
        return Yii::$app->db->createCommand("SELECT *, CONCAT_WS('-',
                                                       'used',
                                                        year,
                                                        LOWER(REPLACE(REPLACE(REPLACE(make, ' ', ''), '.', ''), '-', '')),
                                                        LOWER(REPLACE(REPLACE(REPLACE(model, ' ', ''), '.', ''), '-', '')),
                                                        vin
                                                    ) AS alias FROM {{user_car}} 
                                            INNER JOIN {{tbl_lots_temp}} 
                                            ON `user_car`.`tbl_lots_temp_id` = `tbl_lots_temp`.`id`
                                            WHERE `user_car`.`user_id` = :user_id", [':user_id'=>$user_id])->queryAll();
    }

    public function setSaveData($auto)
    {
        $userId = Yii::$app->user->id;
        $autoId = $auto;
        $resultSelect = Yii::$app->db->createCommand("SELECT id FROM {{user_car}} WHERE user_id= :user_id AND tbl_lots_temp_id= :tbl_lots_temp_id LIMIT 1",
            [':user_id'=> $userId,':tbl_lots_temp_id'=>$autoId])->queryScalar();

        if(!$resultSelect){
            $result = Yii::$app->db->createCommand()->insert('user_car', ['user_id'=> $userId,'tbl_lots_temp_id'=>$autoId])->execute();
        } else {
            $result = 1;
        }
        
        return $result;
    }

    public function deleteData($auto)
    {
        $userId = Yii::$app->user->id;
        $autoId = $auto;

        $result = Yii::$app->db->createCommand()->delete('user_car', ['user_id'=> $userId,'tbl_lots_temp_id'=> $autoId])->execute();

        return $result;
    }
   
}
