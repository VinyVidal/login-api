<?php

namespace App\Constants;

class AppLocalesConstant {
    const EN = 'en';
    const PT_BR = 'pt-BR';

    static function toArray() {
        return [self::EN, self::PT_BR];
    }
}
