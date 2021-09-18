<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class JobCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobCategories =[
            [
                'name'=>'It Industry'
            ],
            
           
        ];
         /*
         * Add Categories Items
         *
         */
        foreach ($jobCategories as $jobCategory) {
            $jobCategory = JobCategory::create([
                'name'            => $jobCategory['name'],
                'slug'            => Str::slug($jobCategory['name']),
            ]);
        }
    }
}
