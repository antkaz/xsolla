<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\User;

/**
 * @property int $file_id
 * @property int $user_id
 * @property string $name
 */
class File extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%file}}';
    }
    
    public function rules()
    {
        return [
            [['user_id', 'filename'], 'required'],
            [['user_id'], 'exist', 'targetClass' => User::classname()],
        ];
    }
    
    public function fields() {
        return ['filename'];
    }

}
