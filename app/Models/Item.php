<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;
class Item extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    protected $fillable = [
        'user_id',
        'cat_id',
        'sub_cat_id',
        'company_id',
        'title',
        'notes',
        'image',
        'code',
        'price',
        'sale_price',
        'stock',
        'status',
        'created_at'
    ];
    function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
    function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_cat_id');
    }
    function sale()
    {
        return $this->hasMany(Sale::class, 'item_id');
    }
    function getImageAttribute($image)
    {
        return $this->getMedia('images')->last() ? $this->getMedia('images')->last()->getUrl('preview') : asset('imgs/no-image.png');
    }

    function setImageAttribute($image)
    {
        $image_name =  rand(1000, 9999) . time() . '.' . $image->extension();
        $image->move(public_path("uploads/images"), $image_name);
        $this->addMedia(public_path("uploads/images/$image_name"))->toMediaCollection('images');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_STRETCH, 150, 100)
            ->nonQueued();
    }
    function scopeAllowed($query)
    {
        $user = session()->get('user');
        return $query->whereUserId($user->id)->orWhere('depot_id', $user->depot_id);
    }
    function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    function scopeNotInStock($query)
    {
        return $query->whereStock(0);
    }
}
