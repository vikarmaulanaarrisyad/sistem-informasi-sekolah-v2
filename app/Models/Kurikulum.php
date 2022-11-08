<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'kurikulum';

    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahunajaran::class);
    }
}
