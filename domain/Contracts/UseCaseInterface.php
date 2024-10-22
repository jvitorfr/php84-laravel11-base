<?php

namespace Domain\Contracts;

use Domain\DomainResponse;

/**
 * @template TParams
 */
interface UseCaseInterface
{
    /**
     * Execute the use case with specified parameters.
     *
     * @param mixed $params The parameters needed for execution.
     * @return DomainResponse
     */
    public function execute(mixed $params): DomainResponse;
}
