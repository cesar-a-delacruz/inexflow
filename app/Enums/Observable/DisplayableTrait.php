<?php

namespace App\Enums\Observable;

trait DisplayableTrait
{
    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->value] = $case->label();
        }
        return $values;
    }

    public function label(): string
    {
        return self::labelFromValue($this->value);
    }
}
