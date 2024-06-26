<?php

namespace App\Services\FilterService\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CustomerMobileNumberFilter implements FilterInterface
{

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->join('customers as customer1', 'orders.customer_id', '=', 'customer1.id')
            ->where('customer1.mobile_number', $value);
    }
}
