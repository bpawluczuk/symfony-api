<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 10/11/2018
 * Time: 10:02
 */

namespace App\CQRS\command;

/**
 * Interface HandlerInterface
 * @package App\Products\CQRS\command
 * @author Borys Pawluczuk
 */
interface HandlerInterface
{
    function handle($command);
}