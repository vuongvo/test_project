<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required','message' => '{attribute} is required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'file','extensions' => 'png,jpg,jpeg']
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
            'description' => 'Description',
            'image' => 'image'
        ];
    }
     
}
   