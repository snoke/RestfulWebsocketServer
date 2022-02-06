<?php
namespace App\Api\RestfulJsonApi;
use Doctrine\ORM\EntityManagerInterface;

class EntityCollection {
    private $entities = [
    ];
    public function add(string $shortname,$fqcn) {
        return $this->entities[$shortname] = $fqcn;
    }
    public function getEntity(string $className):string {
        return $this->entities[strtolower($className)];
    }
    public function __construct(EntityManagerInterface $em) {
        $entities = array();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        foreach ($meta as $m) {
            $this->add(strtolower($m->getTableName()),$m->getName());
        }
    }
}