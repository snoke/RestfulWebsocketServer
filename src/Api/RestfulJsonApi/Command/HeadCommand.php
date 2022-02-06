<?php

namespace App\Api\RestfulJsonApi\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Mapping\ClassMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;


use Doctrine\Common\Annotations\AnnotationReader;

use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use App\Entity\User;
use App\Api\RestfulJsonApi\RestfulCommand as Base;
#[AsCommand(
    name: 'rest:head',
    description: 'Add a short description for your command',
)]
class HeadCommand extends Base
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $class = $this->entities->getEntity($input->getArgument('entity'));
        $meta = $this->em->getMetadataFactory()->getAllMetadata();
        foreach($meta as $m) {
            if ($m->getTableName()==strtolower($input->getArgument('entity'))) {
                $output->write(json_encode($m));
                return Command::SUCCESS;
            }
        }
        return Command::FAILURE;
    }
}
