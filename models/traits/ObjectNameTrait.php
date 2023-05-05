<?php

namespace app\models\traits;

use app\models\events\Call;
use app\models\events\Customer;
use app\models\events\Fax;
use app\models\events\Sms;
use app\models\events\Task;
use app\models\events\User;

trait ObjectNameTrait
{
    public static $classes = [
        Customer::class,
        Sms::class,
        Task::class,
        Call::class,
        Fax::class,
        User::class,
    ];

    /**
     * @param $name
     * @param bool $throwException
     * @return mixed
     */
    public function getRelation($name, $throwException = true)
    {
        $getter = 'get' . $name;
        $class = self::getClassNameByRelation($name);

        if (!method_exists($this, $getter) && $class) {
            return $this->hasOne($class, ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }

    /**
     * @param $className
     * @return mixed
     */
    private static function getObjectByTableClassName($className)
    {
        if (method_exists($className, 'tableName')) {
            return str_replace(['{', '}', '%'], '', $className::tableName());
        }

        return $className;
    }

    /**
     * @param $relation
     * @return string|null
     */
    private static function getClassNameByRelation($relation)
    {
        foreach (self::$classes as $class) {
            if (self::getObjectByTableClassName($class) == $relation) {
                return $class;
            }
        }
        return null;
    }
}