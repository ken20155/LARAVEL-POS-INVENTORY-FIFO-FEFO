<?php 
namespace App\Http\Controllers\Components\UsersAccount;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Support\Facades\Hash;
class UsersAccount 
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        Helpers::getView('UsersAccount');
    }
    public static function js(){
        return [
            'js/sample'
        ];
    }
    public function defaultPage($params){
        $data = [];
        return [
            'test' => 'ken'
        ];
    }
    public function viewDataUser(){
        $post = Helpers::post();
        extract($post);
        $sql = 'SELECT * FROM tbl_users WHERE user_id = ?';
        $param = [$id];
        $row =  $this->model->getRow($sql, $param);
        $d['data'] = $row;
        return [
            'action' => 'Edit',
            'body' =>  view('modal-content.view', $d)->render(),
            'footer' =>  '<button type="submit" class="btn btn-primary btn-sm">Save</button>',
        ];
    }
    public function addNewUser(){
        $post = Helpers::post();
        extract($post);
        $d['data'] = false;
        return [
            'action' => 'Add New',
            'body' =>  view('modal-content.view', $d)->render(),
            'footer' =>  '<button type="submit" class="btn btn-primary btn-sm">Save</button>',
        ];
    }
    public function crudAction(){
        $post = Helpers::post();
        if ($post['action'] == 'add') {
            return $this->createUser($post);
        }else{
            return $this->updateUser($post);
        }
    }
    public function createUser($post){
        extract($post);
        $sql = 'SELECT * FROM tbl_users WHERE username = ?';
        $param = [$username];
        $result =  $this->model->getRow($sql, $param);
        if ($result) {
            $response['success'] = false;
            $response['exist'] = true;
            $response['msg'] = 'Username already exist';
        }else{
            $data['first_name'] = $first_name;
            $data['middle_name'] = $middle_name;
            $data['last_name'] = $last_name;
            $data['bday'] = $bday;
            $data['email'] = $email;
            $data['phone_number'] = $phone_number;
            $data['username'] = $username;
            $data['user_role'] = 2;
            $data['password'] = Hash::make($password);
            $res = $this->model->insert('tbl_users', $data);
            if ($res) {
                $response['success'] = true;
                $response['exist'] = false;
                $response['msg'] = 'Successfully Added!';
            }
        }
        return $response;
    }
    public function updateUser($post){
        extract($post);
        $data['fullname'] = $fullname;
        $data['email'] = $email;
        $data['phone_number'] = $phone_number;
        $data['username'] = $username;
        if (isset($password) && $password != null && $password != '') {
            $data['password'] = Hash::make($password);
        }
        $where = [
            ['field' => 'user_id','value'=> $user_id]
        ];
        $res = $this->model->updateWhere('tbl_users', $where, $data);
        if ($res) {
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Successfully Updated!';
        }else{
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Successfully Updated!';
        }
        return $response;
    }
    public function deleteDataUser(){
        $post = Helpers::post();
        if ($post['status'] == 'unblock') {
            $data['deleted'] = 0;
            $response['msg'] = 'Unblocked Successfully';
        }else{
            $data['deleted'] = 1;
            $response['msg'] = 'Blocked Successfully';
        }
        $where = [
            ['field' => 'user_id','value'=> $post['id']]
        ];
        $res = $this->model->updateWhere('tbl_users', $where, $data);
        if ($res) {
            $response['success'] = true;
           
        }else{
            $response['success'] = false;
            $response['msg'] = 'Error';
        }
        return response()->json($response);
    }
    public function listUsers(){
        $post = Helpers::post();
        $sql = "SELECT * FROM tbl_users WHERE user_role = 2 ";
        $result =  $this->model->getResults($sql, []);  
        $data = [];
        $x = 1;
        if ($result) {
            foreach ($result as $key => $R) {
                $crdentials = '
                                 data-id = "'.$R->user_id.'"
                             ';
                 if ($R->status == 'PENDING') {
                     $status = 'primary';
                 }elseif ($R->status == 'ACCEPTED') {
                     $status = 'success';
                 }else{
                     $status = 'warning';
                 }
                 if ($R->deleted == 1) {
                    $icon = '<i class="icon-copy bi bi-lock"></i> ';
                    $status_type = 'danger';
                    $text = 'BLOCKED';
                    $btn = '<a class="dropdown-item" href="javascript:void(0);" '.$crdentials.' id = "deleteData" data-status="unblock" data-msg="Unblock"><i class="icon-copy fa fa-unlock" aria-hidden="true"></i> Unblock</a>';
                 }else{
                    $icon = '<span class="icon-copy ti-check-box"></span> ';
                    $status_type = 'success';
                    $text = 'ACTIVE';
                    $btn = '<a class="dropdown-item" href="javascript:void(0);" '.$crdentials.' id = "deleteData" data-status="block" data-msg="Block"><i class="icon-copy fa fa-exclamation-circle" aria-hidden="true"></i> Blocked</a>';
                 }
                $data[] = [
                 '#' => $x++,
                 'username' => $R->username,
                 'email' => $R->email,
                 'full_name' => $R->fullname,
                 'phone_number' => $R->phone_number,
                 'address' => Helpers::addBrAfterWords($R->address),
                 'status' => Helpers::status_badge($icon.$text,$status_type),
                 'action' => '
                         <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Action
                         </button>
                         <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);" '.$crdentials.' id = "viewAccount"><i class="dw dw-edit2"></i> Edit</a>
                            '.$btn.'
                         </div>
                 ',
                ];
             }
        }
        return Helpers::generateDataTable($data);
    }
    public function acceptUser(){
        $post = Helpers::post();
        extract($post);
        $sql = 'SELECT * FROM tbl_users WHERE user_id = ?';
        $param = [$id];
        $row =  $this->model->getRow($sql, $param);
        $full_name =  $row->first_name.' '.$row->middle_name.' '.$row->last_name;
        $data['to_email'] = $row->email;
        $data['to_full_name'] = $full_name;
        $data['subject'] = 'Message From DTI Negosyo Center';
        $data['msg'] = 'Hello '.$full_name.', Your Application has been Accepted you can now login your account. Please click the link <a href="'.env('APP_URL').'auth/view/sign-in">Click me!</a>';
        $mail = Helpers::emailSender($data);
        if ($mail['success']) {
            $response['msg'] = $full_name.' application has been accepted successfully!';
            $response['success'] = true;
            $res['status'] = 'ACCEPTED';
            $res['id'] = $id;
            $this->updateStatus($res);
            return response()->json($response);
        }else{
            return $mail;
        }
    }
    public function declineUser(){
        $post = Helpers::post();
        extract($post);
        $sql = 'SELECT * FROM tbl_users WHERE user_id = ?';
        $param = [$id];
        $row =  $this->model->getRow($sql, $param);
        $full_name =  $row->first_name.' '.$row->middle_name.' '.$row->last_name;
        $data['to_email'] = $row->email;
        $data['to_full_name'] = $full_name;
        $data['subject'] = 'Message From DTI Negosyo Center';
        $data['msg'] = 'Hello '.$full_name.', Your Application has been declined';
        $mail = Helpers::emailSender($data);
        if ($mail['success']) {
            $response['msg'] = $full_name.' application has been declined successfully!';
            $response['success'] = true;
            $res['status'] = 'DECLINED';
            $res['id'] = $id;
            $this->updateStatus($res);
            return response()->json($response);
        }else{
            return $mail;
        }
    }
    public function updateStatus($res){
        $data['status'] = $res['status'];
        $where = [
            ['field' => 'user_id','value'=> $res['id']]
        ];
        $this->model->updateWhere('tbl_users', $where, $data);
    }
}