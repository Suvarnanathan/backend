<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\JobType;
class JobTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobTypeItems =[
            [
                'name'  => 'Full Time',

            ],
            [
                'name'  => 'Part Time',

            ],
            [
                'name'  => 'Remote Job',

            ],
            [
                'name'  => 'Self-Employed',
            ],
            [
                'name'  => 'Freelance',
            ],
            [
                'name'  => 'Contract',
            ],
            [
                'name'  => 'Internship',
            ],
            [
                'name'  => 'Appret',
            ],
            [
                'name'  => 'Apprenticeship'
            ],
            [
                'name'  => 'Seasonal'
            ]
        ];
         /*
         * Add Categories Items
         *
         */
        foreach ($jobTypeItems as $jobTypeItem) {
            $jobTypeItem = JobType::create([
                'name'            => $jobTypeItem['name'],
                'slug'            => Str::slug($jobTypeItem['name']),
                
            ]);
        }
    }
}
