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
use Elastica\Query\AbstractQuery;
use Elastica\Query\Wildcard;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Replaces the standard TextFilterType
 */
class TextFilterType extends AbstractElasticaFilterType
{
    /**
     * {@inheritdoc}
     *
     * @throws \Elastica\Exception\InvalidException
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function handleForm(QueryHandlerInterface $queryHandler, FilterInterface $filter, FormInterface $form)
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }
        $data = $form->getData();
        if (null === $data) {
            return;
        }

        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            $terms[] = new Wildcard($attributePath, '*'.$data.'*');
        }

        $this->handleTerms($queryHandler, $terms);
    }
}
