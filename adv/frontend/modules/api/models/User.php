<?php
namespace frontend\modules\api\models;

/**
 * {@inheritdoc}
 */
class User extends \common\models\User
{
    public function fields() {
        $fields = parent::fields();

        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token'], $fields['access_token']);

        return $fields;
    }
}