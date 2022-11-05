<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Signature',
            'photo' => 'signature.svg',
        ]);
        Category::create([
            'name' => 'Croissant',
            'photo' => 'croissant.svg',
        ]);
        Category::create([
            'name' => 'Coffee',
            'photo' => 'coffee.png',
        ]);
        Category::create([
            'name' => 'Pancake',
            'photo' => 'pancake.svg',
        ]);
        Category::create([
            'name' => 'Ice Cream',
            'photo' => 'ice-cream.svg',
        ]);
    }
}
