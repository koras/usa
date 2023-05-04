<?php 
 
Yii::$container->set(
    \app\services\interfaces\search\HistorySearchInterface::class,
    \app\services\search\HistorySearch::class
);