<?php
namespace ToDo\Task;

use PDO;

class TaskRepository
{
	private $pdo;
	
	// wstrzyknięcie zależności (PDO)
	public function __construct(PDO $pdo) 
	{
		$this->pdo = $pdo;
	}
	
	// pobranie rekordu po id
	public function find($id)
    {
        return $this->findBy('id', $id);
    }

	// pobranie wszystkich rekordów
    public function findAll()
    {
        $query = "SELECT rowid as id, name, date, done FROM task";
		
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, Task::class);
		return $stmt->fetchAll();
    }

	// pobranie rekordu według konkretnej wartości
	public function findBy($key, $value)
    {
		$query = "SELECT rowid as id, name, date, done FROM task WHERE $key=:$key";
		
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':' . $key, $value);
		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, Task::class);
		return $stmt->fetch();
	}

	// usunięcie rekordu o danym id
    public function delete($id)
    {
		$query = "DELETE FROM task WHERE rowid=:id;";
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
		
		return $stmt->rowCount();
    }

	// zapisanie danego rekordu
    public function save(Task $task)
    {
		if ($task->getId())
			return $this->update($task);
		
		return $this->create($task);
    }
    
    // zapisanie nowego rekordu do bazy
    private function create(Task $task)
    {
		$query = "INSERT INTO task(name, date) VALUES(:name, :date);";
		$stmt = $this->pdo->prepare($query);
		
		$stmt->bindValue(':name', $task->getName());
		$stmt->bindValue(':date', $task->getDate());
		
		$result = $stmt->execute();
		
		if ($result) {
			$id = $this->pdo->lastInsertId();
			$new_task = $this->find($id);
			
			return $new_task;
		}
		
		return null;
	}
	
	// aktualizacja istniejącego rekordu
	private function update(Task $task)
	{
		$query = "UPDATE task SET name=:name, date=:date, done=:done WHERE rowid=:id;";
		$stmt = $this->pdo->prepare($query);
		
		$stmt->bindValue(':id', $task->getId());
		$stmt->bindValue(':name', $task->getName());
		$stmt->bindValue(':date', $task->getDate());
		$stmt->bindValue(':done', $task->getDone());
		
		$result = $stmt->execute();
		
		if ($result) {
			return $task;
		}
		
		return null;
	}
}
