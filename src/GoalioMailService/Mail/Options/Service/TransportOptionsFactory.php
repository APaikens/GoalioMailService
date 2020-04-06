<?php
namespace GoalioMailService\Mail\Options\Service;

use GoalioMailService\Mail\Options\TransportOptions;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\FactoryInterface;

class TransportOptionsFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Config');
        return new TransportOptions(isset($config['goaliomailservice']) ? $config['goaliomailservice'] : array());
    }

}