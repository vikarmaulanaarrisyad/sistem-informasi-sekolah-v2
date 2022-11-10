<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $table = 'rombel';
    protected $guarded = [];

    public function scopeFilter($query, $request)
    {
        return $query->when($request->has('tahunpelajaran') && $request->tahunpelajaran != '', function ($query) use ($request) {
            $query->where('tahun_ajaran_id',$request->tahunpelajaran);
        });

    }
}
