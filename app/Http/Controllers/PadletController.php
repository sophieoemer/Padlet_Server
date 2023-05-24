<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use App\Models\Padlet;
use App\Models\Entry;
use App\Models\User;

class PadletController extends Controller
{

    public function index(): JsonResponse
    {
        $padlets = Padlet::with(['users', 'entries'])
            ->get();
        return response()->json($padlets, 200);
    }

    public function findById(int $id): JsonResponse
    {
        $padlet = Padlet::where('id', $id)
            ->with(['users', 'entries'])->first();
        return $padlet != null ? response()->json($padlet, 200) : response()->json(null, 200);

    }
    public function checkid(string $id) {
        $padlet = Padlet::where('id', $id)->first();
        return $padlet != null ? response()->json(true, 200) : response()->json(false, 200);
    }
    public function findBySearchTerm(string $searchTerm): JsonResponse {
        $padlets = Padlet::with(['users', 'entries'])
            ->where('name', 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('ispublic' , 'LIKE', '%' . $searchTerm. '%')
            ->get();
        return response()->json($padlets, 200);
    }

    public function save(Request $request) : JsonResponse {
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            $padlet = Padlet::create($request->all());
            if (isset($request['entries']) && is_array($request['entries'])) {
                foreach ($request['entries'] as $entr) {
                    $entry =
                        Entry::create(['textEntry'=>$entr['textEntry'], 'padlet_id'=>$padlet->id]);
                    //$padlet->entries()->save($entry);
                }
            }
            if (isset($request['users']) && is_array($request['users'])) {
                foreach ($request['users'] as $usr) {
                    $user = User:: findOrFail ($usr['id']);
                    $padlet->users()->save($user);
                }
            }
            DB::commit();
// return a vaild http response
            return response()->json($padlet, 201);
        }
        catch (\Exception $e) {
// rollback all queries
            DB::rollBack();
            return response()->json("saving book failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }

    //Update

    public function update(Request $request, int $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $padlet = Padlet::with(['users', 'entries'])
                ->where('id', $id)->first();
            if ($padlet != null) {
                $request = $this->parseRequest($request);
                $padlet->update($request->all());

                if (isset($request['entries']) && is_array($request['entries'])) {
                    foreach ($request['entries'] as $entr) {
                        $entry =
                            Entry::firstOrNew(['textEntry'=>$entr['textEntry']]);
                        $padlet->entries()->save($entry);
                    }
                }
                //update Users
                $ids = [];
                if (isset($request['users']) && is_array($request['users'])) {
                    foreach ($request['users'] as $usr) {
                        array_push($ids,$usr['id']);
                    }
                }
                $padlet->users()->sync($ids);
                $padlet->save();
            }
            DB::commit();
            $padlet1 = Padlet::with(['users', 'entries'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($padlet1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating padlet failed: " . $e->getMessage(), 420);
        }
    }
    public function delete(int $id) : JsonResponse {
        $padlet = Padlet::where('id', $id)->first();
        if ($padlet != null) {
            $padlet->delete();
            return response()->json('padlet (' . $id . ') successfully deleted', 200);
        }
        else
            return response()->json('padlet could not be deleted - it does not exist', 422);
    }
}







