<?php 
namespace App\Http\Controllers\Components\Profile;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Support\Facades\Hash;
class Profile 
{

    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('Profile');
    }
    public static function js(){
        return [
            'js/sample'
        ];
    }
    public function defaultPage($params){
        $data = [];
        return [
            'user_details' => Helpers::session()['user_details']
        ];
    }
    public function viewProfileDetails(){
        $record = $this->model->getRow('SELECT * FROM tbl_users WHERE user_id = ?',[$this->session['user_id']]);
        $data = [
            'user_details' => $record
        ];
        return [
            'html' => $this->session['user_role'] == 2 ? view('profile', $data)->render() :  view('profileadmin', $data)->render()
        ];
    }
    public function crudAction(){
        $post = Helpers::allr();
        return $this->updateUser($post);
    }
    public function updateUser($post){
        extract($post);
        $sql = 'SELECT * FROM tbl_users WHERE username = ?';
        $param = [$username];
        $result =  $this->model->getRow($sql, $param);
        if ($result && $result->user_id != $this->session['user_id']) {
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
            if (isset($lot_no)) {
                $data['lot_no'] = $lot_no;
            }
            if (isset($block_no)) {
                $data['block_no'] = $block_no;
            }
            if (isset($position)) {
                $data['position'] = $position;
            }
            if (isset($profile_img)) {
                if ($folder_name == '' || $folder_name == null) {
                    $folder_name = Helpers::strRandom(10);
                }
                $data['folder'] = $folder_name;
                $data['files'] = $this->uploadFileLoan($folder_name,$post['profile_img']);
            }
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
        }
       
       
        return $response;
    }
    public function uploadFileLoan($folder_name,$file_upload){
        $path = Helpers::getDir('profile', $folder_name);
        $filename = Helpers::strRandom(10) . '-' . Helpers::strRandom(10) . '.' . $file_upload->extension();
        $file_upload->move($path, $filename);
        return $filename;
    }
}