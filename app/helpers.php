<?php

if (! function_exists('diff_for_humans')) {
    function diff_for_humans(Illuminate\Support\Carbon $date): string
    {
        return $date->diffForHumans();
    }
}

if (! function_exists('date_for_humans')) {
    function date_for_humans(Illuminate\Support\Carbon $date): string
    {
        return $date->format('M d, Y h:i A');
    }
}
