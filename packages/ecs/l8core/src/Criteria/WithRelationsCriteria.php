<?php

namespace Ecs\L8Core\Criteria;

use Ecs\L8Core\Contracts\CriteriaInterface;
use Ecs\L8Core\Contracts\RepositoryInterface;

/**
 * Class WithRelationsCriteriaCriteria.
 *
 * @package Ecs\L8Core\Criteria;
 */
class WithRelationsCriteria implements CriteriaInterface
{
    /**
     * List of request relations from query string
     *
     * @var array
     */
    protected $input;

    /**
     * List of allow relations
     *
     * @var array
     */
    protected $allows;

    /**
     * An constructor of WithRelationsCriteria
     *
     * @param mixed $input
     * @param array $allows
     */
    public function __construct($input = '', $allows = [])
    {
        $this->input = array_filter(
            array_map(
                '\Illuminate\Support\Str::camel',
                is_array($input) ? $input : explode(',', $input)
            )
        );

        $this->allows = $allows;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Ecs\L8Core\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $withs = [];

        foreach ($this->allows as $key => $value) {
            if (! in_array(is_numeric($key) ? $value : $key, $this->input)) {
                continue;
            }

            if (is_array($value)) {
                $withs[$value[0]] = $value[1] ?? function () {
                    //
                };
                continue;
            }

            $withs[$key] = $value;
        }

        return empty($withs) ? $model : $model->with($withs);
    }
}
