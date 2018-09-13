<?php

namespace App\Authentication\EventListener;

use App\Authentication\TokenManager;
use App\Authentication\Token;
use App\Tools\Util\ApiResponseObjects;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TokenAuthenticationListener
 * @package App\Authentication\EventListener
 * @author Borys Pawluczuk
 */
class TokenAuthenticationListener
{
    use ApiResponseObjects;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * GameListener constructor.
     * @param ContainerInterface $container
     * @param Reader $annotationReader
     */
    public function __construct(ContainerInterface $container, Reader $annotationReader)
    {
        $this->container = $container;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws \ReflectionException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller) or !isset($controller[0])) {
            return;
        }

        $class = get_class($controller[0]);

        $annotationClass = 'App\Authentication\Annotation\TokenAuthentication';
        $class = new ReflectionClass($class);
        $method = $class->getMethod($controller[1]);
        /**
         * @var Consumes $annotation
         */
        $annotation = $this->annotationReader->getClassAnnotation($class, $annotationClass);

        if (!$annotation) {
            $annotation = $this->annotationReader->getMethodAnnotation($method, $annotationClass);
            if (!$annotation) {
                return;
            }
        }

        $token = Token::instance($event->getRequest())->getToken();
        $tokenManager = new TokenManager($this->container);

        if (!$tokenManager->checkTokenIsValid($token)) {
            $event->setController(
                function () {
                    return $this->getForbiddenErrorResponse('This action needs a valid access token!');
                }
            );
        }
    }
}