<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PreviousWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Gallery Images
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(
            PreviousWorkImage::class
        )->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete All Gallery Files When Previous Work Is Deleted
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::deleting(function ($previousWork) {

            foreach ($previousWork->images as $image) {

                if ($image->image) {
                    Storage::disk('public')
                        ->delete($image->image);
                }
            }
        });
    }
}