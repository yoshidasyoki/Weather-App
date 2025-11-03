<?php

class Weather extends DatabaseModel
{
    public function getData(string $location, string $start, string $end, array $searches): array
    {
        $searchLists = $this->getSearchLists();

        // SQLインジェクション攻撃防止のためホワイトリストチェックを実施
        foreach ($searches as $search) {
            if (!in_array($search, $searchLists)) {
                throw new AttackDetectException();
            }
        }

        // クエリパラメータの組立てを行う
        $searchIntoSql = '';
        foreach ($searches as $search) {
            $searchIntoSql = $searchIntoSql . $search . ', ';
        }
        $searchIntoSql = substr($searchIntoSql, 0, -2);

        $sql = <<<EOT
        SELECT date, $searchIntoSql FROM weather
        WHERE date BETWEEN :start AND :end
        AND location = :location
        EOT;

        $bindValueParams = [
            ['placeholder' => ':location', 'value' => $location, 'type' => PDO::PARAM_INT],
            ['placeholder' => ':start', 'value' => $start],
            ['placeholder' => ':end', 'value' => $end]
        ];

        $responseData = $this->fetchData($sql, $bindValueParams, 'all');
        if (empty($responseData)) {
            throw new InvalidArgumentException();
        }

        return $responseData;
    }

    public function getSearchLists(): array
    {
        $sql = <<<EOT
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = 'test_database'
            AND TABLE_NAME = 'weather'
            ORDER BY ORDINAL_POSITION;
        EOT;

        $columns = $this->fetchData($sql, [], 'all', PDO::FETCH_COLUMN);
        $searchLists = array_diff($columns, ['id', 'date']);
        $searchLists = array_values($searchLists);
        return $searchLists;
    }

    public function getLatestDate(): string
    {
        $sql = <<<EOT
            SELECT date FROM weather
            WHERE id = (
                SELECT MAX(id) FROM weather
            )
        EOT;

        $result = $this->fetchData($sql, [], 'one');
        return $result['date'];
    }

    public function getCityName(int $location): string
    {
        $sql = <<<EOT
            SELECT city_name FROM location
            WHERE id = :location
        EOT;

        return $this->fetchData($sql, [
            ['placeholder' => ':location', 'value' => $location, 'type' => PDO::PARAM_INT]
        ], 'column');
    }
}
