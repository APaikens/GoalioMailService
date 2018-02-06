<?php
namespace GoalioMailService\Mail\Transport\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Interop\Container\ContainerInterface;

class TransportFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        /** @var TransportOptions $options */
        $config = $container->get('config');
        $options = $config['goaliomailservice'];

        // Backwards compatibility with old config files
        if(isset($options['transport_class']) && !isset($options['type'])) {
            $options['type'] = $options['transport_class'];
        }

        if(isset($options['transport_options']) && !isset($options['options'])) {
            $options['options'] = $options['transport_options'];
        }

        return \Zend\Mail\Transport\Factory::create($options);
    }

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return $this->__invoke($serviceLocator,null);
    }
}
