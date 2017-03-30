<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Foundation\Application;

class Debug
{

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $debug = \DB::listen(function($sql, $bindings, $time) {
//            echo ('SQL语句执行：'.$sql.'，参数：'.json_encode($bindings).',耗时：'.$time.'ms');
//        });
//        $debug2 = \Event::listen('illuminate.query', function ($query) {
//            \Log::debug($query);
//        });
        \DB::enableQueryLog();
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Store or dump the log data...
//        \Log::debug(
//            \DB::getQueryLog()
//        );
//        \Log::debug($request->all());
        $queryLog = \DB::getQueryLog();
        if ($queryLog){
            foreach ($queryLog as $logs){
                $logs['route'] = $request->path();
                $logs['created_at'] = date('Y-m-d H:i:s');
                $logs['bindings'] = isset($logs['bindings']) ? implode(',',$logs['bindings']) : '';
                \DB::table('log_db')->insert($logs);
            }
        }
    }
}
