<?php

namespace Tests\Unit\Repositories;

use App\Http\Requests\IndexOrdersRequest;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;
use App\DomainModels\Order as OrderDomainModel;

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
        Order::factory()->count(10)->create();

        $orders = $this->orderRepository->getOrdersList(new IndexOrdersRequest());

        $this->assertNotEmpty($orders);
        $this->assertEquals(10, $orders->count());
        $this->assertInstanceOf(Collection::class, $orders);
        $this->assertInstanceOf(OrderDomainModel::class, $orders->first());
    }
}
