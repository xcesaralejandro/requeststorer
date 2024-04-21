<?php
namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class StoreOnArrival
{
    private $nullify_fields = [];

    public function handle($request, Closure $next, ...$nullify_fields){
        $this->nullify_fields = $nullify_fields;
        $route = explode('@', Route::currentRouteAction());
        list($controller, $action) = count($route) == 2 ? $route : [null, null];
        $store = [
            'user_id' =>  $request->user()->id ?? null,
            'route_name' => Route::currentRouteName(),
            'controller' => class_basename($controller),
            'header_referer' => $request->headers->get('referer'),
            'sec_ch_ua' => $request->headers->get('sec_ch_ua'),
            'sec_ch_ua_mobile' => $request->headers->get('sec_ch_ua_mobile'),
            'sec_ch_ua_platform' => $request->headers->get('sec_ch_ua_platform'),
            'sec_ch_ua_mode' => $request->headers->get('sec-fetch-mode'),
            'x-forwarded-for' => $request->headers->get('x-forwarded-for'),
            'x-forwarded-host' => $request->headers->get('x-forwarded-host'),
            'x-real-ip' => $request->headers->get('x-real-ip'),
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
            'stored_on' => "arrival",
            'send_at' => $request->server('REQUEST_TIME'),
            'created_at' => Carbon::now()
        ];
        $this->nullifyFields($store);
        DB::table('requests')->insert($store);
        return $next($request);
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
