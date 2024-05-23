<?php

namespace App\Dtos;

class GetOrdersDto extends BaseDto
{

    public readonly ?string $customerNationalCode;
    public readonly ?string $customerMobileNumber;
    public readonly ?string $orderStatus;
    public readonly ?int $orderMinAmount;
    public readonly ?int $orderMaxAmount;

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setProp(string $name, mixed $value): void
    {
        $this->{$name} = $value;
    }

}
