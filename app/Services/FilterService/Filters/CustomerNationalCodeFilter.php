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
        return $builder->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('customers.national_code', $value);
    }
}
