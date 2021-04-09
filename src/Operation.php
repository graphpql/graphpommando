<?php

declare(strict_types = 1);

namespace Graphpommando;

interface Operation
{
    public const QUERY = 'query';
    public const MUTATION = 'mutation';
    public const SUBSCRIPTION = 'subscription';

    public function getOperationType() : string;

    public function getVariables() : array;

    public function getDirectives() : array;

    public function getEntityClass() : string;
}
