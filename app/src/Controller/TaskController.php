<?php
namespace ToDo\Controller;

use PDO;
use DateTime;
use ToDo\Service\TaskService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TaskController
{
    private $service;
    
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }
    
    // get /index
    public function index(Request $request, Response $response)
    {
        $body = $response->getBody();
        $html = file_get_contents(__DIR__.'/../../../public/index.html');
        
        $body->write($html);
        
        return $response->withBody($body);
    }
    
    // post /create
    public function create(Request $request, Response $response)
    {
        $name = $request->getParam('name');
        $date = new DateTime;
        $result = $this->service->create($name, $date->getTimestamp());
          
        return $response->withJson($result);
    }
    
    // post /update/{id}
    public function update(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $name = $request->getParam('name');
        $date = new DateTime;
        $result = $this->service->update($id, $name, $date);
        
        return $response->withJson($result);
    }
    
    
    // get /all
    public function all(Request $request, Response $response, $args)
    {
        $result = $this->service->findAll();
        
        return $response->withJson($result);
    }
    
    // get /task/{id}
    public function one(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $result = $this->service->findOne($id);
        
        return $response->withJson($result);
    }
    
    // get /change-status/{id}
    public function changeStatus(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $result = $this->service->changeStatus($id);
        
        return $response->withJson($result);
    }
    
    // get /delete/{id}
    public function delete(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $result = $this->service->delete($id);
            
        return $response->withJson($result);
    }
}
