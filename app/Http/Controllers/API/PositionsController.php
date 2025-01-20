<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Validation\Rule;

use App\Models\Position;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Position::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->input('search')}%");
        }

        $order = $request->input('order', 'asc');

        $positions = $query->select(['id', 'name'])->orderBy('name', $order)->get();

        return response()->json($positions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:positions',
            'supervisor_id' => [
                Rule::unique('positions')->where(function ($query) {
                    return $query->whereNull('supervisor_id');
                }),
                'exists:positions,id'
            ],
        ]);

        $validator->setCustomMessages([
            'supervisor_id.exists' => 'The supervisor does not exist',
            'supervisor_id.unique' => 'Only one item can have a null report to field.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $position = Position::create($validator->validated());

        return response()->json(['status' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::where('id', '=', $id)->select(['id', 'supervisor_id', 'name', 'created_at'])
            ->with(['supervisor' => function ($query) {
                $query->select('id', 'name', 'created_at');
            }])
            ->first();

        if ($position) {
            return response()->json($position);
        }

        return response()->json(['errors' => ['Position does not exist']], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => [
                Rule::unique('positions')->ignore($id),
            ]
        ];

        if ($request->filled('supervisor_id')) {
            $rules['supervisor_id'] = [
                Rule::unique('positions')->where(function ($query) {
                    return $query->whereNull('supervisor_id');
                })->ignore($id),
                'exists:positions,id'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        $validator->setCustomMessages([
            'supervisor_id.exists' => 'The supervisor does not exist',
            'supervisor_id.unique' => 'Only one item can have a null report to field.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Fail',
                'errors' => $validator->errors()
            ], 422);
        }

        $position = Position::where('id', '=', $id)->first();

        if ($position) {
            $position->update($validator->validated());

            return response()->json(['status' => 'Success'], 200);
        }

        return response()->json(['errors' => ['Position does not exist']], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::where('id', '=', $id)->first();

        if ($position) {
            $position->delete();

            return response()->json(['status' => 'Success'], 200);
        }

        return response()->json(['errors' => ['Position does not exist']], 404);
    }

    public function viewPositionDetails()
    {
        
    }
}
