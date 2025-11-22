<?php

namespace App\Core;

use \PDO;

class DatabaseModel
{
    public function __construct(protected PDO $dbh) {}

    protected function fetchData(string $sql, array $params = [], string $fetchType = '', int $fetchMode = PDO::FETCH_ASSOC)
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $param) {
            (isset($param['type']))
                ? $stmt->bindValue($param['placeholder'], $param['value'], $param['type'])
                : $stmt->bindValue($param['placeholder'], $param['value']);
        }

        $stmt->execute();

        switch ($fetchType) {
            case 'one':
                return $stmt->fetch($fetchMode);
            case 'all':
            default:
                return $stmt->fetchAll($fetchMode);
        }
    }

    protected function executeQuery(string $sql, array $params = []): bool
    {
        $stmt = $this->dbh->prepare($sql);
        foreach ($params as $param) {
            (isset($param['type']))
                ? $stmt->bindValue($param['placeholder'], $param['value'], $param['type'])
                : $stmt->bindValue($param['placeholder'], $param['value']);
        }

        return $stmt->execute();
    }
}
