<?php
namespace Alsar\MonologExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('alsar_monolog_extensions');

        $rootNode
            ->children()
                ->arrayNode('processors')
                    ->children()
                        ->arrayNode('request')
                            ->children()
                                ->booleanNode('enabled')->defaultFalse()->end()
                                ->scalarNode('handler')->defaultNull()->end()
                            ->end()
                        ->end()
                        ->arrayNode('browscap')
                            ->children()
                                ->booleanNode('enabled')->defaultFalse()->end()
                                ->scalarNode('handler')->defaultNull()->end()
                                ->scalarNode('cache_dir')->isRequired()->end()
                            ->end()
                        ->end()
                        ->arrayNode('user')
                            ->children()
                                ->booleanNode('enabled')->defaultFalse()->end()
                                ->scalarNode('handler')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
