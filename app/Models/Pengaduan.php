<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $fillable = ['category_id', 'user_id', 'phone', 'description'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function pengaduan_image()
    {
        return $this->hasMany(PengaduanImage::class);
    }
}
