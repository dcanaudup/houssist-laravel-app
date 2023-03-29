<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\TempUpload
 *
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TempUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUpload query()
 *
 * @mixin \Eloquent
 */
class TempUpload extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
}
