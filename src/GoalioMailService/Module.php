<?php
namespace GoalioMailService;

use Laminas\Mvc\MvcEvent;
use Laminas\Loader\StandardAutoloader;
use Laminas\Loader\AutoloaderFactory;

class Module {

    public function getAutoloaderConfig() {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'shared' => array(
                'goaliomailservice_message'   => false
            ),
            'invokables' => array(
                
            ),
            'factories' => array(
                'goaliomailservice_options'   => 'GoalioMailService\Mail\Options\Service\TransportOptionsFactory',
                'goaliomailservice_transport' => 'GoalioMailService\Mail\Transport\Service\TransportFactory',
                'goaliomailservice_renderer'  => 'GoalioMailService\Mail\View\MailPhpRendererFactory',
                'goaliomailservice_message'   => 'GoalioMailService\Mail\Factory\Service\MessageFactory',
            ),
        );
    }
}

