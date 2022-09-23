<?php

/**
 * Enable Query Log
 */
if (!function_exists('eventmanagementsystem_eql')) {
    function eventmanagementsystem_eql()
    {
        defined('SAVEQUERIES') || define('SAVEQUERIES', true);
    }
}

/**
 * Get Query Log
 */
if (!function_exists('eventmanagementsystem_gql')) {
    function eventmanagementsystem_gql()
    {
        $result = [];
        foreach ((array)$GLOBALS['wpdb']->queries as $key => $query) {
            $result[++$key] = array_combine([
                'query', 'execution_time'
            ], array_slice($query, 0, 2));
        }
        return $result;
    }
}

