<?php
namespace Alsar\MonologExtensionsBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AlsarMonologExtensionsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('processors.xml');

        if (isset($config['processors'])) {
            foreach ($config['processors'] as $name => $data) {
                if ($data['enabled'] == true) {
                    if ($name == 'request') {
                        $this->buildRequestProcessor($container, $data);
                    } else if ($name == 'browscap') {
                        $this->buildBrowscapProcessor($container, $data);
                    } else if ($name == 'user') {
                        $this->buildUserProcessor($container, $data);
                    }
                }
            }
        }
    }

    protected function buildRequestProcessor(ContainerBuilder $container, array $data)
    {
        $tagAttributes = ['method' => 'processRecord'];

        if ($data['handler'] !== null) {
            $tagAttributes['handler'] = $data['handler'];
        }

        $container->getDefinition('alsar_monolog_extensions.monolog.processor.request')
                  ->setPublic(true)
                  ->addTag('monolog.processor', $tagAttributes);
    }

    protected function buildBrowscapProcessor(ContainerBuilder $container, array $data)
    {
        $browscapDefinition = new Definition('phpbrowscap\Browscap');
        $browscapDefinition->setArguments([$data['cache_dir']]);

        $tagAttributes = ['method' => 'processRecord'];

        if ($data['handler'] !== null) {
            $tagAttributes['handler'] = $data['handler'];
        }

        $container->getDefinition('alsar_monolog_extensions.monolog.processor.browscap')
                  ->setPublic(true)
                  ->addArgument($browscapDefinition)
                  ->addTag('monolog.processor', $tagAttributes);
    }

    protected function buildUserProcessor(ContainerBuilder $container, array $data)
    {
        $tagAttributes = ['method' => 'processRecord'];

        if ($data['handler'] !== null) {
            $tagAttributes['handler'] = $data['handler'];
        }

        $container->getDefinition('alsar_monolog_extensions.monolog.processor.user')
                  ->setPublic(true)
                  ->addTag('monolog.processor', $tagAttributes);
    }
}
