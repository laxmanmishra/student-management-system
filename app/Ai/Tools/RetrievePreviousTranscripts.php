<?php

namespace App\Ai\Tools;

use App\Models\History;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class RetrievePreviousTranscripts implements Tool
{
    public function description(): Stringable|string
    {
        return 'Retrieve previous conversation transcripts for a student to analyze their progress.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'user_id' => $schema->integer()->required()->description('The user ID to retrieve transcripts for.'),
            'limit' => $schema->integer()->default(20)->description('Maximum number of transcripts to retrieve.'),
        ];
    }

    public function handle(Request $request): Stringable|string
    {
        $userId = $request['user_id'];
        $limit = $request['limit'] ?? 20;

        $user = User::find($userId);

        if (! $user) {
            return 'User not found.';
        }

        $transcripts = History::where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();

        if ($transcripts->isEmpty()) {
            return 'No previous transcripts found for this student.';
        }

        return $transcripts->map(function ($transcript) {
            return sprintf(
                '[%s] %s: %s',
                $transcript->created_at->format('Y-m-d H:i'),
                ucfirst($transcript->role),
                $transcript->content
            );
        })->implode("\n\n");
    }
}
