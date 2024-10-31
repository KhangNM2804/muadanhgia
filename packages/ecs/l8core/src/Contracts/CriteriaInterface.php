<?php

namespace Ecs\L8Core\Contracts;

use Ecs\L8Core\Contracts\RepositoryInterface;

interface CriteriaInterface
{
    /**
     * Apply the criteria
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Ecs\L8Core\Contracts\RepositoryInterface $repository
     * @return void
     */
    public function apply($model, RepositoryInterface $repository);
}
