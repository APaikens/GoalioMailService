<?php

namespace GoalioMailService\Mail\View;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;
use Interop\Container\ContainerInterface;

class MailPhpRendererFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $renderer = new PhpRenderer();

        $helperManager = $container->get('ViewHelperManager');
        $resolver      = $container->get('ViewResolver');

        $renderer->setHelperPluginManager($helperManager);
        $renderer->setResolver($resolver);

        $application = $container->get('Application');
        $event       = $application->getMvcEvent();

        if($event !== null) {
            $model = $container->get('Application')->getMvcEvent()->getViewModel();

            $modelHelper = $renderer->plugin('view_model');
            $modelHelper->setRoot($model);
        }

        return $renderer;
    }

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return $this->__invoke($serviceLocator,null);
    }
}
