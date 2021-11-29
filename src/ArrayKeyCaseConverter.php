<?php

namespace Jauntin\PdfPlatformSdk;

use Jawira\CaseConverter\CaseConverter;

class ArrayKeyCaseConverter
{
    public function toSnakeCase(array $data): array
    {
        return $this->convert($data, 'toSnake');
    }

    public function toCamelCase(array $data): array
    {
        return $this->convert($data, 'toCamel');
    }

    private function convert(array $data, string $function): array
    {
        $caseConverter = resolve(CaseConverter::class);
        $updated = [];
        foreach ($data as $k => $v) {
            $updated[$caseConverter->convert($k)->$function()] = $v;
        }
        return $updated;
    }
}
