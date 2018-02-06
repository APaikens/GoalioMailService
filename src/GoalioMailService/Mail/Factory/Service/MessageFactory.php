<?php

namespace GoalioMailService\Mail\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;
use GoalioMailService\Mail\Service\Message;

/**
 * Description of UserControllerFactory
 *
 * @author prautmanis
 */
class MessageFactory implements FactoryInterface{
        
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $controller = new Message(
                $container->get('goaliomailservice_transport'),
                $container->get('goaliomailservice_renderer')
                );

        return $controller;
    }
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        return $this->__invoke($serviceLocator,null);
    }
}
