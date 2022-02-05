<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalaxyResource;
use App\Models\Galaxy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GalaxyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return GalaxyResource::collection(Galaxy::latest()->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'about', 'light_years'), [
                'name' => ['required', 'string', 'min:5', 'max:100', Rule::unique('galaxies', 'name')],
                'about' => ['string', 'max:250'],
                'light_years' => ['required', 'integer']
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $galaxy = Galaxy::create([
            'name' => $request->name,
            'about' => $request->about,
            'light_years' => $request->light_years
        ]);

        return response()->json([
            'New entry created',
            new GalaxyResource($galaxy)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Galaxy $galaxy
     * @return JsonResponse
     */
    public function show(Galaxy $galaxy)
    {
        return $galaxy ? response()->json([new GalaxyResource($galaxy)]) : response()->json('Record not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Galaxy $galaxy
     * @return JsonResponse
     */
    public function update(Request $request, Galaxy $galaxy)
    {
        $validator = Validator::make(
            $request->only('name', 'about', 'light_years'),
            [
                'name' => ['sometimes', 'required', 'string', 'min:5', 'max:100', Rule::unique('galaxies', 'name')],
                'about' => ['sometimes', 'string', 'max:250'],
                'light_years' => ['sometimes', 'required', 'integer']
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $galaxy->update($validator->validated());

        return response()->json(
            [
                'Record updated',
                new GalaxyResource($galaxy)
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Galaxy $galaxy
     * @return JsonResponse
     */
    public function destroy(Galaxy $galaxy)
    {
        $galaxy->delete();

        return response()->json('Record deleted');
    }
}
