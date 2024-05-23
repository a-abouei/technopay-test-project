<?php

namespace App\Services\FilterService\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class OrderMinAmountFilter implements FilterInterface
{

    /**
     * @inheritDoc
     *
     * apply amount on order filtering
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('orders.amount', '>=',$value);
    }
}
