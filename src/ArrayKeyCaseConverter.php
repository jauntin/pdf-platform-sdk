<?php

namespace Jauntin\PdfPlatformSdk;

use Illuminate\Contracts\Container\BindingResolutionException;
use Jawira\CaseConverter\CaseConverter;
use Jawira\CaseConverter\CaseConverterException;

class ArrayKeyCaseConverter
{
    /**
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     *
     * @throws BindingResolutionException
     * @throws CaseConverterException
     */
    public function toSnakeCase(array $data): array
    {
        return $this->convert($data, 'toSnake');
    }

    /**
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     *
     * @throws BindingResolutionException
     * @throws CaseConverterException
     */
    public function toCamelCase(array $data): array
    {
        return $this->convert($data, 'toCamel');
    }

    /**
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     *
     * @throws BindingResolutionException
     * @throws CaseConverterException
     */
    private function convert(array $data, string $function): array
    {
        /** @var CaseConverter */
        $caseConverter = resolve(CaseConverter::class);
        $updated = [];
        foreach ($data as $k => $v) {
            $updated[$caseConverter->convert($k)->$function()] = $v;
        }

        return $updated;
    }
}
