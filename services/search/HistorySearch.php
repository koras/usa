<?php

namespace app\services\search;

use app\models\interfaces\HistoryInterface;
use yii\data\ActiveDataProvider;
use app\services\interfaces\search\HistorySearchInterface;
/**
 * HistorySearch represents the model behind the search form about `app\models\History`.
 *
 */
class HistorySearch implements HistorySearchInterface
{

    private $history;

    public function __construct(HistoryInterface $history)
    {
        $this->history = $history;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $this->history->load($params);

        $query = $this->history->find();
        // add conditions that should always apply here

        $query->addSelect('history.*');
        $query->with([
            'customer',
            'user',
            'sms',
            'task',
            'call',
            'fax',
        ]);

        return  new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ins_ts' => SORT_DESC,
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }
}
