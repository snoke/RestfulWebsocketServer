<?php
namespace App\Api\RestfulJsonApi;
namespace App\Api\JsonApi\JsonCommandRequest;
class RestCommandRequest extends JsonCommandRequest {
    private $client;
    private $method;
    private $entity;
    private $id;
    private $data;
    public function __construct($client,$action) {
        $this->client = $client;
        $data = explode(' ',$action); 
        $method = $action[0];
        $entity = $action[1];
        $id = $action[2];
        $data = $action[3];
    }   
    public function getAction() {
        return $this->method;
    }
    public function getParams() {
        return [
            'entity' => $this->$entity,
            'id' => $this->$id,
            'data' => $this->$data,
        ];
    }
}