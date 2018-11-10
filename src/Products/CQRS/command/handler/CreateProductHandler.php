<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 10/11/2018
 * Time: 10:05
 */

namespace App\Products\CQRS\command\handler;

use App\CQRS\command\HandlerInterface;
use App\Products\Entity\Product;

/**
 * Class CreateProductHandler
 * @package App\CQRS\command
 * @author Borys Pawluczuk
 */
class CreateProductHandler implements HandlerInterface
{
    /**
     * @var CommandBus $commandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param CreateProductCommand $command
     */
    function handle($command)
    {
        $product = new Product($command->getName());
    }
}