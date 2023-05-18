<?php

namespace app\models\events;

use Yii;
use app\models\repositories\Call as CallActiveRecord;

/**
 * This is the model class for table "{{%call}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $direction
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $phone_from
 * @property string $phone_to
 * @property string $comment
 *
 * -- magic properties
 * @property string $statusText
 * @property string $directionText
 * @property string $totalStatusText
 * @property string $totalDisposition
 * @property string $durationText
 * @property string $fullDirectionText
 * @property string $client_phone
 *
 * @property Customer $customer
 * @property User $user
 */
class Call extends CallActiveRecord
{
    const STATUS_NO_ANSWERED = 0;
    const STATUS_ANSWERED = 1;

    const DIRECTION_INCOMING = 0;
    const DIRECTION_OUTGOING = 1;

    public $duration = 720;


    /**
     * @return string
     */
    public function getClient_phone()
    {
        return $this->direction == self::DIRECTION_INCOMING ? $this->phone_from : $this->phone_to;
    }

    /**
     * @return mixed|string
     */
    public function getTotalStatusText()
    {
        if (
            $this->status == self::STATUS_NO_ANSWERED
            && $this->direction == self::DIRECTION_INCOMING
        ) {
            return Yii::t('app', 'Missed Call');
        }

        if (
            $this->status == self::STATUS_NO_ANSWERED
            && $this->direction == self::DIRECTION_OUTGOING
        ) {
            return Yii::t('app', 'Client No Answer');
        }

        $msg = $this->getFullDirectionText();

        if ($this->duration) {
            $msg .= ' (' . $this->getDurationText() . ')';
        }

        return $msg;
    }

    /**
     * @param bool $hasComment
     * @return string
     */
    public function getTotalDisposition($hasComment = true)
    {
        $t = [];
        if ($hasComment && $this->comment) {
            $t[] = $this->comment;
        }
        return implode(': ', $t);
    }

    /**
     * @return array
     */
    public static function getFullDirectionTexts()
    {
        return [
            self::DIRECTION_INCOMING => Yii::t('app', 'Incoming Call'),
            self::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing Call'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getFullDirectionText()
    {
        return self::getFullDirectionTexts()[$this->direction] ?? $this->direction;
    }

    /**
     * @return string
     */
    public function getDurationText()
    {
        if (!is_null($this->duration)) {
            return $this->duration >= 3600 ? gmdate("H:i:s", $this->duration) : gmdate("i:s", $this->duration);
        }
        return '00:00';
    }
}
