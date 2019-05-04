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

        if ($user->id == Auth::user()->id){

            $user->pivot->touch();

            $user->pivot->billed = 1;

            $mins = ($user->pivot->updated_at->timestamp - $user->pivot->created_at->timestamp) / 60;
                        
            $billAmount = round($mins * floatval(env('PPM')),2);

            $user->pivot->bill_amount = $billAmount;

            $user->pivot->save();
            
            return [
                "message" => "Your fare amount is Rs. $billAmount.",
                "amount" => $billAmount,
                "cycle_id" => $id
            ];
        } else {
            return response([
                "message" => "You are not appointed to this cycle."
            ], 400);
        }
    }

    public function payBill($id){
        $cycle = Cycle::find($id);

        $user = $cycle->users()->first();

        if (!$user) {
            return response([
                "message" => "This cycle is not appointed to anyone."
            ], 400);
        }

        if ($user->id == Auth::user()->id) {

            if ($user->pivot->billed == 0){
                return response([
                    "message" => "You have not been billed yet."
                ], 400);
            }

            if ($user->credit < $user->pivot->bill_amount){
                return response([
                    "message" => "You do not have sufficient credits."
                ], 400);
            }

            $user->credit -= $user->pivot->bill_amount;
            $user->save();

            $user->pivot->paid = 1;
            $user->pivot->save();

            return [
                "message" => "You have successfully paid Rs. ".$user->pivot->bill_amount." for your fare.",
            ];
        } else {
            return response([
                "message" => "You are not appointed to this cycle."
            ], 400);
        }
    }
    

}
