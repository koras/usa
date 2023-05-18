<?php

namespace app\models\events;

use Yii;
use app\models\repositories\Task as TaskActiveRecord;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $title
 * @property string $text
 * @property string $due_date
 * @property integer $priority
 * @property string $ins_ts
 *
 * @property string $stateText
 * @property string $state
 * @property string $subTitle
 *
 * @property boolean $isOverdue
 * @property boolean $isDone
 *
 * @property Customer $customer
 * @property User $user
 *
 *
 * @property string $isInbox
 * @property string $statusText
 */
class Task extends TaskActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_DONE = 1;
    const STATUS_CANCEL = 3;

    const STATE_INBOX = 'inbox';
    const STATE_DONE = 'done';
    const STATE_FUTURE = 'future';


    /**
     * @return array
     */
    public static function getStatusTexts()
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_DONE => Yii::t('app', 'Complete'),
            self::STATUS_CANCEL => Yii::t('app', 'Cancel'),
        ];
    }

    /**
     * @param $value
     * @return int|mixed
     */
    public function getStatusTextByValue($value)
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getStatusText()
    {
        return self::getStatusTextByValue($this->status);
    }

    /**
     * @return array
     */
    public static function getStateTexts()
    {
        return [
            self::STATE_INBOX => Yii::t('app', 'Inbox'),
            self::STATE_DONE => Yii::t('app', 'Done'),
            self::STATE_FUTURE => Yii::t('app', 'Future')
        ];
    }

    /**
     * @return mixed
     */
    public function getStateText()
    {
        return self::getStateTexts()[$this->state] ?? $this->state;
    }


    /**
     * @return bool
     */
    public function getIsOverdue()
    {
        return $this->status !== self::STATUS_DONE && strtotime($this->due_date) < time();
    }

    /**
     * @return bool
     */
    public function getIsDone()
    {
        return $this->status == self::STATUS_DONE;
    }
}
