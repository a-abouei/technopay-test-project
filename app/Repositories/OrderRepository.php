<?php

namespace App\Repositories;

use App\Dtos\GetOrdersDto;
use App\Http\Requests\IndexOrdersRequest;
use App\Models\Order;
use App\DomainModels\Order as OrderDomainModel;
use App\Services\FilterService\OrderFilterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;

class OrderRepository
{

    /**
     * @var array
     */
    private array $filters;

    public function __construct()
    {
        $this->filters = app('filter.classes');
    }


    /**
     * @param IndexOrdersRequest $request
     * @return Collection<OrderDomainModel>
     */
    public function getOrdersList(IndexOrdersRequest $request): Collection
    {
        $orders = Order::query();

        foreach ($this->filters as $key => $filter) {
            if ($request->has($key)) {
                $filterInstance = new $filter;
                $orders = $filterInstance->apply($orders, $request->input($key));
            }
        }

        return  $orders->get()->map(function ($orders) {
            return new OrderDomainModel($orders->toArray());
        });
    }

}
