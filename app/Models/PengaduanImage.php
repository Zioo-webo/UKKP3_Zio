<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaduanImage extends Model
{
    protected $table = 'pengaduan_image';
    protected $fillable = ['pengaduan_id', 'file_path', 'file_name'];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}