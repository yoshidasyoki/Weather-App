<?php

class DatabaseModel
{
    public function __construct(protected PDO $dbh)
    {
    }

    protected function fetchData(string $sql, array $params = [], string $fetchType = '', int $fetchMode = PDO::FETCH_ASSOC): array|string
    {
        $stmt = $this->dbh->prepare($sql);

        foreach ($params as $param) {
            (isset($param['type']))
                ? $stmt->bindValue($param['placeholder'], $param['value'], $param['type'])
                : $stmt->bindValue($param['placeholder'], $param['value']);
        }
        $stmt->execute();

        switch ($fetchType) {
            case 'column':
                return $stmt->fetchColumn();
            case 'one':
                return $stmt->fetch();
            case 'all':
            default:
                return $stmt->fetchAll($fetchMode);
        }
    }
}
