<?php
namespace App\Http\Controllers\Components\ConsignorPayout;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class ConsignorPayout
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('ConsignorPayout');
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
        $data = [];
        $session = $this->session;
        $add_where = '';
        if ($session['user_role'] == 2) {
           $param = [$post['status'],$session['user_id']];
           $add_where .= 'and b.added_by = ?';
        }else{
           $param = [$post['status']];
        }
        $sql = "SELECT
                     CONCAT_WS(' ',
    COALESCE(c.first_name, ''),
    COALESCE(c.middle_name, ''),
    COALESCE(c.last_name, '')
) as full_name,
                     b.added_by,
                     MAX(f.added_date) as last_date_payout,
                     a.status as status_payment,
                     f.balance as balance_payment,
                     SUM(e.price * a.qty) AS amount_to_pay
                   FROM
                   tbl_product_transaction as a
                   LEFT JOIN tbl_products as b ON a.product_id = b.product_id
                   LEFT JOIN tbl_users as c ON b.added_by = c.user_id
                   LEFT JOIN tbl_product_stocks as e ON a.stock_id = e.stock_id
                   LEFT JOIN tbl_payment as f ON a.payment_id = f.payment_id
                   WHERE a.deleted = 0 and a.status = ? $add_where
                   GROUP BY b.added_by,c.first_name,c.middle_name,c.last_name,a.status,f.balance
        ";
        $result =  $this->model->getResults($sql, $param);
        if ($result) {
            $x=1;
            foreach ($result as $key => $R) {
               $crdentials = '
                                   data-id = "'.$R->added_by.'"
                                   data-status = "'.$R->status_payment.'"
                               ';
                $data[] = [
                   '#' => $x++,
                   'full_name' => $R->full_name,
                   'balance' => $R->balance_payment != null ? number_format($R->balance_payment,2) : 0,
                   'amount_to_pay' => number_format($R->amount_to_pay,2),
                   'last_date_payout' => $R->last_date_payout != null ? date(LONGDATE,strtotime($R->last_date_payout)) : '',
                   'status'=>$R->status_payment,
                   'action' => '
                               <a class="dropdown-item" href="javascript:void(0);" '.$crdentials.' id = "viewAccount"><i class="dw dw-edit2"></i> View details</a>
                    ',
                ];
            }
        }
        return Helpers::generateDataTable($data);
    }
    public function listUsers2(){
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
                   '#' => $x++,
                   'product_photo' => '    <img src="'.$BASEURL.'public/main/uploaded/products/'.$R->file.'" style="width:150px;"alt="...">',
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
        $param = [$status,$id];
        $sql2 = "SELECT
                     CONCAT_WS(' ',
                       COALESCE(c.first_name, ''),
                       COALESCE(c.middle_name, ''),
                       COALESCE(c.last_name, '')
                     ) as full_name,
                     b.added_by,
                     d.payment_id,
                     d.transaction_no,
                     d.user_id,
                     IFNULL(d.status, 'PENDING') AS status,
                     d.balance as balance_payment,
                     SUM(e.price * a.qty) AS amount_to_pay
                   FROM
                   tbl_product_transaction as a
                   LEFT JOIN tbl_products as b ON a.product_id = b.product_id
                   LEFT JOIN tbl_users as c ON b.added_by = c.user_id
                   LEFT JOIN tbl_payment as d ON a.payment_id = d.payment_id
                   LEFT JOIN tbl_product_stocks as e ON a.stock_id = e.stock_id
                   WHERE a.deleted = 0 and a.status = ? and b.added_by = ?
                   GROUP BY b.added_by,c.first_name,c.middle_name,c.last_name,d.payment_id,
                         d.transaction_no,
                         d.user_id,
                         d.amount_to_pay,
                         d.status,
                         d.balance
        ";
        $row =  $this->model->getRow($sql2, $param);

        $sql = "SELECT
                     CONCAT_WS(' ',
    COALESCE(c.first_name, ''),
    COALESCE(c.middle_name, ''),
    COALESCE(c.last_name, '')
) as full_name,
                     b.product_name,
                     b.added_by,
                     a.transaction_id,
                     a.qty,
                     a.added_date,
                     e.price as base_price,
                     d.consumer_price as mark_up_price
                   FROM
                   tbl_product_transaction as a
                   LEFT JOIN tbl_products as b ON a.product_id = b.product_id
                   LEFT JOIN tbl_users as c ON b.added_by = c.user_id
                   LEFT JOIN (SELECT MAX(consumer_price) as consumer_price,stock_id FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as d ON a.stock_id = d.stock_id
                   -- LEFT JOIN tbl_distributed_products as d ON a.stock_id = d.stock_id
                   LEFT JOIN tbl_product_stocks as e ON a.stock_id = e.stock_id
                   WHERE a.deleted = 0 and a.status = ? and b.added_by = ?
        ";

        $res =  $this->model->getResults($sql, $param);
        //dd($res);
        $d['data'] = $row;
        $d['product'] = $res;
        return [
            'action' => 'Payment',
            'body' =>  view('modal-content.view', $d)->render(),
            'footer' =>  $session['user_role'] == 1 && $status != 'PAID' ? '<button type="submit" class="btn btn-primary btn-sm">Process Payment</button>' : '',
        ];

    }
    /*public function crudAction(){
        $post = Helpers::allr();
        // dd($post);
        if ($post['status'] == 'PENDING') {
            return $this->pendingPaymentProcess($post);
        }else{
            return $this->updateUser($post);
        }
    }*/

    public function crudAction(){
        $post = Helpers::allr(); // Gets all request data

        // Determine if this is a payment-related action
        // The 'status' field from the modal (viewDataUser) indicates payment status
        if (isset($post['status']) && ($post['status'] == 'PENDING' || $post['status'] == 'PAID')) {
            // This means it's a payment-related submission
            return $this->pendingPaymentProcess($post); // Always call payment process for payment submissions
        } else {
            // This is for other types of updates, e.g., actual product updates
            // You might need more specific logic here to differentiate between
            // updating a user, a product, or a stock.
            // For example, if your form for updating a user sends 'action_type' => 'update_user_profile'
            // or if product updates have a 'stock_id' but no 'user_id' for payment.

            // As it stands, if this else branch is hit for a non-payment action,
            // it calls updateUser. You need to verify if other parts of your system
            // correctly trigger this branch for actual product stock updates.
            // If this branch is ONLY ever triggered incorrectly for payments,
            // then you might want to throw an error or handle it more specifically.

            // For now, let's assume 'updateUser' is for a different form submission.
            // If the 'id' (stock_id) is present, it implies a stock update.
            if (isset($post['id']) && isset($post['product_id'])) { // Check for identifiers of product stock update
                    return $this->updateUser($post); // This is the intended use for updating product stocks
            } else {
                // If it's not a payment and not a stock update, what is it?
                // This indicates a logical gap.
                // You might have other CRUD actions (e.g., createUser, deleteUser)
                // that should be routed here.

                // For now, let's return an error if it's an unrecognized action.
                return ['success' => false, 'msg' => 'Unknown action type.'];
            }
        }
    }


    public function pendingPaymentProcess($post){
        extract($post);
        $session = $this->session;
        $data['transaction_no'] = strtotime(date(SQLDATETIME));
        $data['user_id'] = $user_id;
        $data['amount_to_pay'] = $amount_to_pay;
        // Changed this line to remove 'PARTIAL' status
        $data['status'] = $balance == 0 ? 'PAID' : 'PENDING';
        $data['balance'] = $balance;
        $data['added_by'] = $session['user_id'];
        $data['added_date'] = date(SQLDATETIME);
        $res = $this->model->insert('tbl_payment', $data);
        if (isset($transaction_id) && !empty($transaction_id)) {
            foreach ($transaction_id as $key => $R) {
                $data_update['payment_id'] = $res['id'];
                // Changed this line to remove 'PARTIAL' status
                $data_update['status'] = $balance == 0 ? 'PAID' : 'PENDING';
                $where = [
                    ['field' => 'transaction_id','value'=> $R]
                ];
                $this->model->updateWhere('tbl_product_transaction', $where, $data_update);
            }
        }


        $response['success'] = true;
        $response['exist'] = false;
        $response['msg'] = 'Successfully Updated!';
        return $response;
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