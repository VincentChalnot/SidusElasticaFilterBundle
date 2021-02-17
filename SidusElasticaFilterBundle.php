<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2021 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle;

use Elastica\SearchableInterface;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sidus\ElasticaFilterBundle\DependencyInjection\Compiler\RegistryCompilerPass;
use Sidus\ElasticaFilterBundle\Registry\ElasticaFinderRegistry;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sidus\ElasticaFilterBundle\Registry\ElasticaSearchableRegistry;

/**
 * Class SidusElasticaFilterBundle
 *
 * @package Sidus\ElasticaFilterBundle
 */
class SidusElasticaFilterBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new RegistryCompilerPass(
                ElasticaFinderRegistry::class,
                PaginatedFinderInterface::class,
                'addFinder'
            ),
            PassConfig::TYPE_OPTIMIZE
        );
        $container->addCompilerPass(
            new RegistryCompilerPass(
                ElasticaSearchableRegistry::class,
                SearchableInterface::class,
                'addSearchable'
            ),
            PassConfig::TYPE_OPTIMIZE
        );
    }
}
