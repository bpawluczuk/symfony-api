<?php
/**
 * Created by PhpStorm.
 * User: bpawluczuk
 * Date: 25.08.2018
 * Time: 12:09
 */

namespace App\Tools\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ManagerAbstract
 * @package App\Tools\Util
 * @author Borys Pawluczuk
 */
abstract class ManagerAbstract
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * ManagerAbstract constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

    protected function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

    /**
     * @return RequestStack
     */
    protected function getRequestStack(): RequestStack
    {
        return $this->get('request_stack');
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        /**
         * @var $requestStack RequestStack
         */
        $requestStack = $this->getRequestStack();

        /**
         * @var $request Request
         */
        $request = $requestStack->getCurrentRequest();

        return $request;
    }

    /**
     * @return string
     */
    protected function getLocale(): string
    {
        return $this->getRequest()->getLocale();
    }

    /**
     * @return EntityManager
     */
    protected function getManager(): EntityManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return Translator
     */
    protected function getTranslator(): Translator
    {
        return $this->get('translator');
    }
}