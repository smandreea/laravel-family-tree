<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFamilyMember;
use App\FamilyMember;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "first_name",
            "middle_name",
            "last_name",
            "gender",
            "relationship",
            "related_member"]);

        throw_if($data['relationship'] == FamilyMember::CHILD && is_null($data['related_member']), new InvalidFamilyMember('You need a parent in order to add a child.'));

        if (User::where('id', $data['related_member'])->exists()) {
            $newMember = User::create([
                "first_name" => $data['first_name'],
                "middle_name" => $data['middle_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
            ]);

            if ($data['relationship'] == FamilyMember::CHILD) {
                FamilyMember::create([
                    "user_id" => $newMember->id,
                    "parent_id" => $data['related_member']
                ]);
            } else {
                FamilyMember::create([
                    "user_id" => $data['related_member'],
                    "parent_id" => $newMember->id,
                ]);
            }
        }

        if ($data['relationship'] == FamilyMember::PARENT) {
            $newMember = User::create([
                "first_name" => $data['first_name'],
                "middle_name" => $data['middle_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
            ]);

            if (isset($data['related_member'])) {
                FamilyMember::create([
                    "user_id" => $data['related_member'],
                    "parent_id" => $newMember->id,
                ]);
            } else {
                FamilyMember::create([
                    "user_id" => $newMember->id,
                    "parent_id" => null,
                ]);
            }
        }

        return response()->json($newMember);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
