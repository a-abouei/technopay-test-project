<?php

namespace App\Services\FilterService\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class OrderStatusFilter implements FilterInterface
{

    /**
     * @inheritDoc
     *
     * apply status on order filtering
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('orders.status', $value);
    }
}
