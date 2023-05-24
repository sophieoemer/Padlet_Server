<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use App\Models\Entry;
use App\Models\Rating;
use App\Models\User;

class EntryController extends Controller
{

    public function index(): JsonResponse
    {
        $entries = Entry::with(['ratings'])->get();
        return response()->json($entries, 200);
    }

    public function findById(int $id) : JsonResponse {
        $entry = Entry::where('id', $id)
            ->with(['ratings'])->first();
        return $entry != null ? response()->json($entry, 200) : response()->json(null, 200);
    }

    public function checkId(int $id) {
        $entry = Entry::where('id', $id)->first();
        return $entry != null ? response()->json(true, 200) : response()->json(false, 200);
    }

    public function findBySearchTerm(string $searchTerm): JsonResponse {
        $entries = Entry::with(['ratings'])
            ->where('text', 'LIKE', '%' . $searchTerm. '%')
            ->get();
        return response()->json($entries, 200);
    }


    public function save(Request $request) : JsonResponse {
        DB::beginTransaction();
        try {
            $entry = Entry::create($request->all());
            // save ratings
            if (isset($request['ratings']) && is_array($request['ratings'])) {
                foreach ($request['ratings'] as $rati) {
                    $rating =
                        Rating::create(['rating'=>$rati['rating'], 'comment'=>$rati['comment'],
                            'username'=>$rati['username'], 'entry_id'=>$entry->id]);
                    $entry->ratings()->save($rating); // evtl. ändern - auskommentieren
                }
            }
            DB::commit();
            // return a vaild http response
            return response()->json($entry, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving entry failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request) : Request {
        // get date and convert it - its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }


    public function update(Request $request, int $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $entry = Entry::with(['ratings'])
                ->where('id', $id)->first();
            if ($entry != null) {
                //$request = $this->parseRequest($request);
                $entry->update($request->all());
                //delete all old ratings
                //$entry->ratings()->delete();
                // save ratings
                if (isset($request['ratings']) && is_array($request['ratings'])) {
                    foreach ($request['ratings'] as $rati) {
                        $rating =
                            Rating::firstOrNew(['rating'=>$rati['rating'], 'comment'=>$rati['comment'],
                                'username'=>$rati['username'], 'entry_id'=>$entry->id]);
                        $entry->ratings()->save($rating);
                    }
                }
                $entry->save();
            }
            DB::commit();
            $entry1 = Entry::with(['ratings'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($entry1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating padlet failed: " . $e->getMessage(), 420);
        }
    }


    public function delete(int $id) : JsonResponse {
        $entry = Entry::where('id', $id)->first();
        if ($entry != null) {
            $entry->delete();
            return response()->json('entry (' . $id . ') successfully deleted', 200);
        }
        else
            return response()->json('entry could not be deleted - it does not exist', 422);
    }

}
