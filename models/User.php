<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;

/**
 * @property integer $user_id
 * @property string $username
 * @property string $password_hash
 * @property string $access_token
 * @property string $allowance
 * @property string $allowance_updated_at
 */
class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
    /**
     * Number of requests per second
     *
     * @var integer
     */
    private $rateLimit = 10;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getAuthKey(): string
    {
        return null;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function validateAuthKey($authKey): bool
    {
        return false;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public function getRateLimit($request, $action): array
    {
        return [$this->rateLimit, 1];
    }

    public function loadAllowance($request, $action): array
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save(false);
    }

}
