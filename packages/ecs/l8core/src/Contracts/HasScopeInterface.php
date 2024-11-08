<?php

namespace Ecs\L8Core\Contracts;

interface HasScopeInterface
{
    /**
     * Add custom scope to handler
     *
     * @param \Closure $scope
     * @return self
     */
    public function scopeQuery(\Closure $scope);

    /**
     * Reset handler scope
     *
     * @return self
     */
    public function resetScope();
}
