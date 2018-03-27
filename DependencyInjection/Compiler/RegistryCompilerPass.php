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

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Generic compiler pass to inject services matching a class in a dedicated registry
 */
class RegistryCompilerPass implements CompilerPassInterface
{
    /** @var string */
    protected $registry;

    /** @var string */
    protected $interface;

    /** @var string */
    protected $method;

    /**
     * @param string $registry
     * @param string $interface
     * @param string $method
     */
    public function __construct(string $registry, string $interface, string $method)
    {
        $this->registry = $registry;
        $this->interface = $interface;
        $this->method = $method;
    }

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
        $registryDefinition = $container->getDefinition($this->registry);
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isAbstract()) {
                continue;
            }
            if (is_a($definition->getClass(), $this->interface, true)) {
                $registryDefinition->addMethodCall($this->method, [$id, $definition]);
            }
        }
    }
}
