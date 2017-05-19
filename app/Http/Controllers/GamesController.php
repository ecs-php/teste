<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Validator;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::get();
        return response()->json($games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $game = new Game();
        $game->fill($request->all());
        $game->save();

        return response()->json($game, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message'   => 'Game not found'
            ], 404);
        }

        return response()->json($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ], 404);
        }

        $game->fill($request->all());
        $game->save();

        return response()->json($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message'   => 'Game not found'
            ], 404);
        }

        $game->delete();
    }

    private function validator($request)
    {
        $data = $request->all();
        return Validator::make($data, [
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:20|max:200',
            'release_date' => 'required|date',
            'price' => 'required|numeric'
        ]);
    }
}
