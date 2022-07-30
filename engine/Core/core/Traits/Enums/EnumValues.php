<?php

namespace Base\Traits\Enums;

/**
 * Trait to support all enums
 */
trait EnumValues
{

    /**
     * Get Values
     *
     * @return object
     */
    public static function getValues()
    {
        $cases = [];
        
        foreach (self::cases() as $case) {
            $cases[] = ['name' => $case->name, 'value' =>  $case->value];
        }
        
        return arrayz($cases)->pluck('value')->get();
    }

    /**
     * Has Value
     *
     * @param string $value
     * @return bool
     */
    public static function hasValue(string $value)
    {
        return arrayz(self::getValues())->contains('value', $value);
    }

}
