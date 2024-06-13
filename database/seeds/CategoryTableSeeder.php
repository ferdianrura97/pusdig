<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Simaksi',
            'slug' => 'Simaksi',
            'photo' => 'buku.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Buku',
            'slug' => 'buku',
            'photo' => 'c1.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Buletin',
            'slug' => 'buletin',
            'photo' => 'buletin.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Laporan',
            'slug' => 'laporan',
            'photo' => 'laporan.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Dokumen BBTNGGP',
            'slug' => 'dokumen',
            'photo' => 'dokumen.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Peraturan Perundangan',
            'slug' => 'peraturan',
            'photo' => 'peraturan.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'PKL',
            'slug' => 'pkl',
            'photo' => 'pkl.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Skripsi',
            'slug' => 'skripsi',
            'photo' => 'skripsi.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Tesis',
            'slug' => 'tesis',
            'photo' => 'tesis.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'Lainnya',
            'slug' => 'lainnya',
            'photo' => 'lainnya.png'
        ]);
    }
}
