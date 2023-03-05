<?php

if (!function_exists('diff_for_humans')) {
    function diff_for_humans(\Illuminate\Support\Carbon $date): string
    {
        return $date->diffForHumans();
    }
}
