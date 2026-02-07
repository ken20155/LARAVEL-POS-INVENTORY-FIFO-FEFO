<?php
namespace App\Http\Controllers\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\MainModel;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Request;
use Carbon\Carbon;
use Faker\Factory as Faker;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Helpers {
    public static $ap = 'Some value';
    function __construct() {
        $this->model = new MainModel();
    }
    public static function postr() {
        return Request::post();
    }
    public static function getr() {
        return Request::get();
    }
    public static function allr() {
        return Request::all();
    }
    public static function last_segment() {
        return Request::segment(count(Request::segments()));
    }
    public static function getView($params){
        $customViewPath = app_path('Http/Controllers/Components/'.$params.'/views');
        View::addLocation($customViewPath);
    }
    
    public static function status_badge($txt,$status = 'primary') {
        return '<div class="badge badge-'.$status.'">'.$txt.'</div>';
    }
    public static function session() {
        $session = Session::all();
        $users = (new self())->model->getRow('SELECT * FROM tbl_users where `user_id` = ?',[$session['session']['user_id']],null);
        return [
            'session'=>$session['session'],
            'user_details'=>$users
        ];
    }
    public static function addBrAfterWords($text, $lettersPerLine = 50) {
        // Split text into chunks of $lettersPerLine characters
        $chunks = str_split($text, $lettersPerLine);
        
        // Join the chunks with <br>
        return implode('<br>', $chunks);
    }
    public static function menu($params){
        $user_role = Self::session()['session']['user_role'];
        $data = (new self())->model->getResults("SELECT * FROM tbl_menu where `status` = 1 and  find_in_set('".$user_role."', user_role) order by lvl,sort asc");
        $menu_items = [];
        foreach ($data as $R) {
            $menu_items[] = [
                                'is_nav_item'   => $R->is_nav_item,
                                'is_module'     => $R->is_module,
                                'lvl'           => $R->lvl,
                                'order'         => $R->sort,
                                'primary_id'    => $R->menu_id,
                                'master'        => $R->master,
                                'title'         => $R->title,
                                'icon'          => $R->icon,
                                'url'           => $R->url,
                                'user_role'     => $R->user_role,
                            ];
        }
        $selected_menu = (new self())->model->getRow('SELECT * FROM tbl_menu where `url` = ?',[$params],null);
        return [
            'selected_menu'         => $selected_menu,
            'get_menu_directory'    => false,//Self::getMenuDirectory($selected_menu->menu_id),
            'sidebar'               => Self::generateSidebar($menu_items),
        ];
    }
    public static function generateSidebar($menu_items, $master = 0) {
        $html = '';
        $subMenuItems = array_filter($menu_items, function($item) use ($master) {
            return $item['master'] == $master;
        });

        foreach ($subMenuItems as $item) {
            if ($item['lvl'] == 0) {
                $nav_item = 'nav-item';
                $second_menu = '';
            }else{
                $nav_item = '';
                $second_menu = 'second-menu';
            }
            if ($item['is_nav_item'] == 1 && $item['is_module'] == 1) {
                // Scenario 1: is_nav_item is 1 and is_module is 1
                $span_item = $item['lvl'] == 0 ? '<p>' . $item['title'] . '</p>' : '<span>' . $item['title'] . '</span>';
                $html .= '<li class="'.$nav_item.'" id="li-'.$item['primary_id'].'">';
                $html .= '<a href="' . $item['url'] . '" data-id="'.$item['primary_id'].'" data-father="'.$item['master'].'" class="' . $item['url'] . '">';
                $html .= $item['icon'] != '' ? $item['icon'] : '<i class="fas fa-bars"></i>';
                $html .= $span_item;
                $html .= '</a>';
                $html .= '</li>';
            } elseif ($item['is_nav_item'] == 0 && $item['is_module'] == 0) {
                // Scenario 2: is_nav_item is 0 and is_module is 0
                $html .= '<li class="nav-section">';
                $html .= '<span class="sidebar-mini-icon">';
                $html .= '<i class="fa fa-ellipsis-h"></i>';
                $html .= '</span>';
                $html .= '<h4 class="text-section">' . $item['title'] . '</h4>';
                $html .= '</li>';
            } elseif ($item['is_nav_item'] == 1 && $item['is_module'] == 0) {
                // Scenario 3: is_nav_item is 1 and is_module is 0
                $hasSubItems = count(array_filter($menu_items, function($subItem) use ($item) {
                    return $subItem['master'] == $item['primary_id'];
                })) > 0;

                $html .= '<li class="'.$nav_item.'" id="li-'.$item['primary_id'].'" data-id="'.$item['primary_id'].'" data-father="'.$item['master'].'">';
                if ($hasSubItems) {
                    $html .= '<a data-bs-toggle="collapse" href="#submenu-' . $item['primary_id'] . '">';
                    $html .= $item['icon'] != '' ? $item['icon'] : '<i class="fas fa-bars"></i>';
                    $html .= '<p class="'.$second_menu.'" style="">' . $item['title'] . '</p>';
                    $html .= '<span class="caret"></span>';
                    $html .= '</a>';
                    $html .= '<div class="collapse" id="submenu-' . $item['primary_id'] . '">';
                    $html .= '<ul class="nav nav-collapse">';
                    $html .= self::generateSidebar($menu_items, $item['primary_id']);
                    $html .= '</ul>';
                    $html .= '</div>';
                } else {
                    $html .= '<a href="' . $item['url'] . '">';
                    $html .= $item['icon'] != '' ? $item['icon'] : '<i class="fas fa-bars"></i>';
                    $html .= '<p>' . $item['title'] . '</p>';
                    $html .= '</a>';
                }
                $html .= '</li>';
            }
        }

        return $html;
    }
    public static function getMenuDirectory($menu_id){
 

        $moduleInfo = Self::getModuleInfo($menu_id);

        $master = $moduleInfo->master;

        $data[] = [
            'label' => $moduleInfo->title,
            'data' => $moduleInfo
        ];

        while ($master != 0) {
            $moduleInfo = Self::getModuleInfo($master);
            $master = $moduleInfo->master;
            $data[] = [
                'label' => $moduleInfo->title,
                'data' => $moduleInfo
            ];
        }

        $data = array_reverse($data);
 
        return $data;
    }
    public static function getModuleInfo($menu_id) {
        return (new self())->model->getRow('SELECT * FROM tbl_menu where `menu_id` = ?',[$menu_id],null);
    }
    public static function validateData($validator){
        if (isset($validator['validator']) && !empty($validator['validator'])) {
            $json_converted = is_array($validator['validator']) ? $validator['validator'] : json_decode($validator['validator'],true);
            foreach ($json_converted as $field => $R) {
                $array[$field] =  $R;
            } 
            return Self::validateRecords($validator,$array);
        }
        return false;
    }
    private static function validateRecords($data, $fieldRules=[]) {
        $rules = Self::generateValidationRules($data, $fieldRules);
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Response::json([
                'msg' => false,
                'status' => 'error',
                'errors' => $validator->errors()
            ]); // Unprocessable Entity
        }
        return false;
    }
    private static function generateValidationRules($data, $fieldRules){
        $rules = [];
        foreach ($fieldRules as $fieldName => $rule) {
            $rules[$fieldName] = $rule;
        }
        return $rules;
    }
    public static function generateDataTable($data){
        $dataTable = DataTables::of($data);
        if (!empty($data)) {
            $columns = array_keys(reset($data));
            $dataTable->rawColumns($columns);
        }
        return $dataTable->make(true);
    }
    public static function post(){
        return Request::post();
    }
    public static function emailSender($data){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                           //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');           //SMTP username
            $mail->Password   = env('MAIL_PASSWORD');                    //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('PROJECTTITLE'));
            $mail->addAddress($data['to_email'], $data['to_full_name']); 
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['msg'];
        
            $mail->send();
            return [
                'success' => true
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'msg' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
            ];
        }
    }
    public static function timeFormat($data) {
        $time = Carbon::createFromTimeString($data);
        return $time->format('g:i A');
    }
    public static function generateRandomNames($num){
        $faker = Faker::create();
        $names = [];

        for ($i = 0; $i < $num; $i++) {
            $names[] = $faker->name;
        }

        return $names;
    }
    public static function smsSender($data){
        if (env('OTP')) {
            $client = new Client();
            $limit_balance = 50;
            $get_balance = (float) str_replace(['₱', ','], '', Self::smsGetBalance());
            if ($get_balance <= $limit_balance) {
                return [
                    'success' => false,
                    'msg' => 'No Enough Balance On Text. Please contact Admin!',
                ];
            }
            $prefixed_numbers = array_map(function($number) {
                return '63' . substr($number, 1);
            }, $data['text_to']);
            $send_data = [
                'sender_id' => 'PhilSMS', //PhilSMS
                'recipient' => implode(',', $prefixed_numbers), 
                'message' => $data['your_msg']
            ];
            $token = "989|mbEU8xWXanelE3K94iiHU44cXe7iFG960LZQQw9o";
            $response = $client->post('https://app.philsms.com/api/v3/sms/send', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
                'json' => $send_data,
                'verify' => false,
            ]);
            $get_sms_status = $response->getBody()->getContents();
            return [
                'success' => true,
                'msg' => 'Msg Sent',
            ];
        }else{
            return [
                'success' => true,
                'msg' => 'By Passed',
            ];
        }
        
        //ken123123
        //kEnext123123123123@@123
        //09958513927
        //09361776112
        //https://app.philsms.com/dashboard
        //https://app.philsms.com/developers
        //https://app.philsms.com/developers/docs
    }
    public static function strRandom($num) {
        return Str::random($num);
    }
    public static function getDir($module, $folder = false) {
        $path = str_replace('project\\', '', public_path('main/uploaded/'.$module));
        if (!File::exists($path)) {
            File::makeDirectory($path);
        }
        if ($folder) {
            $folder = str_replace('project\\', '', public_path('main/uploaded/'.$module . '/' . $folder));
            if (!File::exists($folder)) {
                File::makeDirectory($folder);
            }
        } else {
            $folder = $path;
        }
        return $folder;
    }
    public static function smsGetBalance(){
        $client = new Client();
        $token = "989|mbEU8xWXanelE3K94iiHU44cXe7iFG960LZQQw9o";
        $response = $client->get('https://app.philsms.com/api/v3/balance', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token"
            ],
            'verify' => false,
        ]);
        $get_sms_status = $response->getBody()->getContents();
        $data = json_decode($get_sms_status,true);
        return $data['data']['remaining_balance'];
    }
    public static function generateNumber($num) {
        $min = pow(10, $num - 1);
        $max = pow(10, $num) - 1;
        return rand($min, $max);
    }
}
