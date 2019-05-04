<?php

namespace App\Http\Controllers;

use App\Cycle;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    public function attachCycle($id){
        try {
            $user = User::find(Auth::user()->id);
            
            if (count($user->unpaidCycles) > 0) throw new \Exception("You've already appointed a cycle.");

            $cycle = Cycle::find($id);
            
            if (!$cycle) throw new \Exception("Invalid Cycle ID.");

            $users = $cycle->users;

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

    public function getBill($id){
        $cycle = Cycle::find($id);

        $user = $cycle->users()->first();

        if (!$user) {
            return response([
                "message" => "This cycle is not appointed to anyone."
            ], 400);
        }

        $user->pivot->touch();

        if ($user->id == Auth::user()->id){
            $mins = ($user->pivot->updated_at->timestamp - $user->pivot->created_at->timestamp) / 60;
            $billAmount = round($mins * floatval(env('PPM')),2);

            return [
                "message" => "Your fare amount is Rs. $billAmount.",
                "amount" => $billAmount
            ];
        } else {
            return response([
                "message" => "You are not appointed to this cycle."
            ], 400);
        }
    }
    // public function payForCycle($id, Request $request){
    //     if ($request->input('master_password') == env('MASTER_PASSWORD')){
    //         $cycle = Cycle::find($id);

    //         $user = $cycle->users()->first();

    //         if (!$user) {
    //             return response([
    //                 "message" => "This cycle is not appointed to anyone."
    //             ], 400);
    //         }

    //         $user->pivot->touch();

    //         if ($user->id == Auth::user()->id){
    //             $mins = ($user->pivot->updated_at->timestamp - $user->pivot->created_at->timestamp) / 60;
    //             $billAmount = round($mins * floatval(env('PPM')),2);

    //             $user->pivot->paid = 1;
    //             $user->pivot->save();

    //             return [
    //                 "message" => "Account was set to paid.",
    //                 "amount" => $billAmount
    //             ];
    //         } else {
    //             return response([
    //                 "message" => "You are not appointed to this cycle."
    //             ], 400);
    //         }
    //     } else {
    //         return response([
    //             "message" => "Master password did not match."
    //         ], 400);
    //     }
    // }
}
