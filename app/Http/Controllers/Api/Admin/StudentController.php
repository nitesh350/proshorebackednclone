<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Repositories\StudentRepository;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentController extends Controller
{
    /**
     * @var StudentRepository
     */
    private StudentRepository $studentRepository;

    /**
     * @param  StudentRepository  $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $students = User::where('user_type', 'student')->paginate(10);
        return UserResource::collection($students);
    }

    /**
     * @param User $student
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        $student = $this->studentRepository->show($id);
        return new UserResource($student);
    }
}
