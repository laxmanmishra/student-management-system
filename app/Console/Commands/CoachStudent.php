<?php

namespace App\Console\Commands;

use App\Ai\Agents\StudentCoach;
use App\Models\History;
use App\Models\User;
use Illuminate\Console\Command;

class CoachStudent extends Command
{
    protected $signature = 'app:coach-student {user_id} {message}';

    protected $description = 'Chat with the AI Student Coach';

    public function handle(): void
    {
        $user = User::findOrFail($this->argument('user_id'));
        $message = $this->argument('message');

        // Save user message to history
        History::create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $message,
        ]);

        // Create the agent and send the prompt
        $coach = new StudentCoach($user);
        $response = $coach->prompt($message);

        // Display structured response
        $this->info("Feedback: {$response['feedback']}");
        $this->info("Score: {$response['score']}/10");

        // Save assistant response to history
        History::create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => $response['feedback'],
        ]);
    }
}
