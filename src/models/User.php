<?php

namespace app\models;

use bizley\jwt\JwtHttpBearerAuth;
use Lcobucci\JWT\Token\Plain;
use Yii;
use yii\base\NotSupportedException;

class User extends \Da\User\Model\User {

    public static function findIdentityByAccessToken($token, $type = null) {
//        return User::findOne(1);

        if ($type === JwtHttpBearerAuth::class) {
            /** @var Plain $jwtToken */
            $jwtToken = Yii::$app->jwt->getParser()->parse((string)$token);

            $claims = $jwtToken->claims();
            $userClientId = $claims->get('sub');

            $usr = static::find()
                ->whereId($userClientId)
                ->andWhere(['blocked_at' => null])
                ->andWhere(['NOT', ['confirmed_at' => null]])
                ->andWhere(['gdpr_deleted' => 0])
                ->one();

            return $usr;
        }
        throw new NotSupportedException("Type '$type' is not implemented.");
    }

}