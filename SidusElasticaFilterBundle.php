<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle;

use Sidus\ElasticaFilterBundle\DependencyInjection\Compiler\ElasticaFinderRegistryCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

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
        $container->addCompilerPass(new ElasticaFinderRegistryCompilerPass(), PassConfig::TYPE_OPTIMIZE);
    }
}
