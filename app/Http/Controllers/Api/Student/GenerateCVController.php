<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateCVController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $user = auth()->user()->load('profile');

        [$firstName, $lastName] = explode(' ', $user->name);

        $user['firstName'] = $firstName;
        $user['lastName'] = $lastName;

        $cv_name = $firstName . "_" . $lastName . "_CV.pdf";

        $user->profile['avatar_path'] = str_replace(storage_path('app'), '', $user->profile->avatar);

        $results = $user->results()
            ->where('passed', 1)
            ->select(['id', 'quiz_id'])
            ->with(['quiz:id,title,pass_percentage'])
            ->get();

        Pdf::view('cv.index', compact(['user', 'results']))
            ->paperSize(1440, 2040, 'px')
            ->save(storage_path("app/cv/" . $cv_name));

        return response()->json([
            'cv' => 'http://127.0.0.1:8000/cv/' . $cv_name,
        ]);
    }
}
