<?php

namespace App\Http\Controllers;

use App\Cycle;

class CycleController extends Controller
{
    public function attachCycle($id){
        try {
            $cycle = Cycle::find($id);
            
            if (!$cycle) throw new \Exception("Invalid Cycle ID.");

            $users = $cycle->users->wherePivot([
                'paid' => 0
            ]);

            if (count($users) > 0) throw new \Exception("This cycle is already appointed to someone.");

            $cycle->users()->attach(Auth::user()->id);

            return [
                "message" => "Cycle $id is now appointed to you."
            ];
        } catch(\Exception $e){
            return response([
                "message" => $e->getMessage()
            ], 400);
        }
    }
}
