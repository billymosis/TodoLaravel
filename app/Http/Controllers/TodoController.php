<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return DB::table('todos')->orderBy('updated_at', 'desc')->get();
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
        return Todo::create($request->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);

        return $todo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());
        $todo = Todo::findOrFail($id);
        return $todo;
    }

    public function date(Request $request)
    {
        $data = $request->all();
        $lastSync = date($data['lastSync']);
        $now = date(now());
        $id = DB::table('todos')->where('updated_at', '>=', $lastSync)->get();
        return $id;
    }

    public function sync(Request $request)
    {
        $data = $request->all();
        $localLastSync = date($data['lastSync']);
        // $now = date(now());
        // $newrecords = DB::table('todos')->where('updated_at', '>=', $lastSync)->get();

        $created = collect();
        foreach ($data['created'] as $item) {
            $created->push([
                'id' => $item['id'],
                'title' =>  $item['title'],
                'done' => $item['done'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }
        DB::table('todos')
            ->upsert($created->toArray(), ['id'], ['title', 'done', 'created_at', 'updated_at']);

        $updated = collect();
        foreach ($data['updated'] as $item) {
            $updated->push([
                'id' => $item['id'],
                'title' =>  $item['title'],
                'done' => $item['done'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }
        DB::table('todos')
            ->upsert($updated->toArray(), ['id'], ['title', 'done', 'created_at', 'updated_at']);

        $deleted = $data['deleted'];
        Todo::destroy($deleted);

        if ($localLastSync == 'never') {
            $newrecords = DB::table('todos')->get();
        } else {
            $newrecords = DB::table('todos')->where('updated_at', '>=', $localLastSync)->get();
        }


        $id = Auth::id();
        $user = User::where('id', $id)->first();
        $user->last_sync = now('utc');
        $user->save();

        return response([
            'lastSync' => now('utc'),
            'newRecords' => $newrecords]);
    }

    public function merge(Request $request)
    {

        $data = collect();
        foreach ($request->all() as $item) {
            $data->push([
                'id' => $item['id'],
                'title' =>  $item['title'],
                'done' => $item['done'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ]);
        }

        DB::table('todos')
            ->upsert($data->toArray(), ['id'], ['title', 'done', 'created_at', 'updated_at']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return $id;
    }

    public function destroyAll()
    {
        Todo::truncate();
        return 'deleted';
    }
}
