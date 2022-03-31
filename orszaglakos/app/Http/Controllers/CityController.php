<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\StorecityRequest;
use App\Http\Requests\UpdatecityRequest;
use Error;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["varosok" => City::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecityRequest $request)
    {
        try {
            City::where("nev", $request["nev"])->firstOrFail();
            return response()->json(["error" => "City already exist!"], 409);
        } catch (ModelNotFoundException $e) {
            $city = new City($request->only(["nev", "orszag", "lakossag"]));
            $city->save();
        } catch (Exception | Error $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function show(int $city)
    {
        try {
            $result = City::findOrFail($city);
            return response()->json($result, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "City not found!"], 403);
        } catch (Exception | Error $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecityRequest  $request
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecityRequest $request, int $city)
    {
        try {
            $city = City::findOrFail($city);
            try {
                City::where("nev", $request["nev"])->firstOrFail();
                return response()->json(["error" => "City already exist!"], 409);
            } catch (ModelNotFoundException $e) {
                $city->fill($request->only(["nev", "orszag", "lakossag"]));
                $city->save();
                return response()->json($city, 204);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "City not found!"], 403);
        } catch (Exception | Error $e) {
            return response()->json(["error" => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $city)
    {
        try {
            $city = City::findOrFail($city);
            $city->delete();
            return response()->json($city, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "City not found!"], 403);
        } catch (Exception | Error $e) {
            return response()->json(["error" => $e], 500);
        }
    }
}
