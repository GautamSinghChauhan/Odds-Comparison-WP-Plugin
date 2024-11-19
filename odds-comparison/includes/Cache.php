<?php
namespace OddsComparison;

class Cache {
    public static function get_cached_odds($key) {
        return get_transient($key);
    }

    public static function set_cached_odds($key, $data, $expiration = 3600) {
        set_transient($key, $data, $expiration);
    }
}
