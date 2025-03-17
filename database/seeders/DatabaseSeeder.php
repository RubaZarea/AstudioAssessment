<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->seedProjects();
        $this->seedProjectAttributes();
        Timesheet::factory(15)->create();
    }

    public function seedProjects(): void
    {
        Project::factory(10)->create()->each(function ($project) {
            $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $project->users()->attach($users);
        });
    }

    public function seedProjectAttributes(): void
    {
        $attributes = [
            ['name' => 'department', 'type' => 'text'],
            ['name' => 'start_date', 'type' => 'date'],
            ['name' => 'end_date', 'type' => 'date'],
        ];
        foreach ($attributes as $attr) {
            Attribute::create($attr);
        }

        Project::all()->each(function ($project) {
            foreach (Attribute::all() as $attribute) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'value' => $attribute->type === 'date' ? now()->toDateString() : 'Dummy Value',
                ]);
            }
        });
    }
}
