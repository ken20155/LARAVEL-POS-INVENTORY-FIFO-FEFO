<?php 
namespace App\Http\Controllers\Components\AllReports;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class AllReports
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
        Helpers::getView('AllReports');

    }
    public static function js(){
        return [
            'js/sample'
        ];
    }
    function convertStringToArray($input) {
    // Convert comma-separated to ampersand-separated
        $query = str_replace(',', '&', $input);
        
        // Parse into associative array
        parse_str($query, $output);
        
        return $output;
    }
    public function defaultPage($params){
        $data = [];
        $session = $this->session;
   
        $d['user_role'] = $session['user_role'];
        return $d;
    }
   
    public function allReports(){
        $post = Helpers::post();
        extract($post);
        $fn_title = $this->convertStringToArray($reports_name);
        $fn = $fn_title['fn'];
        $title = $fn_title['title'];
        $d['html'] = '';
        if (method_exists($this,$fn)) {
            $d['html'] = $this->$fn($post,$fn_title);
        }
        return $d;
    }
    public function inventoryReport($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $where_ex = '';
        if (isset($post['start_date']) && isset($post['end_date'])) {
            $start_date = date(SQLDATE,strtotime($post['start_date']));
            $end_date = date(SQLDATE,strtotime($post['end_date']));
            $where_ex .= " AND a.added_date BETWEEN '".$start_date."' AND '".$end_date."'";
        }
        if (isset($post['consignor_name']) && !empty($post['consignor_name'])) {
            $where_ex .= " AND CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) LIKE '%".$post['consignor_name']."%' ";
        }
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_category,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        e.qty_return as qty_return,
        /*CONCAT(d.first_name,' ',d.middle_name,' ',d.last_name) as product_owner,*/
        CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null $where_ex";
        $d['data'] = $this->model->getResults($sql, []); 
        return view('report-content.'.$fn_title['fn'], $d)->render();
    }
    public function saleReport($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $where_ex = '';
        if (isset($post['start_date']) && isset($post['end_date'])) {
            $start_date = date(SQLDATE,strtotime($post['start_date']));
            $end_date = date(SQLDATE,strtotime($post['end_date']));
            $where_ex .= " AND a.added_date BETWEEN '".$start_date."' AND '".$end_date."'";
        }
        if (isset($post['consignor_name']) && !empty($post['consignor_name'])) {
            $where_ex .= " AND CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) LIKE '%".$post['consignor_name']."%' ";
        }
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_category,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        e.qty_return as qty_return,
        CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null $where_ex";
        $d['data'] = $this->model->getResults($sql, []); 
        return view('report-content.'.$fn_title['fn'], $d)->render();
    }
    public function receivedReport($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $where_ex = '';
        if (isset($post['start_date']) && isset($post['end_date'])) {
            $start_date = date(SQLDATE,strtotime($post['start_date']));
            $end_date = date(SQLDATE,strtotime($post['end_date']));
            $where_ex .= " AND c.updated_date_inv BETWEEN '".$start_date."' AND '".$end_date."'";
        }
        if (isset($post['consignor_name']) && !empty($post['consignor_name'])) {
            $where_ex .= " AND CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) LIKE '%".$post['consignor_name']."%' ";
        }
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_category,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        c.total_received,
        e.qty_return as qty_return,
        CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv,count(stock_id) as total_received FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null $where_ex";
        $d['data'] = $this->model->getResults($sql, []); 
        return view('report-content.'.$fn_title['fn'], $d)->render();
    }
    public function consPayoutReport($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $where_ex = '';
        // if (isset($post['start_date']) && isset($post['end_date'])) {
        //     $start_date = date(SQLDATE,strtotime($post['start_date']));
        //     $end_date = date(SQLDATE,strtotime($post['end_date']));
        //     $where_ex .= " AND c.updated_date_inv BETWEEN '".$start_date."' AND '".$end_date."'";
        // }
        if (isset($post['consignor_name']) && !empty($post['consignor_name'])) {
            $where_ex .= " AND CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) LIKE '%".$post['consignor_name']."%' ";
        }
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_category,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        c.total_received,
        e.qty_return as qty_return,
        CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product,
        f.sub_total AS sub_total_trans,
        f.status AS status_trans
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv,count(stock_id) as total_received FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,SUM(sub_total) as sub_total,stock_id,`status` FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id,`status`) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null $where_ex";
        $d['data'] = $this->model->getResults($sql, []); 
        return view('report-content.'.$fn_title['fn'], $d)->render();
    }
    public function productSaleTracking($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $where_ex = '';
        if (isset($post['start_date']) && isset($post['end_date'])) {
            $start_date = date(SQLDATE,strtotime($post['start_date']));
            $end_date = date(SQLDATE,strtotime($post['end_date']));
            $where_ex .= " AND f.last_sale_date BETWEEN '".$start_date."' AND '".$end_date."'";
        }
        if (isset($post['consignor_name']) && !empty($post['consignor_name'])) {
            $where_ex .= " AND CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) LIKE '%".$post['consignor_name']."%' ";
        }
        $sql = "SELECT 
        a.stock_id,
        a.product_id,
        b.file,
        b.product_name,
        b.product_category,
        b.product_desc,
        a.total_stocks,
        a.sold_stocks,
        a.notify_stocks,
        a.expiration_date,
        a.price,
        a.added_date,
        c.consumer_price,
        c.updated_date_inv,
        e.qty_return as qty_return,
        CONCAT_WS(' ', COALESCE(d.first_name, ''), COALESCE(d.middle_name, ''), COALESCE(d.last_name, '')) as product_owner,
        (c.qty - COALESCE(e.qty_return, 0)) AS dis_stocks,
        f.qty_sold AS sold_product,
        f.last_sale_date AS last_sale_date
        FROM tbl_product_stocks as a 
        LEFT JOIN tbl_products as b ON a.product_id = b.product_id
        LEFT JOIN (SELECT SUM(qty) as qty,stock_id,MAX(consumer_price) as consumer_price,MAX(updated_date_inv) as updated_date_inv FROM tbl_distributed_products WHERE deleted = 0 and `status` = 1 GROUP BY stock_id) as c ON a.stock_id = c.stock_id
        LEFT JOIN (SELECT SUM(qty_return) as qty_return,stock_id FROM tbl_return_logs WHERE deleted = 0 GROUP BY stock_id) as e ON a.stock_id = e.stock_id
        LEFT JOIN (SELECT SUM(qty) as qty_sold,stock_id,MAX(added_date) as last_sale_date FROM tbl_product_transaction WHERE deleted = 0 GROUP BY stock_id) as f ON a.stock_id = f.stock_id
        LEFT JOIN tbl_users as d ON a.added_by = d.user_id
        WHERE a.deleted = 0 and c.stock_id is not null and b.added_by = ? $where_ex";
        $session = $this->session;

        $d['data'] = $this->model->getResults($sql, [$session['user_id']]); 
        return view('report-content.'.$fn_title['fn'], $d)->render();

    }
    public function paymentTrackingConsignor($post,$fn_title){
        $d['title'] = $fn_title['title'];
        $session = $this->session;
        $d['data'] = false; 
        return view('report-content.'.$fn_title['fn'], $d)->render();
    }
    public function lineChart(){
        //$d['data_pending'] = $this->pendingAcceptChart('PENDING');
        $d['data_paid'] = $this->pendingAcceptChart('ACCEPTED')['data'];
        $d['total_paid'] = $this->pendingAcceptChart('ACCEPTED')['total'];
        //dd($d);
        return $d;    
    }
    public function totalUsers(){
       $res = $this->model->getRow("SELECT count(*) as total FROM tbl_users WHERE user_role = 2 and deleted = 0");
       return $res->total;
    }
    public function totalEarnings(){
       $res = $this->model->getRow("SELECT SUM(sub_total) as total FROM tbl_product_transaction WHERE deleted = 0");
       return $res->total;
    }
    public function totalProductSold(){
       $res = $this->model->getRow("SELECT COUNT(*) as total FROM tbl_product_transaction WHERE deleted = 0");
       return $res->total;
    }
    public function totalProducts(){
       $session = $this->session;
       $res = $this->model->getRow("SELECT COUNT(*) as total FROM tbl_products WHERE deleted = 0 and added_by = ?",[$session['user_id']]);
       return $res->total;
    }
    public function totalProductSold2(){
       $session = $this->session;
       $res = $this->model->getRow("SELECT COUNT(*) as total FROM tbl_distributed_products as a 
       INNER JOIN tbl_product_transaction as b ON a.stock_id = b.stock_id 
       INNER JOIN tbl_products as c ON a.product_id = c.product_id 
       WHERE a.deleted = 0 and c.added_by = ?",[$session['user_id']]);
       return $res->total;
    }
    public function totalEarnings2(){
       $session = $this->session;
       $res = $this->model->getRow("SELECT SUM(a.org_price * b.qty) AS total FROM tbl_distributed_products as a 
       INNER JOIN tbl_product_transaction as b ON a.stock_id = b.stock_id 
       INNER JOIN tbl_products as c ON a.product_id = c.product_id 
       WHERE a.deleted = 0 and c.added_by = ?",[$session['user_id']]);
       return $res->total;
    }

    public function pendingAcceptChart1($status){
        $post = Helpers::post();
        extract($post);
        $month_value = [];
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        if ($status == 'PENDING') {
            $d['data'] = [17,13,33,54,52,24,71,87,9,23,81,13];

        }
        if ($status == 'ACCEPTED') {
            $d['data'] = [13,21,33,54,5,46,7,67,9,12,8,12];

        }
        return $d;
    }
    public function pendingAcceptChart($status){
        $post = Helpers::post();
        extract($post);
        //dd($post);
        $wherein = '';
        if (isset($year) && $year != '') {
            $wherein .= " AND YEAR(a.added_date) = '".$year."'";
        }
        $session = $this->session;
     
        if ($session['user_role'] == 1) {
                  $sql = "SELECT 
                    MONTH(a.added_date) AS month,
                    SUM(a.sub_total) AS total_count
                FROM 
                    tbl_product_transaction AS a
                WHERE 
                    a.deleted = 0 
                    $wherein
                GROUP BY 
                    MONTH(a.added_date)
                ORDER BY 
                    MONTH(a.added_date)";
        }else{
                $wherein .= " AND c.added_by = ".$session['user_id']."";
                $sql = "SELECT 
                    MONTH(a.added_date) AS month,
                    SUM(b.org_price * a.qty) AS total_count
                FROM 
                    tbl_product_transaction AS a
                    INNER JOIN tbl_distributed_products as b ON a.stock_id = b.stock_id 
                    INNER JOIN tbl_products as c ON a.product_id = c.product_id 
                WHERE 
                    a.deleted = 0 
                    $wherein
                GROUP BY 
                    MONTH(a.added_date)
                ORDER BY 
                    MONTH(a.added_date)";
        }
        //dd($wherein);
        $res =  $this->model->getResults($sql, []); 
        $month_value = [];
        if ($res) {
            $data_value = [];
            foreach ($res as $key => $R) {
                $data_value[$R->month] = $R->total_count;
            }
            $months = [1,2,3,4,5,6,7,8,9,10,11,12];
            foreach ($months as $key => $month) {
                if (isset($data_value[$month])) {
                    $month_value[] = $data_value[$month];
                }else{
                    $month_value[] = 0;
                }
            }
        }
        $d['total'] = $this->totalMax($month_value);
        $d['data'] = $month_value;
        //dd($d);
        return $d;
    }
    public function totalMax($month_value){
        return array_sum($month_value); 
    }
}