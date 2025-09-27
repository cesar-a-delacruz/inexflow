<?php

namespace App\Enums\Observable;

interface Displayable
{
    public function label(): string;

    public static function labelFromValue(string $value): string;
    /**
     * @return array<string, string>
     */
    public static function options(): array;

    public static function getDefault(): string;
}
