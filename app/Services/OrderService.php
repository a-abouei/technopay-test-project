<?php

namespace App\Services;


use App\Http\Requests\IndexOrdersRequest;
use App\Repositories\OrderRepository;
use App\Services\NotificationService\Notification;
use Throwable;

class OrderService
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }


    /**
     * @param IndexOrdersRequest $request
     * @return array
     * @throws Throwable
     */
    public function getOrdersList(IndexOrdersRequest $request): array
    {
        try {
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
        catch (Throwable $th){
            Notification::sms()->messageByTemplate('filter_order')->send();
            Notification::email()->messageByTemplate('filter_order')->send();

            throw $th;
        }
    }

}
