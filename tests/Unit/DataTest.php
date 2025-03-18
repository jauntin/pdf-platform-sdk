<?php

namespace Jauntin\PdfPlatformSdk\Tests\Unit;

use Jauntin\PdfPlatformSdk\Data;
use Jauntin\PdfPlatformSdk\Tests\TestCase;

class TestData extends Data
{
    public string $firstName;

    public string $lastName;

    public array $addresses;
}

class DataTest extends TestCase
{
    private TestData $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = new TestData;
    }

    public function test_it_can_convert_from_array_to_object(): void
    {
        $input = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'addresses' => [
                ['street' => '123 Main St'],
                ['street' => '456 Oak Ave'],
            ],
        ];

        $this->data->fromArray($input);

        $this->assertEquals('John', $this->data->firstName);
        $this->assertEquals('Doe', $this->data->lastName);
        $this->assertCount(2, $this->data->addresses);
        $this->assertEquals('123 Main St', $this->data->addresses[0]['street']);
        $this->assertEquals('456 Oak Ave', $this->data->addresses[1]['street']);
    }

    public function test_it_can_convert_from_object_to_array(): void
    {
        $this->data->firstName = 'John';
        $this->data->lastName = 'Doe';
        $this->data->addresses = [
            ['street' => '123 Main St'],
            ['street' => '456 Oak Ave'],
        ];

        $result = $this->data->toArray();

        $this->assertEquals('John', $result['first_name']);
        $this->assertEquals('Doe', $result['last_name']);
        $this->assertCount(2, $result['addresses']);
        $this->assertEquals('123 Main St', $result['addresses'][0]['street']);
        $this->assertEquals('456 Oak Ave', $result['addresses'][1]['street']);
    }

    public function test_it_throws_exception_for_unknown_property(): void
    {
        $this->expectException(\Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException::class);
        $this->expectExceptionMessage('Unknown property unknownField');

        $this->data->fromArray([
            'unknown_field' => 'value',
        ]);
    }
}
