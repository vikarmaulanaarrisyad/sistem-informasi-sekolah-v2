<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('format_uang')) {
    function format_uang($angka) {
        return number_format($angka,0,',','.');
    }
} 

if (!function_exists('tanggal_indonesia')) {
    function tanggal_indonesia($tgl, $tampilHari = false) {
        $namaHari = array(
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'
        );

        $namaBulan = array(
            1 =>
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );

        $tahun = substr($tgl, 0, 4);
        $bulan = $namaBulan[(int) substr($tgl, 5, 2)];
        $tanggal = substr($tgl, 8, 2);
        $text = '';

        if ($tampilHari) {
            $urutanHari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $bulan));
            $hari = $namaHari[$urutanHari];
            $text .= "$hari, $tanggal $bulan $tahun";
        } else {
            $text .= "$tanggal $bulan $tahun";
        }

        return $text;
    }

    if (!function_exists('upload')) {
        function upload($directory, $file, $filename = "")
        {
            $extensi  = $file->getClientOriginalExtension();
            $filename = "{$filename}_" . date('Ymdhis') . ".{$extensi}";
    
            Storage::disk('public')->putFileAs("/$directory", $file, $filename);
    
            return "/$directory/$filename";
        }
    }

    if (!function_exists('sembunyikan_text')) {
        function sembunyikan_text($words, $offset = 0)
        {
            $text = '';
            for ($i = 0; $i < strlen($words); $i++) {
                if (($i + $offset) >= strlen($words) && !($offset >= strlen($words))) {
                    $text .= $words[$i];
                } else {
                    $text .= '*';
                }
            }
    
            return $text;
        }
    }

    function set_active($uri, $output = 'active')
    {
        if (is_array($uri)) {
            foreach ($uri as $url) {
                if (Route::is($url)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($uri)) {
                return $output;
            }
        }
    }
}