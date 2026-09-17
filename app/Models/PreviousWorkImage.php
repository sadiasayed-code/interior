<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PreviousWorkImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'previous_work_id',
        'image',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | Previous Work
    |--------------------------------------------------------------------------
    */

    public function previousWork()
    {
        return $this->belongsTo(
            PreviousWork::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Physical Image File When Image Record Is Deleted
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::deleting(function ($image) {

            if ($image->image) {

                Storage::disk('public')
                    ->delete($image->image);
            }
        });
    }
}