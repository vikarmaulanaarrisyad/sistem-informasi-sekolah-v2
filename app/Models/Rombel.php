<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $table = 'rombel';
    protected $guarded = [];

    public function guru () {
        return $this->hasOne(Guru::class,'guru_id','id')->withDefault(0);
    }

    public function ruangan () {
        return $this->belongsTo(Ruangan::class);
    }

    public function kurikulum () {
        return $this->belongsTo(Kurikulum::class);
    }

    public function tingkat_rombel () {
        return $this->belongsTo(TingkatRombel::class);
    }

    public function tahun_ajaran () {
        return $this->belongsTo(Tahunajaran::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query->when($request->has('tahunpelajaran') && $request->tahunpelajaran != '', function ($query) use ($request) {
            $query->where('tahun_ajaran_id',$request->tahunpelajaran);
        });

    }
}
