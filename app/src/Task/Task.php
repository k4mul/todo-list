<?php
namespace ToDo\Task;

class Task
{
    private $id;
    private $name;
    private $date;
    private $done;
    
    // pobranie id
    public function getId()
    {
        return $this->id;
    }
    
    // ustawienie oraz walidacja nazwy
    public function setName($name)
    {
        if (strlen($name) < 3)
            return $this->name = null;
            
        $this->name = htmlspecialchars($name, ENT_QUOTES);
    }
    
    // pobranie nazwy
    public function getName()
    {
        return $this->name;
    }
    
    // ustawienie oraz walidacja daty
    public function setDate($date)
    {
        if (!is_int($date))
            return $this->date = null;
        
        $this->date = $date;
    }
    
    // pobranie daty
    public function getDate()
    {
        return $this->date;
    }
    
    // pobranie statusu taska
    public function getDone()
    {
        return $this->done;        
    }
    
    // ustawienie statusu taska
    public function setDone($done)
    {
        $this->done = $done;
    }
    
    // czy obiekt jest w poprawnym stanie?
    public function isValid()
    {
        return $this->name && $this->date;
    }
}