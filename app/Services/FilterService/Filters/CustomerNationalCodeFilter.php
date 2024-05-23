<?php

namespace App\Services\FilterService\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CustomerNationalCodeFilter implements FilterInterface
{

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->join('customers as customer2', 'orders.customer_id', '=', 'customer2.id')
            ->where('customer2.national_code', $value);
    }
}
