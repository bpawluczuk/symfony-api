<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 10/11/2018
 * Time: 10:03
 */

namespace App\CQRS\command;

/**
 * Class CommandBus
 * @package App\CQRS\command
 * @author Borys Pawluczuk
 */
final class CommandBus implements CommandBusInterface
{
    /**
     * @var HandlerInterface[] $handlers
     */
    private $handlers = [];

    /**
     * @param string $commandClass
     * @param HandlerInterface $handler
     * @return mixed
     */
    function registerHandler(string $commandClass, HandlerInterface $handler)
    {
        $this->handlers[$commandClass]=$handler;
    }

    /**
     * @param $command
     * @return mixed
     */
    function handle($command)
    {
        $this->handlers[get_class($command)]->handle($command);
    }
}