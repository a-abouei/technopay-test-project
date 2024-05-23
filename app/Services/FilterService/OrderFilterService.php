<?php

namespace App\Services\FilterService;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderFilterService
{
    /**
     * @var array
     */
    protected array $filters;

    public function __construct()
    {
        $this->filters = app('filter.classes');
    }

    /**
     * apply filters on order query result
     *
     * @param Request $request
     * @return Builder
     */
    public function apply(Request $request): Builder
    {
        $query = Order::query();

        foreach ($this->filters as $key => $filter) {
            if ($request->has($key)) {
                $filterInstance = new $filter;
                $query = $filterInstance->apply($query, $request->input($key));
            }
        }

        return $query;
    }

}
