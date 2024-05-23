<?php

namespace App\Http\Controllers;

use App\Dtos\GetOrdersDto;
use App\Exceptions\Responder;
use App\Http\Requests\IndexOrdersRequest;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Throwable;

class OrderController extends Controller
{

    /**
     * @param OrderService $orderService
     */
    public function __construct(private readonly OrderService $orderService)
    {}


    /**
     * @param IndexOrdersRequest $request
     * @return JsonResponse
     */
    public function index(IndexOrdersRequest $request): JsonResponse
    {
        try {
            $orders = $this->orderService->getOrdersList($request);

            return Responder::success(
                message: 'list of orders found successfully',
                data: $orders
            );

        } catch (Throwable $th) {
            report($th);

            return Responder::failure();
        }
    }
}
