<?php

namespace App\DomainModels;

class Order
{

    public readonly int $orderId;
    public readonly int $customerId;

    public readonly string $status;
    public readonly int $amount;


    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->orderId = $data['id'];
        $this->customerId = $data['customer_id'];
        $this->status = $data['status'];
        $this->amount = $data['amount'];
    }

}
