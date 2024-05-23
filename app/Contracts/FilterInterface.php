<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{

    /**
     * Apply filter to the query
     *
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder;

}
