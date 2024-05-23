<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = resolve(OrderRepository::class);
    }

    public function testThereIsNotAnyOrderExistsAndRespondSuccessfully(): void
    {
        $response = $this->getJson(route('orders.index'));

        $response->assertOk();
        $response->assertJson([
            'message' => 'list of orders found successfully',
            'data' => []
            ]
        );
    }

    public function testFetchOrderDataWithoutFilter(): void
    {
        Order::factory()->count(5)->create();

        $response = $this->getJson(route('orders.index'));

        $response->assertOk();

        $this->assertCount(5, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );
        $this->assertArrayHasKey('order_id', $response->json('data.0'));
        $this->assertArrayHasKey('customer_id', $response->json('data.0'));
        $this->assertArrayHasKey('status', $response->json('data.0'));
        $this->assertArrayHasKey('amount', $response->json('data.0'));
    }


    public function testGetOrdersWithStatusFilter(): void
    {
        Order::factory()->count(3)
            ->state([
                'status' => OrderStatus::SUCCEED->value
            ])->create();
        Order::factory()->count(5)
            ->state([
                'status' => OrderStatus::IN_PROGRESS->value
            ])->create();
        Order::factory()->count(4)
            ->state([
                'status' => OrderStatus::FAILED->value
            ])->create();


        $response = $this->getJson(route('orders.index', ['order_status' => OrderStatus::SUCCEED->value]));

        $response->assertOk();

        $this->assertCount(3, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

    public function testGetOrdersWithMinAmountFilterWhenFilterIsNotFixCompatibleWithOrderAmount(): void
    {
        Order::factory()->count(2)
            ->state([
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', ['order_min_amount' => 40000]));

        $response->assertOk();

        $this->assertCount(9, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

    public function testGetOrdersWithMinAmountFilterWhenFilterIsFixCompatibleWithOrderAmount(): void
    {
        Order::factory()->count(2)
            ->state([
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', ['order_min_amount' => 38000]));

        $response->assertOk();

        $this->assertCount(12, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

    public function testGetOrdersWithMaxAmountFilterWhenFilterIsNotFixCompatibleWithOrderAmount(): void
    {
        Order::factory()->count(2)
            ->state([
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', ['order_max_amount' => 40000]));

        $response->assertOk();

        $this->assertCount(5, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

    public function testGetOrdersWithMaxAmountFilterWhenFilterIsFixCompatibleWithOrderAmount(): void
    {
        Order::factory()->count(2)
            ->state([
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', ['order_max_amount' => 46000]));

        $response->assertOk();

        $this->assertCount(10, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

    public function testGetOrdersWithMinAndMaxAmountFilterWhenUseAtThemSameTime(): void
    {
        Order::factory()->count(2)
            ->state([
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', [
            'order_min_amount' => 26000,
            'order_max_amount' => 50000
        ]));

        $response->assertOk();

        $this->assertCount(8, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }


    public function testGetOrdersWithCustomerNationalCodeFilterRespondSuccessfully(): void
    {
        $desireCustomer = Customer::factory()->count(5)->create()->first();

        Order::factory()->count(6)
            ->state([
                'customer_id' => 1,
                'amount' => 25000
            ])->create();
        Order::factory()->count(3)
            ->state([
                'customer_id' => 2,
                'amount' => 38000
            ])->create();
        Order::factory()->count(4)
            ->state([
                'customer_id' => 3,
                'amount' => 92000
            ])->create();
        Order::factory()->count(5)
            ->state([
                'customer_id' => 4,
                'amount' => 46000
            ])->create();
        Order::factory()->count(2)
            ->state([
                'customer_id' => 5,
                'amount' => 46000
            ])->create();


        $response = $this->getJson(route('orders.index', [
            'customer_national_code' => $desireCustomer->national_code,
        ]));

        $response->assertOk();

        $this->assertCount(6, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );
        $response->assertJsonFragment([
            'customer_id' => $desireCustomer->id
        ]);

    }

    public function testGetOrdersWithCustomerMobileNumberFilterRespondSuccessfully(): void
    {
        Customer::factory()->count(5)->create()->first();

        Order::factory()->count(6)
            ->state([
                'customer_id' => 1,
                'amount' => 25000
            ])->create();

        Order::factory()->count(3)
            ->state([
                'customer_id' => 2,
                'amount' => 38000
            ])->create();

        Order::factory()->count(4)
            ->state([
                'customer_id' => 3,
                'amount' => 92000
            ])->create();

        Order::factory()->count(5)
            ->state([
                'customer_id' => 4,
                'amount' => 46000
            ])->create();

        Order::factory()->count(2)
            ->state([
                'customer_id' => 5,
                'amount' => 46000
            ])->create();

        $customer = Customer::query()->find(5);

        $response = $this->getJson(route('orders.index', [
            'customer_mobile_number' => $customer->mobile_number,
        ]));

        $response->assertOk();

        $this->assertCount(2, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );
        $response->assertJsonFragment([
            'customer_id' => $customer->id
        ]);

    }


    public function testGetOrdersWithCustomerMobileNumberAndNationalCodeFilterTogetherBaseOnSameCustomerRespondSuccessfully(): void
    {
        Customer::factory()->count(5)->create()->first();

        Order::factory()->count(6)
            ->state([
                'customer_id' => 1,
                'amount' => 25000
            ])->create();

        Order::factory()->count(3)
            ->state([
                'customer_id' => 2,
                'amount' => 38000
            ])->create();

        Order::factory()->count(4)
            ->state([
                'customer_id' => 3,
                'amount' => 92000
            ])->create();

        Order::factory()->count(5)
            ->state([
                'customer_id' => 4,
                'amount' => 46000
            ])->create();

        Order::factory()->count(2)
            ->state([
                'customer_id' => 5,
                'amount' => 46000
            ])->create();

        $customer = Customer::query()->find(5);

        $response = $this->getJson(route('orders.index', [
            'customer_national_code' => $customer->national_code,
            'customer_mobile_number' => $customer->mobile_number,
        ]));

        $response->assertOk();

        $this->assertCount(2, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );
        $response->assertJsonFragment([
            'customer_id' => $customer->id
        ]);

    }


    public function testGetOrdersWithCustomerMobileNumberAndNationalCodeFilterTogetherBaseOnDifferentCustomersRespondSuccessfully(): void
    {
        Customer::factory()->count(5)->create()->first();

        Order::factory()->count(6)
            ->state([
                'customer_id' => 1,
                'amount' => 25000
            ])->create();

        Order::factory()->count(3)
            ->state([
                'customer_id' => 2,
                'amount' => 38000
            ])->create();

        Order::factory()->count(4)
            ->state([
                'customer_id' => 3,
                'amount' => 92000
            ])->create();

        Order::factory()->count(5)
            ->state([
                'customer_id' => 4,
                'amount' => 46000
            ])->create();

        Order::factory()->count(2)
            ->state([
                'customer_id' => 5,
                'amount' => 46000
            ])->create();

        $customer = Customer::query()->find(5);
        $customer2 = Customer::query()->find(1);

        $response = $this->getJson(route('orders.index', [
            'customer_national_code' => $customer->national_code,
            'customer_mobile_number' => $customer2->mobile_number,
        ]));

        $response->assertOk();

        $this->assertCount(0, $response->json('data'));
        $response->assertJson([
                'message' => 'list of orders found successfully',
                'data' => []
            ]
        );

    }

}
