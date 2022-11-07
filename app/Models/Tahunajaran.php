<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahunajaran extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajaran';
    protected $guarded = [];

    public function scopeActive()
    {
        return $this->where('is_active',1);
    }


    public function statusColor()
    {
        $color = '';
        switch ($this->is_active) {
            case '0':
                $color = 'warning';
                break;

            case '1':
                $color = 'success';
                break;
            
            default:
                break;
        }

        return $color;
    }

    public function statusText()
    {
        $text = '';
        switch ($this->is_active) {
            case '0':
                $text = 'Tidak Aktif';
                break;
            case '1':
                $text = 'Aktif';
                break;
            
            default:
                break;
        }

        return $text;
    }
}
