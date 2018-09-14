<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 14.09.2018
 * Time: 16:18
 */

namespace App\Products\CQRS;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Query
 * @package App\Products\CQRS
 * @author Borys Pawluczuk
 */
abstract class Query
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var string $class
     */
    protected $class;

    /**
     * ManagerAbstract constructor.
     * @param ContainerInterface $container
     * @param string $class
     */
    public function __construct(ContainerInterface $container, string $class)
    {
        $this->container = $container;
        $this->class = $class;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param $service
     * @return object The service
     */
    protected function get($service)
    {
        return $this->container->get($service);
    }

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->get('doctrine');
    }

    /**
     * @return mixed
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository($this->getClass());
    }

    /**
     * @return EntityManager
     */
    protected function getManager(): EntityManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

}