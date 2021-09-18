<?php

namespace Database\Seeders;

use App\Models\JobSubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class JobSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobSubCategories =[
            [
                'jobCategoryId'=> 1,
                'name'=>'Software Engineer',

            ],
            [
                'jobCategoryId'=> 1,
                'name'=>'Senior Software Engineer',

            ],
           
        ];
         /*
         * Add Categories Items
         *
         */
        foreach ($jobSubCategories as $jobSubCategory) {
            $jobSubCategory = JobSubCategory::create([
                'name'            => $jobSubCategory['name'],
                'slug'            => Str::slug($jobSubCategory['name']),
                'job_category_id' => $jobSubCategory['jobCategoryId']
            ]);
        }
    }
}
