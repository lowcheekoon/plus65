<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

use App\Winning_number;
use App\Winner;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		Schema::defaultStringLength(191);
		
		$this->draw_validation();
    }
	
	private function draw_validation() {
		Validator::extend('is_picked', function ($attribute, $value, $parameters, $validator) {
			
			if(empty($parameters)) {
				$validator->errors()->add($attribute, 'Missing Parameter (drawno)');
				return false;
			}
			$drawno = $parameters[0];
			
			if($attribute=='prizeTypes' && Winner::prize_is_picked($drawno, $value)) {
				$validator->errors()->add($attribute, 'This prize is already draw');
				return false;
			}
			
			if($attribute=='winningNumber') {
				if(Winner::number_is_picked($drawno, $value)) {
					$validator->errors()->add($attribute, 'This winning number is already draw');
					return false;
				}
				
				if($winner = Winner::check_number_owner($drawno, $value)) {
					if($winner->count()) {
						$validator->errors()->add($attribute, 'This winning number is owned by ' . $winner[0]->user . ', He is winner');
						return false;
					}
				}
			}
		
            return true;
        });
		
		Validator::extend('winning_number_exist', function ($attribute, $value, $parameters, $validator) {
			
			if(empty($parameters)) {
				$validator->errors()->add($attribute, 'Missing Parameter (drawno)');
				return false;
			}
			$drawno = $parameters[0];
			
			if($attribute=='winningNumber') {
				if($winning_number = Winning_number::number_exist($drawno, $value)) {
					if(!$winning_number->count()) {
						$validator->errors()->add($attribute, 'This winning number is not exist');
						return false;
					}
				}
			}
		
            return true;
        });
	}
}
