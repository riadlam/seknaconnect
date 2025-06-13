<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $professionals = User::where('role', 'professional')->get();

        foreach ($professionals as $pro) {
            Project::factory()->count(3)->create([
                'user_id' => $pro->id
            ]);
        }
    }
}
