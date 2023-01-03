<?php
namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class StoreOnResponse
{
    private $nullify_fields = [];

    public function handle($request, Closure $next, ...$nullify_fields){
        $this->nullify_fields = $nullify_fields;
        return $next($request);
    }

    public function terminate($request, $response){
        list($controller, $action) = explode('@', Route::currentRouteAction());
        $store = [
            'user_id' =>  $request->user()->id ?? null,
            'route_name' => Route::currentRouteName(),
            'controller' => class_basename($controller),
            'action' => $action,
            'method' => $request->getMethod(),
            'path_info' => $request->getPathInfo(),
            'uri' => $request->getRequestUri(),
            'query_string' => $request->server('QUERY_STRING'),
            'is_secure' => $request->isSecure(),
            'is_ajax' => $request->ajax(),
            'client_ip' => $request->getClientIp(),
            'client_port' => $request->server('REMOTE_PORT'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'referer' => $request->server('HTTP_REFERER'),
            'server_protocol' => $request->server('SERVER_PROTOCOL'),
            'params' => json_encode($request->all()),
            'content' => $request->getContent(),
            'http_response_code' => $response->status(),
            'stored_on' => "response",
            'send_at' => $request->server('REQUEST_TIME'),
            'created_at' => Carbon::now()
        ];
        $this->nullifyFields($store);
        DB::table('requests')->insert($store);
    }

    private function nullifyFields(array &$request){
        foreach($this->nullify_fields as $field){
            $clean = fn($f) => strtolower(str_replace(":class:", "", strtolower($f)));
            $field = $clean($field);
            if(isset($request[$field])){
                $request[$field] = null;
            }
        }
    }
}
