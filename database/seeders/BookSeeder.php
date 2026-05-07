<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka',
            'year' => 2005,
            'isbn' => '9789791227002',
            'stock' => 10,
        ]);

        \App\Models\Book::create([
            'title' => 'Bumi',
            'author' => 'Tere Liye',
            'publisher' => 'Gramedia Pustaka Utama',
            'year' => 2014,
            'isbn' => '9786020301129',
            'stock' => 5,
        ]);

        \App\Models\Book::create([
            'title' => 'Filosofi Teras',
            'author' => 'Henry Manampiring',
            'publisher' => 'Buku Kompas',
            'year' => 2018,
            'isbn' => '9786024125189',
            'stock' => 7,
        ]);

        \App\Models\Book::create([
            'title' => 'Sang Pemimpi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang Pustaka',
            'year' => 2006,
            'isbn' => '9789791227026',
            'stock' => 8,
        ]);

        \App\Models\Book::create([
            'title' => 'Negeri 5 Menara',
            'author' => 'Ahmad Fuadi',
            'publisher' => 'Gramedia Pustaka Utama',
            'year' => 2009,
            'isbn' => '9789792248616',
            'stock' => 4,
        ]);
    }
}
