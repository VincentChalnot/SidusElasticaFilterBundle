<?php
/*
 *  Sidus/ElasticaFilterBundle : Elastic Search support for Sidus/FilterBundle
 *  Copyright (C) 2015-2018 Vincent Chalnot
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
