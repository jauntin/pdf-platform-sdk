<?php

namespace Jauntin\PdfPlatformSdk;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Arrayable;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * @implements Arrayable<string, mixed>
 */
abstract class Data implements Arrayable
{
    private ArrayKeyCaseConverter $arrayCaseConverter;

    /**
     * @param  array<string,mixed>  $data
     * @return void
     *
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws InvalidInputException
     */
    public function __construct(array $data = [])
    {
        $this->arrayCaseConverter = resolve(ArrayKeyCaseConverter::class);
        $this->fromArray($data);
    }

    /**
     * @param  array<string,mixed>  $data
     *
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws InvalidInputException
     */
    public function fromArray(array $data): void
    {
        $data = $this->arrayCaseConverter->toCamelCase($data);
        $reflect = new ReflectionClass($this);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $reflect->getProperty($key)->isPublic()) {
                $this->{$key} = $value;
            } else {
                throw new InvalidInputException("Unknown property $key");
            }
        }
    }

    /**
     * @return array<string,mixed>
     *
     * @throws BindingResolutionException
     */
    public function toArray(): array
    {
        $data = [];
        $reflect = new ReflectionClass($this);
        foreach ($reflect->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $key = $property->getName();
            if (isset($this->{$key})) {
                $value = $property->getValue($this);
                if (is_array($value)) {
                    $data[$key] = collect($value)->toArray();
                } else {
                    $data[$key] = $value;
                }
            }
        }

        return $this->arrayCaseConverter->toSnakeCase($data);
    }
}
