<?php

namespace App\Vendor;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

trait InteractsWithHashedMedia
{
    use InteractsWithMedia {
        InteractsWithMedia::addMediaFromDisk as addMediaFromDiskOriginal;
    }

    public function addMediaFromDisk($file, $disk = null): FileAdder
    {
        return $this->addMediaFromDiskOriginal($file->getRealPath(), $disk)
            ->usingFileName($file->hashName());
    }
}
