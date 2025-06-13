<?php

use Illuminate\Database\Seeder;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Project;

class InquirySeeder extends Seeder
{
    public function run()
    {
        $projects = Project::all();
        $users = User::where('role', 'user')->get();

        foreach ($projects as $project) {
            Inquiry::create([
                'user_id' => $users->random()->id,
                'project_id' => $project->id,
                'message' => 'I am interested in this project. Can you give more details?',
            ]);
        }
    }
}
