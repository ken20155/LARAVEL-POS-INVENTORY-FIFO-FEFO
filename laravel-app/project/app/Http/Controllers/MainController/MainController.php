<?php

namespace App\Http\Controllers\MainController;


use App\Http\Controllers\Controller;
use App\Models\MainModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\Helpers;


class MainController extends Controller
{
    function __construct() {
        $this->model = new MainModel();
    }
    public function redirect(){
        return redirect('auth/view/sign-in');
    }
    public function getContent($params){
        //dd(Helpers::session());
        if (!Auth::check()) {
            return redirect('auth/view/sign-in');
        }
       
        $componentsController = 'defaultPage';
        $componentsClass = str_replace(' ', '', ucwords(str_replace('-', ' ', $params)));
        $componentsController = Str::of($componentsController)->camel();
        $componentsClassRender = "App\\Http\\Controllers\\Components\\$componentsClass\\$componentsClass";
        $componentsController = ''.$componentsController.'';
        if(method_exists($componentsClassRender, $componentsController)) {
            $data = app($componentsClassRender)->$componentsController($params);
            $customViewPath = app_path('Http/Controllers/Components/'.$componentsClass.'/views');
            View::addLocation($customViewPath);
            //$menu = Helpers::menu($params);
            // $menu_user_role = explode(',',$menu['selected_menu']->user_role);
            $session =  Helpers::session();
            // if (!in_array($session['session']['user_role'],$menu_user_role)) {
            //    return 'Unabled To Access';
            // }
            //dd($menu);
            $data['session'] = $session;
            //$data['sidebar'] = $menu['sidebar'];
            //$data['directory'] = $menu['get_menu_directory'];
            $data['title']  =  str_replace(' ', ' ', ucwords(str_replace('-', ' ', $params)));
            $data['params'] =  $params;//str_replace(' ', ' ', ucwords(str_replace('-', ' ', $params)));
            $data['content'] = view('content', $data)->render();
            $logo = $this->model->getRow('SELECT * FROM tbl_users WHERE user_id = ?',[1]);
            $data['logo'] = BASEURL.'public/main/uploaded/profile/'.$logo->folder.'/'.$logo->files;
            $content = [
                'page'          =>  $params,
                'start'         => '<!DOCTYPE html><html lang="en">',
                'header'        => view('app.partials.__header', $data),
                'sidebar'       => view('app.partials.__sidebar', $data),
                'topbar'        => view('app.partials.__topbar', $data),
                'body'          => view('app.partials.__content', $data),
                'footer'        => view('app.partials.__footer', $data),
                'settings'      => view('app.partials.__settings', $data),
                'footerlink'    => view('app.partials.__footerjs', $data),
                'end'           => '</html>',
            ];
            return view('app.app', $content);
        }else{ 
            return 'Page Not Exist';
        }
    }
    public function serveCustomJS($module){
        if (!Auth::check()) {
            return 'Unabled To Access';
        }
        $module = ucfirst(Str::camel($module));
        $defaultJS = [
            app_path("Http/Controllers/Components/{$module}/custom.js"),
        ];
        $customJS = [];
        $componentsClassRender = "App\\Http\\Controllers\\Components\\{$module}\\{$module}";
        if (method_exists($componentsClassRender, 'js')) {
            $customRender = app($componentsClassRender)->js();
            foreach ($customRender as $R) {
                $customJS[] = app_path("Http/Controllers/Components/{$module}/js/sample.js");
            }
        }
        $allJSFiles = array_merge($defaultJS, $customJS);
        $response = '';
        foreach ($allJSFiles as $jsFile) {
            if (File::exists($jsFile)) {
                $response .= file_get_contents($jsFile) . "\n";
            }
        }
        if (!empty($response)) {
            return response($response)->header('Content-Type', 'application/javascript');
        } else {
            return '';
        }
    }
    public function runComponentFunction($componentsClass,$componentsController){
        if (!Auth::check()) {
            abort(403, 'Unable To Access');
        }
        $componentsClass = str_replace(' ', '', ucwords(str_replace('-', ' ', $componentsClass)));
        $componentsController = Str::of($componentsController)->camel();
        $componentsClass = "App\\Http\\Controllers\\Components\\$componentsClass\\$componentsClass";
        $componentsController = ''.$componentsController.'';
        return method_exists($componentsClass, $componentsController) ? app($componentsClass)->$componentsController() : 'Page Not Exist';
    }
    public function getPublicPages($componentsClass){
        $componentsController = 'defaultPage';
        $componentsClass = str_replace(' ', '', ucwords(str_replace('-', ' ', $componentsClass)));
        $componentsController = Str::of($componentsController)->camel();
        $componentsClass = "App\\Http\\Controllers\\Publicpages\\$componentsClass\\$componentsClass";
        $componentsController = ''.$componentsController.'';
        return method_exists($componentsClass, $componentsController) ? app($componentsClass)->$componentsController() : 'Page Not Exist';
        //return $componentsClass;
    }
    public function getAuthForm($param = 'sign-in'){
        if (Auth::check()) {
            return redirect('component/view/dashboard');
        }
        if ($param === 'sign-in' || $param === 'sign-up' || $param === 'forgot-password') {
            $content['page'] = ucwords(str_replace('-', ' ', $param));
            $content['content'] = view('auth.'.$param.'.content',$content);
            return view('auth.template', $content);
        }else{
            return 'Page Not Exist';
        }
    }
    public function authFn($page){
        $componentsClassRender = "App\\Http\\Controllers\\AuthController\\AuthController";
        return method_exists($componentsClassRender, $page) ? app($componentsClassRender)->$page() : 'Page Not Exist';
    }

}
