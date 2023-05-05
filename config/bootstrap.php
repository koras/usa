<?php


Yii::$container->set(
    \app\services\interfaces\search\HistorySearchInterface::class,
    \app\services\search\HistorySearch::class
);

Yii::$container->set(
    app\models\interfaces\HistoryInterface::class,
    app\models\History::class
);


