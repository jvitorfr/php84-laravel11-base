<?php
namespace Domain\Contracts;


use Domain\Responses\DomainResponse;

interface UseCaseInterface {
    /**
     * @param mixed ...$params The parameters needed for execution.
     * @return DomainResponse
     */
    public function execute(...$params): DomainResponse;
}
