<?php

namespace App\Http\Livewire\Traits;

trait WithCachedRows
{
    protected $useCache = false;

    public function useCachedRows()
    {
        $this->useCache = true;
    }

    public function cache($callback, $prefix = null)
    {
        if (!$prefix) {
            $cacheKey = $this->id;
        } else {
            $cacheKey = $prefix . $this->id;
        }

        if ($this->useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callback();

        cache()->put($cacheKey, $result);

        return $result;
    }
}
