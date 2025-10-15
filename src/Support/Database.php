<?php
namespace App\Support;

use PDO;

class Database
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function pdo(): PDO
	{
		return $this->pdo;
	}

	public function query(string $sql, array $params = []): \PDOStatement
	{
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt;
	}

	public function fetchOne(string $sql, array $params = []): ?array
	{
		$stmt = $this->query($sql, $params);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result === false ? null : $result;
	}

	public function fetchAll(string $sql, array $params = []): array
	{
		$stmt = $this->query($sql, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>

