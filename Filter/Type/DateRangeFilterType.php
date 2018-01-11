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

namespace Sidus\ElasticaFilterBundle\Filter\Type;

use Elastica\Query\AbstractQuery;
use Elastica\Query\Range;
use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Form\Type\DateRangeType;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Replaces the standard DateRangeFilterType
 */
class DateRangeFilterType extends AbstractElasticaFilterType
{
    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function handleForm(QueryHandlerInterface $queryHandler, FilterInterface $filter, FormInterface $form)
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }
        $data = $form->getData();
        if (null === $data || !\is_array($data)) {
            return;
        }

        $params = $this->buildParams($data);
        if (0 === \count($params)) {
            return;
        }

        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            $terms[] = new Range($attributePath, $params);
        }

        $this->handleTerms($queryHandler, $terms);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function buildParams(array $data)
    {
        $startDate = $data[DateRangeType::START_NAME] ?? null;
        $endDate = $data[DateRangeType::END_NAME] ?? null;
        $params = [];
        if ($startDate instanceof \DateTimeInterface) {
            $params['gte'] = $startDate->format(\DateTime::ISO8601);
        }
        if ($endDate instanceof \DateTimeInterface) {
            $params['lte'] = $endDate->format(\DateTime::ISO8601);
        }

        return $params;
    }
}
