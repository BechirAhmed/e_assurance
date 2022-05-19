<?php

namespace App\Http\Controllers\Api;

use App\Models\Assurance;
use Illuminate\Http\Request;
use App\Http\Resources\AssuranceResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AssuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $assuranceQuery = Assurance::query();
        $limit = Arr::get($searchParams, 'limit', 20);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if(!empty($keyword)) {
            $assuranceQuery->where('reference', 'LIKE', '%'. $keyword .'%');
        }

        return AssuranceResource::collection($assuranceQuery->paginate($limit));
    }

    public function userAssurances(Request $request)
    {
        $user = request()->user();
        $assurances = $user->assurances;

        return response()->json([
            'success'   => true,
            'assurances' => $assurances
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request()->user();
        $assurance = Assurance::create($request->all());

        return response()->json([
            'success'   => true,
            'assurances' => $user->assurances
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assurance  $assurance
     * @return \Illuminate\Http\Response
     */
    public function show(Assurance $assurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assurance  $assurance
     * @return \Illuminate\Http\Response
     */
    public function edit(Assurance $assurance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assurance  $assurance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assurance $assurance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assurance  $assurance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assurance $assurance)
    {
        //
    }
}
