<?php

if (! function_exists('diff_for_humans')) {
    function diff_for_humans(?Illuminate\Support\Carbon $date): ?string
    {
        return $date?->diffForHumans();
    }
}

if (! function_exists('date_for_humans')) {
    function date_for_humans(?Illuminate\Support\Carbon $date): ?string
    {
        return $date?->format('M d, Y h:i A');
    }
}

if (! function_exists('generate_reference_number')) {
    function generate_reference_number(string $table, int $length = 10): string
    {
        do {
            $reference_number = strtoupper(Str::random($length));
        } while (\Illuminate\Support\Facades\DB::table($table)->where('reference_number', $reference_number)->exists());

        return $reference_number;
    }
}

if (! function_exists('date_range_filter_transformer')) {
    function date_range_filter_transformer(string $dateString): array
    {
        if (!str_contains($dateString, ' to ')) {
            return [$dateString . ' 00:00:00', $dateString . ' 23:59:59'];
        }

        $dates = explode(' to ', $dateString);
        $dates[1] = $dates[1] . ' 23:59:59';
        return $dates;
    }
}
