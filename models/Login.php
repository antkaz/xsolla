<?php

namespace app\models;

use yii\base\Model;
use app\models\User;

class Login extends Model
{

    public $username;
    public $password;

    /**
     *
     * @var User
     */
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 
     * @return User|null
     */
    public function auth()
    {
        if ($this->validate()) {
            $this->_user->generateToken();
            return $this->_user;
        } else {
            return null;
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Find user by username
     * 
     * @return User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

}
