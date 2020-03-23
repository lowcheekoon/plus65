<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Winning_number extends Model
{
    //
	protected $fillable = [
		'drawno', 'user', 'number',
	];
	
	static public function randomPickMost($drawno) {
	
		$mostPick = DB::table('winning_numbers')
						->select(DB::raw('user, count(*) as cnt'))
						->where('drawno', $drawno)
						->whereNotExists(function($query) use ($drawno) {
							$query->select(['user'])->from('winners')->where('drawno', $drawno)->whereRaw('winners.user = winning_numbers.user');
						})
						->groupBy('user')
						->pluck('cnt', 'user');

		if($mostPick->count()) {
			$max = $mostPick->max();
			$mostPick = $mostPick->filter(function ($value, $key) use ($max) {
				return $value == $max;
			});
			
			$picked = DB::table('winning_numbers')
						->select(['user','number'])
						->where('drawno', $drawno)
						->where('user', array_rand($mostPick->toArray(), 1))
						->whereNotExists(function($query) use ($drawno) {
							$query->select(['number'])->from('winners')->where('drawno', $drawno)->whereRaw('winners.number = winning_numbers.number');
						})
						->inRandomOrder()
						->limit(1)
						->get();
			
			if($picked->count()) {
				return $picked[0];
			}
		}
		
		return [];
	}
	
	static public function randomPick($drawno, $number = '') {
		
		$picked = DB::table('winning_numbers')
						->select(['user','number'])
						->where('drawno', $drawno)
						->whereNotExists(function($query) use ($drawno) {
							$query->select(['user'])->from('winners')->where('drawno', $drawno)->whereRaw('winners.user = winning_numbers.user');
						})
						->whereNotExists(function($query) use ($drawno) {
							$query->select(['number'])->from('winners')->where('drawno', $drawno)->whereRaw('winners.number = winning_numbers.number');
						})
						->where(function($query) use ($number) {
							if($number) {
								$query->where('number', $number);
							}
						})
						->inRandomOrder()
						->limit(1)
						->get();
						
		if($picked->count()) {
			return $picked[0];
		}
		
		return [];
	}
	
	static public function number_exist($drawno, $number) {
		return DB::table('winning_numbers')
					->where('drawno', $drawno)
					->where('number', $number)
					->limit(1)
					->get();
	}
}
