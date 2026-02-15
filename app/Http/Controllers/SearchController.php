<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Examination;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        try {
            $users = User::search($query)->take(10)->get();
            $examinations = Examination::search($query)->take(10)->get();
            $subjects = Subject::search($query)->take(10)->get();
            // $results = $users->map(function ($user) {
            //     return [
            //         'id' => $user->id,
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'type' => 'user',
            //         'url' => route('admin.students.show', $user->id),
            //     ];
            // });

            // $results = $results->merge($examinations->map(fn ($exam) => [
            //     'id' => $exam->id,
            //     'name' => $exam->name,
            //     'exam_type' => $exam->exam_type,
            //     'type' => 'examination',
            //     'url' => route('admin.examinations.show', $exam->id),
            // ]));

            $results = collect();
 
            foreach ($users as $user) {
                $results->push([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => 'user',
                    'url' => route('admin.students.show', $user->id),
                ]);
            }
        
            foreach ($examinations as $exam) {
                $results->push([
                    'id' => $exam->id,
                    'name' => $exam->name,
                    'exam_type' => $exam->exam_type,
                    'type' => 'examination',
                    'url' => route('admin.examinations.show', $exam->id),
                ]);
            }

            foreach ($subjects as $subject) {
                $results->push([
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'code' => $subject->code,
                    'type' => 'subject',
                    'url' => route('admin.subjects.show', $subject->id),
                ]);
            }

            return response()->json(['results' => $results]);
        } catch (\Exception $e) {
            return response()->json(['results' => [], 'error' => $e->getMessage()], 500);
        }
    }
}
