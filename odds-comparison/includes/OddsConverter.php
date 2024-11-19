<?php
namespace Odds;

class OddsConverter {
    public static function to_fractional($decimal) {
        if ($decimal < 2) {
            return round((1 / ($decimal - 1)) * 100) . '/' . 100;
        }
        return round($decimal - 1) . '/' . 1;
    }

    public static function to_american($decimal) {
        if ($decimal >= 2) {
            return '+' . round(($decimal - 1) * 100);
        }
        return '-' . round(100 / ($decimal - 1));
    }
}
