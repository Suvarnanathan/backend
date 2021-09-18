<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills =[
            [
                'name'=>'Team work'
            ],
            [
                'name'=>'Leadership'

            ],
            [
                'name'=>'Time Management'

            ],
            [
                'name'=>'Active Learning'

            ],
            [
                'name'=>'Decision Making'

            ]
            
           
        ];
         /*
         * Add Categories Items
         *
         */
        foreach ($skills as $skill) {
            $skill = Skill::create([
                'name'            => $skill['name'],
                'slug'            => Str::slug($skill['name']),
            ]);
        }
    }
}
