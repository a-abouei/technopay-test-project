<?php

namespace App\Dtos;

use App\Exceptions\NotFoundDtoPropertyException;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

class BaseDto
{
    /** @var array<string, mixed> */
    protected array $defaultValues = [];

    /**
     * @throws NotFoundDtoPropertyException
     */
    public function __construct(array $data)
    {
        foreach ($this->getVars() as $key => $value) {
            if (!array_key_exists(Str::snake($value->name), $data)) {
                if (array_key_exists($value->name, $this->defaultValues)){
                    $this->setProp($value->name, $this->defaultValues[$value->name]);

                    continue;
                }
                throw new NotFoundDtoPropertyException("Property '{$value->name}' was not present in input");
            }

            if (is_null($data[Str::snake($value->name)]) && isset($this->defaultValues[$value->name])){
                $this->setProp($value->name, $this->defaultValues[$value->name]);

                continue;
            }

            $this->setProp($value->name, $data[Str::snake($value->name)]);
        }
    }

    /**
     * Returns array of properties
     *
     */
    private function getVars(): array
    {
        return (new ReflectionClass($this))->getProperties(ReflectionProperty::IS_READONLY);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arrayData = [];
        foreach ($this->getVars() as $key => $value){
            $arrayData[Str::snake($value->name)] = $this->{$value->name};
        }

        return $arrayData;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setProp(string $name, mixed $value): void
    {
        throw new Exception("'setProp' method not defined in dto");
    }
}
