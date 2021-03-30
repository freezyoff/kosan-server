<?php

namespace App\Kosan\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
		
		Blade::directive('htmlId', function ($key) {
            return "<?php echo \Str::htmlId($key); ?>";
        });
		
		Blade::directive('jsVar', function ($key) {
			return "<?php echo \Str::jsVar($key); ?>";
        });
		
		Blade::directive('mix', function($expression){
			return "<?php echo mix(\"".$expression."\"); ?>";
		});
	}
}
