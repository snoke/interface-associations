<?php
namespace Snoke\InterfaceAssociations\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {

        $treeBuilder = new TreeBuilder('snoke_interface_associations');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('remap')
            ->arrayPrototype()
            ->children()
            ->scalarNode('source')->isRequired()->end()
            ->scalarNode('target')->isRequired()->end()
            ->scalarNode('class')->defaultNull()->end()  // Optionale Klasse
            ->scalarNode('field')->defaultNull()->end()  // Optionale Eigenschaft
            ->end()
            ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;

        return $treeBuilder;

        return $treeBuilder;
    }
}
