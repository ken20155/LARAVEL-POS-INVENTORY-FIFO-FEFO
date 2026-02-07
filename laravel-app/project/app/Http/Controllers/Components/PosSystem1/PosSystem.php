<?php 
namespace App\Http\Controllers\Components\PosSystem;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class PosSystem
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('PosSystem');
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
    public function generateStockProducts(){
        $post = Helpers::post();
        extract($post);
        $where_ex = '';
        if (isset($search_product)) {
            $where_ex .= " and b.product_name LIKE '%".$search_product."%'";
        }
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
        --a.price,
        a.added_date,
        c.consumer_price as price,
        c.updated_date_inv,
        CONCAT(d.first_name,' ',d.middle_name,' ',d.last_name) as product_owner,
        c.qty as dis_stocks
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null $where_ex";
        $d['data'] =  $this->model->getResults($sql, []); 
        $cart =  $this->model->getResults("SELECT * FROM tbl_product_cart WHERE added_by = ?", [$added_by]);
        $selected_product = [];
        if ($cart) {
            foreach ($cart as $key => $R) {
                $selected_product[] = $R->product_id;
            } 
        }
        $d['cart'] = $selected_product;
        return [
            'display_product' =>  view('product-content.display_product', $d)->render(),
        ];
    }
    public function generateStockProductsSelected(){
        $post = Helpers::post();
        extract($post);
        $session = $this->session;
        $added_by = $session['user_id'];
        $sql = "SELECT 
        a.cart_id, 
        a.stock_id, 
        a.product_id, 
        a.qty, 
        --a.price, 
        c.consumer_price as price,
        a.sub_total, 
        b.total_stocks, 
        c.product_name
        FROM tbl_product_cart as a 
        LEFT JOIN tbl_product_stocks as b ON a.stock_id = b.stock_id
        LEFT JOIN tbl_products as c ON b.product_id = c.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        WHERE a.deleted = 0 and a.added_by = ?";




        $d['data'] =  $this->model->getResults($sql, [$added_by]); 
        return [
            'selected_product' =>  view('product-content.selected_product', $d)->render(),
        ];
    }
    public function addToCart(){
        $post = Helpers::post();
        extract($post);
        $data['stock_id'] = $stock_id;
        $data['product_id'] = $product_id;
        $data['price'] = $price;
        $data['qty'] = 1;
        $data['sub_total'] = $price * 1;

        $session = $this->session;
        $data['added_by'] = $session['user_id'];
        $res = $this->model->insert('tbl_product_cart', $data);
        return [
            'msg' =>true,
        ];
    }
    public function increaseDecrease(){
        $post = Helpers::post();
        extract($post);
        //dd($post);
        if ($type == 'inc') {
            $new_qty =  $qty + 1;
            if ($stocks >= $new_qty) {
                $data['qty'] = $new_qty;
            }else{
                $data['qty'] = $stocks;
            }
        }else{
            $new_qty =  $qty - 1;
            if ($new_qty > 0) {
                $data['qty'] = $new_qty;
            }else{
                $data['qty'] = 1;

            }
        }

        $where = [
            ['field' => 'cart_id','value'=> $cart_id]
        ];
        $res = $this->model->updateWhere('tbl_product_cart', $where, $data);
        return [
            'msg'=>true
        ];
    }
    public function resetNow(){
        $post = Helpers::post();
        extract($post);
        $session = $this->session;
        $where = ['added_by' => $session['user_id']];
        
        $res = $this->model->deleteData('tbl_product_cart', $where);
        return [
            'msg'=>true
        ];
    }
    public function deleteSingleCart(){
        $post = Helpers::post();
        extract($post);
        $where = ['cart_id' => $cart_id];
        $res = $this->model->deleteData('tbl_product_cart', $where);
        return [
            'msg'=>true
        ];
    }
    public function distributeNow(){
        $post = Helpers::post();
        extract($post);
        $session = $this->session;
        $added_by = $session['user_id'];
        $sql = "SELECT 
        a.cart_id, 
        a.stock_id, 
        a.product_id, 
        a.qty, 
        a.price, 
        a.sub_total, 
        b.total_stocks, 
        c.product_name
        FROM tbl_product_cart as a 
        LEFT JOIN tbl_product_stocks as b ON a.stock_id = b.stock_id
        LEFT JOIN tbl_products as c ON b.product_id = c.product_id
        WHERE a.deleted = 0 and a.added_by = ?";
        $res =  $this->model->getResults($sql, [$added_by]); 
        $data = [];
        foreach ($res as $key => $R) {
            
           $data[] = [
                'stock_id'=>$R->stock_id,
                'product_id'=>$R->product_id,
                'qty'=>$R->qty,
                'org_price'=>$R->price,
                'sub_total'=>$R->qty * $R->price,
            ];
            $data_arry = [
                'stock_id'=>$R->stock_id,
                'total_stocks'=>$R->total_stocks - $R->qty,
            ];
            $this->updateStocks($data_arry);
        }
        $res = $this->model->batchInsert('tbl_distributed_products', $data);
        $this->resetNow();
        return [
            'msg'=>true
        ];
    }
    public function updateStocks($data){
        $update_stock['total_stocks'] = $data['total_stocks']; 
        $where = [
            ['field' => 'stock_id','value'=> $data['stock_id']]
        ];
        return $this->model->updateWhere('tbl_product_stocks', $where, $update_stock);
    }
    //old
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
        $sql = "SELECT * FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
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
                 'product_name' => $R->product_name, 
                 'product_desc' => $R->product_desc,
                 'total_stocks' => $R->total_stocks,
                 'remaining_stocks' => $R->total_stocks - $R->sold_stocks,
                 'notify_stocks' => $R->notify_stocks,
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
}