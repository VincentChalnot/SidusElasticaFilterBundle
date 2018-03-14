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

use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\EAVModelBundle\Registry\FamilyRegistry;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;

/**
 * Autocomplete filter for data
 */
class AutocompleteDataFilterType extends ChoiceFilterType
{
    /** @var FamilyRegistry */
    protected $familyRegistry;

    /**
     * @param FamilyRegistry $familyRegistry
     */
    public function setFamilyRegistry(FamilyRegistry $familyRegistry)
    {
        $this->familyRegistry = $familyRegistry;
    }

    /**
     * {@inheritdoc}
     * @throws \UnexpectedValueException
     */
    public function getFormOptions(QueryHandlerInterface $queryHandler, FilterInterface $filter): array
    {
        if (isset($filter->getFormOptions()['attribute'])) {
            return parent::getFormOptions($queryHandler, $filter);
        }

        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }

        // @todo

        return array_merge(
            $this->formOptions,
            $filter->getFormOptions(),
            [
                'attribute' => reset($eavAttributes),
            ]
        );
    }
}
