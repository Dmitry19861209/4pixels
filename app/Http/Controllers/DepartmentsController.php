<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DepartmentsController extends Controller
{
    /**
     * Departments page
     */
    public function index()
    {
        return view('departments.index');
    }
    /**
     * Get all departments
     *
     * @return Department[]
     */
    public function getAllDepartments()
    {
        return Department::with('users')
            ->orderBy('id')
            ->get();

    }

    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now();

        Department::validate($request);

        $createData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        if ($request->hasFile('logo')) {
            $filename = $this->uploadedFile($request);
            $createData['logo'] = $filename;
        } else {
            $createData['logo'] = '';
        }

        $department = Department::create($createData);

        if ($request->has('users')) {
            foreach ($request->input('users') as $userId) {
                /** @var User $user */
                $user = User::find($userId);
                if ($user) {
                    $user->departments()->save($department);
                }
            }
        }

        return redirect(route('departments'));
    }

    /**
     * Show the department form for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('departments.edit', [
            'departmentId' => $id
        ]);
    }

    /**
     * Get department by id
     *
     * @param $id
     * @return Department
     */
    public function getDepartmentById($id)
    {
        return Department::with('users')
            ->where('id', $id)
            ->get()
            ->first();
    }

    /**
     * Update department by id.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $department = Department::find($id);
        $name = $request->input('name');

        Department::validate($request, $department);

        $updateData = [
            'description' => $request->input('description'),
            'updated_at' => $now,
        ];

        if ($name !== $department->name) {
            $updateData['name'] = $name;
        }

        if ($request->hasFile('logo')) {
            $filename = $this->uploadedFile($request);
            $updateData['logo'] = $filename;
        } else {
            $updateData['logo'] = $department->logo;
        }

        $department->update($updateData);

        return redirect(route('departments.edit', $id));
    }

    public function checkUser(Request $request)
    {
        $userId = $request->input('userId');
        $departmentId = $request->input('departmentId');
        $isSelect = $request->input('state');

        /** @var User $user */
        $user = User::find($userId);
        /** @var Department $department */
        $department = Department::find($departmentId);

        if ($isSelect) {
            $user->departments()->save($department);
        } else {
            $user->departments()->detach($department);
        }
    }

    /**
     * Remove department by id.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id): void
    {
        $department = Department::find($id);
        $department->delete();
    }

    /**
     * Uploaded file
     *
     * @param Request $request
     * @return string
     */
    private function uploadedFile(Request $request): string {
        $uploadedFile = $request->file('logo');
        $filename = $uploadedFile->getClientOriginalName();

        Storage::disk('local')->putFileAs(
            '/public/logo/',
            $uploadedFile,
            $filename
        );

        return $filename;
    }
}
