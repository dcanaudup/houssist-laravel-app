<?php

namespace App\Http\Livewire\Traits;

use App\Exceptions\LockedPublicPropertyTamperException;
use Illuminate\Support\Str;

trait WithLockedPublicPropertiesTrait
{
    /**
     * @throws LockedPublicPropertyTamperException|ReflectionException
     */
    public function updatingWithLockedPublicPropertiesTrait($name): void
    {
        $propertyName = Str::of($name)->explode('.')->first();
        $reflectionProperty = new \ReflectionProperty($this, $propertyName);
        if (Str::of($reflectionProperty->getDocComment())->contains('@locked')) {
            throw new LockedPublicPropertyTamperException("You are not allowed to tamper with the protected property {$propertyName}");
        }
    }
}
