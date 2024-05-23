<?php

namespace App\Services;


use App\Http\Requests\IndexOrdersRequest;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }


    /**
     * @param IndexOrdersRequest $request
     * @return array
     */
    public function getOrdersList(IndexOrdersRequest $request): array
    {
        $orders = $this->orderRepository->getOrdersList($request);

        $data = [];

        foreach ($orders as $order) {
            $data[] = [
                'order_id' => $order->orderId,
                'customer_id' => $order->customerId,
                'status' => $order->status,
                'amount' => $order->amount
            ];
        }

        return $data;
    }

}
