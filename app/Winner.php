<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Winner extends Model
{
    //
	
	protected $fillable = [
		'user', 'number', 'prize', 'drawno', 
	];
	
	static public function findDrawNo ($drawno) {
		return DB::table('winners')->where('drawno', $drawno)->orderBy('prize')->orderBy('user')->get();
	}
	
	static public function prize_is_picked($drawno, $prize) {
		return DB::table('winners')->where('drawno', $drawno)->where('prize', $prize)->count();
	}
	
	static public function number_is_picked($drawno, $number) {
		return 0 != DB::table('winners')->where('drawno', $drawno)->where('number', $number)->count();
	}
	
	static public function check_number_owner($drawno, $number) {
		return DB::table('winners')
					->where('drawno', $drawno)
					->whereExists(function($query) use ($drawno, $number) {
						$query->select(['user'])->from('winning_numbers')->where('drawno', $drawno)->where('number', $number)->whereRaw('winning_numbers.user = winners.user');
					})
					->limit(1)
					->get();
	}
}
