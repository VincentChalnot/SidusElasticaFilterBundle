<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Sidus\ElasticaFilterBundle\DependencyInjection\Compiler;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Inject FOSElastica registries in a dedicated registry
 */
class ElasticaFinderRegistryCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        $registryDefinition = $container->getDefinition('sidus.elastica.registry.finder');
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isAbstract()) {
                continue;
            }
            if (is_a($definition->getClass(), PaginatedFinderInterface::class, true)) {
                $registryDefinition->addMethodCall('addFinder', [$id, $definition]);
            }
        }
    }
}
