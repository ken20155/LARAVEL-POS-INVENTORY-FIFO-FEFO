<?php 
namespace App\Http\Controllers\Components\ProductInventory;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class ProductInventory
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('ProductInventory');
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
        b.product_id,
        b.file,
        b.product_name,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.price,
        a.added_date,
        a.expiration_date,
        e.qty_return as qty_return,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        COALESCE(f.qty_sold, 0) AS sold_product
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id FROM tbl_distributed_products WHERE deleted = 0 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id

        WHERE a.deleted = 0 and a.added_by = ?";
        $result =  $this->model->getResults($sql, [$added_by]);  
        $data = [];
        $BASEURL= env('APP_URL');
        $x = 1;
      
        if ($result) {
            foreach ($result as $key => $R) {
                $crdentials = '
                                 data-id = "'.$R->stock_id.'"
                             ';
                $data[] = [
                 '#' => $x++,
                 'product_photo' => '  <img src="'.$BASEURL.'public/main/uploaded/products/'.$R->file.'" style="width:150px;"alt="...">',
                 'product_name' =>  '<strong>'.$R->product_name.'</strong><br>'.
                 $R->product_desc.'<br>'.
                 'Exp Date: <strong>'.date(LONGDATE,strtotime($R->expiration_date)).'</strong><br>'
                 , 
                 'product_desc' => $R->product_desc,
                 'total_stocks' => $R->total_stocks + $R->dis_stocks,
                 'remaining_stocks' => $R->total_stocks - $R->sold_product - $R->qty_return,
                 'sold_product' => $R->sold_product,
                 'notify_stocks' => $R->notify_stocks,
                 'dis_stocks' => $R->dis_stocks,
                 'return_stocks' => '<i class="icon-copy fa fa-info-circle text-warning viewStockReturn" data-stockid="'.$R->stock_id.'" data-productid="'.$R->product_id.'" aria-hidden="true" style="font-size:20px;"></i> '.$R->qty_return,
                 'price' => '₱'.number_format($R->price,2),
                 'status'=> 'In Stock',
                 'added_date' => date(LONGDATE,strtotime($R->added_date)),
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
    public function viewStockReturn(){
        $post = Helpers::post();
        extract($post);
        $sql2 = "SELECT * FROM tbl_return_logs as a WHERE a.stock_id = ? and a.product_id = ?";
        $result =  $this->model->getResults($sql2, [$stockid,$productid]); 
        $d['data'] = $result;
        return [
            'action' => 'View Return',
            'body' =>  view('modal-content.view-stocks-return', $d)->render(),
        ];
    }
}