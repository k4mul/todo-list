<?php
namespace ToDo\Service;

use ToDo\Task\Task;
use ToDo\Task\TaskRepository;

class TaskService
{
    private $repository;
    
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }
    
    // wyszukanie wszystkich tasków
    public function findAll()
    {
        $tasks = [];
        
        $result = $this->repository->findAll();

        foreach($result as $task) {
            $tasks[] = [
                'id' => $task->getId(),
                'name' => $task->getName(),
                'date' => $task->getDate(),
                'done' => $task->getDone()
            ];
        }
        
        return $tasks;
    }
    
    // wyszukanie jednego konkretnego taska
    public function findOne($id)
    {
        $result = $this->repository->find($id);
        
        if (!$result)
            return $this->error();
        
        $task = [
            'id' => $result->getId(),
            'name' => $result->getName(),
            'date' => $result->getDate(),
            'done' => $result->getDone()
        ];
        
        return $task;
    }
    
    // usunięcie danego taska
    public function delete($id)
    {
        $result = $this->repository->delete($id);
        
        if (!$result)
            return $this->error();
        
        return $this->success();
    }
    
    // utworzenie nowego taska
    public function create($name, $date)
    {
        $task = new Task;
        $task->setName($name);
        $task->setDate($date);
        
        if (!$task->isValid())
            return $this->error();
        
        $result = $this->repository->save($task);
            
        if (!$result)
            return $this->error();
            
        return $this->success();
    }
    
    // aktualizacja istniejącego taska
    public function update($id, $name, $date)
    {
        $task = $this->repository->find($id);
        
        if (!$task)
            return $this->error();
        
        $task->setName($name);
        $task->setDate($date);
        
        if (!$task->isValid())
            return $this->error();
            
        $result = $this->repository->save($task);
        
        if (!$result)
            return $this->error();
            
        return $this->success();
    }
    
    // zmiana statusu taska
    public function changeStatus($id)
    {
        $task = $this->repository->find($id);
        
        if (!$task)
            return $this->error();
            
        if ($task->getDone())
            $task->setDone(0);
        else 
            $task->setDone(1);
        
        $result = $this->repository->save($task);
        
        if (!$result)
            return $this->error();
        
        return $this->success();
    }
    
    // sukces
    private function success()
    {
        return [
            'success' => true    
        ];
    }
    
    // błąd
    private function error()
    {
        return [
            'error' => true    
        ];
    }
}