<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 10/11/2018
 * Time: 10:07
 */

namespace App\CQRS\command;

/**
 * Interface CommandBusInterface
 * @package App\CQRS\command
 * @author Borys Pawluczuk
 */
interface CommandBusInterface
{
    /**
     * @param string $commandClass
     * @param HandlerInterface $handler
     * @return mixed
     */
    function registerHandler(string $commandClass, HandlerInterface $handler);

    /**
     * @param $command
     * @return mixed
     */
    function handle($command);
}