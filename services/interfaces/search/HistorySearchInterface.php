<?php

namespace app\services\interfaces\search;


interface HistorySearchInterface
{
    /**
     * Search
     * @param array $params
     * @return mixed
     */
    public function search(array $params);
}