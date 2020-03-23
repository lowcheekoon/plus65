<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Winning_number;
use App\Winner;

class AdminHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$drawno = date('Ymd');
		$winners = Winner::findDrawNo($drawno);
		$results = [];
		if($winners) {
			foreach($winners as $winner) {
				$results[$winner->prize] = $winner->user . " (".$winner->number.")";
			}
		}
        return view('admin.home', ['results' => $results]);
    }
	
	public function draw(Request $request) 
	{
		$drawno = date('Ymd');
		
		$this->validate($request, [
            'prizeTypes'   => 'required|in:1,2,3,4,5,6|is_picked:'.$drawno,
            'randomly' => 'required|in:yes,no',
            'winningNumber' => 'nullable|required_if:randomly,no|digits:4|winning_number_exist:'.$drawno.'|is_picked:'.$drawno,
        ]);
		
		
		if($request->randomly == 'yes'){
			$picked = $request->prizeTypes == "1" ? Winning_number::randomPickMost($drawno) : Winning_number::randomPick($drawno);
		} else {
			$picked = Winning_number::randomPick($drawno, $request['winningNumber']);
		}
		
		if($picked) {
			$winner = Winner::create([
				'user' => $picked->user,
				'number' => $picked->number,
				'prize' => $request['prizeTypes'],
				'drawno' => $drawno,
			]);
			
			return redirect()->back()->with('status', '#Winner: ' . $picked->user . '#Number: ' . $picked->number);
		} else {
			return redirect()->back()->withError('No Winner!');
		}
		
	}
}
