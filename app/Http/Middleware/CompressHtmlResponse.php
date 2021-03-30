<?php

namespace App\Http\Middleware;

use Closure;

class CompressHtmlResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
		
		// HTML Minification
		if(\App::Environment() != 'local')
		{
			//dd($response);
			if($response instanceof \Illuminate\Http\Response)
			{
				$output = $response->getOriginalContent();
				
				$filters = array(
					'/<!--(.*?)-->/'			=> '', 	// Remove HTML Comments (breaks with HTML5 Boilerplate)
					'/(?<!\S)\/\/\s*[^\r\n]*/'	=> '', 	// Remove comments in the form /* */
					'/\s{2,}/'					=> ' ', // Shorten multiple white spaces
					'/(\r?\n)/'					=> '', 	// Collapse new lines
					'/\>\s{1,}\</'				=> '><',
				);
				
				$output = preg_replace(array_keys($filters), array_values($filters), $output);
				$response->setContent($output);
			}
		}
		
		return $response;
    }
}
