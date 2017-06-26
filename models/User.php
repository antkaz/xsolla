<?php

namespace app\models;

use Yii;
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

    public function fields()
    {
        return ['username', 'access_token'];
    }

    /**
     * Find user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generate a new token for the user
     * 
     * @throws Exception
     */
    public function generateToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
        if (!$this->save(false)) {
            throw new Exception('Could not save token');
        }
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
