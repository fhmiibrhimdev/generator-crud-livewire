<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataBarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tanggal'             => date('Y-m-d'),
                'qty'                 => '0',
                'nama_barang'         => '',
            ],
            [
                'tanggal'             => date('Y-m-d'),
                'qty'                 => '0',
                'nama_barang'         => '',
            ],
            [
                'tanggal'             => date('Y-m-d'),
                'qty'                 => '0',
                'nama_barang'         => '',
            ],
            [
                'tanggal'             => date('Y-m-d'),
                'qty'                 => '0',
                'nama_barang'         => '',
            ],    ];

        DB::table('data_barang')->insert($data);
    }
}