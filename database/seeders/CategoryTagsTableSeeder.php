<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class CategoryTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::findOrCreate('Cleaning', 'jobCategory');
        Tag::findOrCreate('Handy Person', 'jobCategory');
        Tag::findOrCreate('Transport', 'jobCategory');
        Tag::findOrCreate('Painting', 'jobCategory');
        Tag::findOrCreate('Carpentry', 'jobCategory');
        Tag::findOrCreate('Electrical', 'jobCategory');
        Tag::findOrCreate('Plumbing', 'jobCategory');
        Tag::findOrCreate('Gardening', 'jobCategory');
        Tag::findOrCreate('Delivery', 'jobCategory');
        Tag::findOrCreate('Packing & Lifting', 'jobCategory');
        Tag::findOrCreate('Errands', 'jobCategory');
        Tag::findOrCreate('Pet Care', 'jobCategory');
        Tag::findOrCreate('Cooking', 'jobCategory');
        Tag::findOrCreate('Others', 'jobCategory');
    }
}
