<?php 
namespace App\Http\Controllers\Components\ProductInventoryConsignee;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class ProductInventoryConsignee
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('ProductInventoryConsignee');
    }
    public static function js(){
      
        return [
            'js/sample'
        ];
    }
    public function defaultPage($params){
        $d['fake_names'] = Helpers::generateRandomNames(10);
        return $d;
    }
    public function addNewUser(){
        $post = Helpers::post();
        extract($post);
        $d['data'] = false;
        $session = $this->session;
        $added_by = $session['user_id'];
        $sql = "SELECT * FROM tbl_products as a WHERE a.deleted = 0 and added_by = ?";
        $result =  $this->model->getResults($sql, [$added_by]); 
        $d['products'] = $result;
        return [
            'action' => 'Add New',
            'body' =>  view('modal-content.view', $d)->render(),
            'footer' =>  '<button type="submit" class="btn btn-primary btn-sm">Save</button>',
        ];
    }
    public function listUsers(){
        $post = Helpers::post();
        $where_extend = '';
        $session = $this->session;
        $added_by = $session['user_id'];
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        CONCAT_WS(
        ' ', -- This is the separator
        COALESCE(d.first_name, ''),
        COALESCE(d.middle_name, ''),
        COALESCE(d.last_name, '')
        ) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null";
        $result =  $this->model->getResults($sql, []);  
        $data = [];
        $BASEURL= env('APP_URL');
        $x = 1;
      
        if ($result) {
            foreach ($result as $key => $R) {
                $crdentials = '
                                 data-id = "'.$R->stock_id.'"
                             ';
                $data[] = [
                 '#' => $x++
                 //.'<br>'.$R->stock_id.'<br>'.$R->product_id
                 ,
                 'product_photo' => '  <img src="'.$BASEURL.'public/main/uploaded/products/'.$R->file.'" style="width:150px;"alt="...">',
                 'product_owner' => $R->product_owner, 
                 'product_name' =>  '<strong>'.$R->product_name.'</strong><br>'.
                                    $R->product_desc.'<br>'.
                                    'Exp Date: <strong>'.date(LONGDATE,strtotime($R->expiration_date)).'</strong><br>'
                                    , 
                 'product_desc' => $R->product_desc,
                 'total_stocks' => $R->total_stocks,
                 'sold_product' => $R->sold_product,
                 'remaining_stocks' => $R->total_stocks - $R->dis_stocks,
                 'notify_stocks' => $R->notify_stocks,
                 'dis_stocks' => $R->dis_stocks,//$R->dis_stocks,
                 'return_stock_qty' => '<input type="number" class="form-control form-control-sm text-center" id="getPrice-'.$R->stock_id.'" min="1" value="1" max="'.$R->dis_stocks.'" min="1">',//$R->dis_stocks,
                 'price' => '₱'.number_format($R->price,2),
                 'consinee_price' => '₱'.number_format($R->consumer_price,2),
                 'status'=> 'In Stock',
                 'added_date' => date(LONGDATE,strtotime($R->updated_date_inv)),
                // 'consinee_price'=>'<input type="number" class="form-control form-control-sm" id="getPrice-'.$R->stock_id.'" min="1" value="'.$R->price.'">',
                 'move'=>'<button type="button" class="btn btn-primary btn-sm moveNow" data-id="'.$R->stock_id.'" >Move Inventory</button>',
                 'update'=>'<button type="button" class="btn btn-primary btn-sm moveNow" data-id="'.$R->stock_id.'" >Update</button>',
                 'return'=>'<button type="button" class="btn btn-danger btn-sm returnProduct" data-id="'.$R->stock_id.'" data-productid="'.$R->product_id.'">Return</button>',
                 'action' => '
                         <a class="dropdown-item" href="javascript:void(0);" '.$crdentials.' id = "viewAccount"><i class="dw dw-edit2"></i> Edit</a>
                 ',
              
                ];
             }
        }
        return Helpers::generateDataTable($data);
    }
    public function viewDataUser(){
        $post = Helpers::post();
        extract($post);
        $session = $this->session;
        $added_by = $session['user_id'];
        $sql2 = "SELECT * FROM tbl_products as a WHERE a.deleted = 0 and added_by = ?";
        $result =  $this->model->getResults($sql2, [$added_by]); 
        $d['products'] = $result;
        $sql = 'SELECT * FROM tbl_product_stocks WHERE stock_id = ?';
        $param = [$id];
        $row =  $this->model->getRow($sql, $param);
        $d['data'] = $row;
        return [
            'action' => 'Edit',
            'body' =>  view('modal-content.view', $d)->render(),
            'footer' =>  '<button type="submit" class="btn btn-primary btn-sm">Save</button>',
        ];
    }
    public function crudAction(){
        $post = Helpers::allr();
        //dd($post);
        if ($post['action'] == 'add') {
            return $this->createUser($post);
        }else{
            return $this->updateUser($post);
        }
    }
    public function createUser($post){
        extract($post);
        $folder_name = Helpers::strRandom(10);
        $data['product_id'] = $product_id;
        $data['total_stocks'] = $total_stocks;
        $data['notify_stocks'] = $notify_stocks;
        $data['price'] = $price;
        $data['expiration_date'] = $expiration_date;

        $session = $this->session;
        $data['added_by'] = $session['user_id'];
        $data['added_date'] = date(SQLDATETIME);
        $res = $this->model->insert('tbl_product_stocks', $data);
        if ($res) {
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Successfully Added!';
        }
        return $response;
    }
    public function updateUser($post){
        extract($post);
        $folder_name = Helpers::strRandom(10);
        $data['product_id'] = $product_id;
        $data['total_stocks'] = $total_stocks;
        $data['notify_stocks'] = $notify_stocks;
        $data['price'] = $price;
        $data['expiration_date'] = $expiration_date;

        $where = [
            ['field' => 'stock_id','value'=> $id]
        ];
        $res = $this->model->updateWhere('tbl_product_stocks', $where, $data);
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
    public function uploadFileLoan($folder_name,$file_upload){
        $path = Helpers::getDir('products', $folder_name);
        $filename = Helpers::strRandom(10) . '-' . Helpers::strRandom(10) . '.' . $file_upload->extension();
        $file_upload->move($path, $filename);
        return $folder_name.'/'.$filename;
    }
    public function moveNow(){
        $post = Helpers::allr();
        extract($post);
        $data['consumer_price'] = $con_price;
        $data['status'] = 1;

        $where = [
            ['field' => 'stock_id','value'=> $id]
        ];
        $res = $this->model->updateWhere('tbl_distributed_products', $where, $data);
        if ($res) {
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Successfully Moved!';
        }else{
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Failed Move!';
        }
        return $response;
    }
    public function returnProducts(){
        $post = Helpers::allr();
        extract($post);
        $current_stocks =  $this->model->getRow("SELECT * FROM tbl_product_stocks WHERE stock_id = ? and product_id = ?",[$stockid,$productid]);

        $data['total_stocks'] = $return_stocks + $current_stocks->total_stocks;
        $where = [
            ['field' => 'stock_id','value'=> $stockid],
            ['field' => 'product_id','value'=> $productid]
        ];
        $res = $this->model->updateWhere('tbl_product_stocks', $where, $data);
        if ($res) {
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Successfully Returned!';
            $param_data = [
                'stock_id'      => $stockid,
                'product_id'    => $productid,
                'qty_return'    => $return_stocks,
                'reason_return' => $value,
            ];
            $this->returnLogs($param_data);
        }else{
            $response['success'] = true;
            $response['exist'] = false;
            $response['msg'] = 'Failed!';
        }
        return $response;
    }
    public function returnLogs($p){
        $session = $this->session;
        $data['stock_id'] = $p['stock_id'];
        $data['product_id'] = $p['product_id'];
        $data['qty_return'] = $p['qty_return'];
        $data['reason_return'] = $p['reason_return'];
        $data['added_by'] = $session['user_id'];
        $data['date_time_return'] = date(SQLDATETIME);
        $res = $this->model->insert('tbl_return_logs', $data);
    }
}