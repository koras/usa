<?php

namespace app\models\events;

use Yii;
use app\models\repositories\User  as UserActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $statusText
 */
class User extends UserActiveRecord
{


    /**
     * @return array
     */
    public static function getStatusTexts()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
            self::STATUS_HIDDEN => Yii::t('app', 'Hidden'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return self::getStatusTexts()[$this->status] ?? $this->status;
    }
}
