<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardingHouse extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'slug',
        'thumbnail',
        'city_id',
        'catagory_id',
        'description',
        'price',
        'address',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rooms()
    {
        return $this->hashMany(room::class);
    }

    public function bonuses()
    {
        return $this->hashMan(Bonus::class);
    }

    public function testimonnials()
    {
        return $this->hashMan(Testiomonial::class);
    }

    public function transactions()
    {
        return $this->hashMan(transaction::class);
    }
}
