<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle\Filter\Type;

use Elastica\Query\Match;

/**
 * Looks for an exact match
 */
class ExactFilterType extends TextFilterType
{
    /**
     * @param string $attributePath
     * @param mixed  $data
     *
     * @return \Elastica\Param
     */
    protected function createQuery($attributePath, $data)
    {
        return new Match($attributePath, $data);
    }
}
