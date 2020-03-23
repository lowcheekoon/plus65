<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Winning_number;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
	
	public function draw(Request $request)
    {
        $this->validate($request, [
            'user'   => 'required',
            'winningNumber' => 'required|digits:4',
        ]);
		
		$winning_number = Winning_number::create([
            'drawno' => date('Ymd'),
            'user' => $request['user'],
            'number' => $request['winningNumber'],
        ]);
		
		return redirect()->back()->with('status', 'Lucky Draw Added!');
    }
}
