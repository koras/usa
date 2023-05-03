<?php

namespace app\controllers;

use app\services\interfaces\search\HistorySearchInterface;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * @var HistorySearchInterface - business logic
     */
    private $historySearch;

    public function __construct(
        $id,
        $module,
        HistorySearchInterface $historySearch,
        $config = []
    ) {
        $this->historySearch = $historySearch;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @param string $exportType
     * @return string
     */
    public function actionExport($exportType)
    {
      //  $model = new HistorySearch();

        return $this->render('export', [
            'dataProvider' => $this->historySearch->search(Yii::$app->request->queryParams),
            'exportType' => $exportType,
            'model' => $this->historySearch
        ]);
    }
}
