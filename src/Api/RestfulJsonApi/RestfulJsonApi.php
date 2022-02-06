<?php
namespace App\Api\RestfulJsonApi;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;

use \Ratchet\WebSocket\WsConnection;
use App\Api\RestfulJsonApi\CommandCollection;
use App\Api\RestfulJsonApi\RestCommandRequest;
use App\Api\JsonApi\Worker\CallbackResponder as Responder;
//use App\Api\JsonApi\Worker\BroadcastResponder as Responder;

use App\Api\JsonApi\JsonApi;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;

/**
 * this api extends jsonapi and provides restful commands.
 */
class RestfulJsonApi extends JsonApi {

    private array $workers;
    private CommandCollection $commands;

    public function __construct(
        CommandCollection $commands,
        Responder $responder,
        EntityCollection $entities,
    ) {
        parent::__construct($commands,$responder);
    }

    public function onMessage(ConnectionInterface $from,  $json) {
        $this->io->block($msg, 'USER REQUEST', 'fg=blue', ' ', true);
        $request = new RestCommandRequest($from,$json);
        $command = $this->commands->find($request->getAction());
        $response = $this->execute($command,new ArrayInput($request->getParams()));
        foreach($this->workers as $worker) {
            $worker->onMessage($from,$command,$response);
        }
        $this->io->block($response, 'API RESPONSE', 'fg=green', ' ', true);
    }
}