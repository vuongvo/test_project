<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cate_post".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property integer $post_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class CatePost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cate_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'post_id', 'created_at', 'updated_at'], 'required'],
            [['cate_id', 'post_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => 'Cate ID',
            'post_id' => 'Post ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
