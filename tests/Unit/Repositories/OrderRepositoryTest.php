<?php

namespace Tests\Unit\Repositories;

use App\Http\Requests\IndexOrdersRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Tests\TestCase;

class OrderRepositoryTest  extends TestCase
{

    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = resolve(OrderRepository::class);
    }

    public function testGetOrdersWhenThereIsNotAnyOrder(): void
    {
        $orders = $this->orderRepository->getOrdersList(new IndexOrdersRequest());

        $this->assertEmpty($orders);
    }


    public function testGetOrdersWhenThereAreSomeOrders(): void
    {
        $orders = Order::factory()->count(10)->create();

        $this->assertEquals(10, $orders->count());
    }
}
