<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $guarded = [];

    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahunajaran::class);
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    public function wali_kelas()
    {
        return $this->belongsTo(Guru::class);
    }
}
