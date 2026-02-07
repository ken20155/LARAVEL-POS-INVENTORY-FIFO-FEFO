<?php 
namespace App\Http\Controllers\Components\Dashboard;
use App\Models\MainModel;
use App\Http\Controllers\Helpers\Helpers;

class Dashboard
{
    function __construct() {
        $this->model = new MainModel();
        $this->module = Helpers::last_segment();
        $this->session = Helpers::session()['session'];
    }
    public static function js(){
        return [
            'js/sample'
        ];
    }
    public function defaultPage($params){
        $data = [];
        $session = $this->session;
        $d['total_user'] = $session['user_role'] == 1 ? $this->totalUsers() : $this->totalProducts();
        $d['total_product_sold'] = $session['user_role'] == 1 ? $this->totalProductSold() : $this->totalProductSold2();
        $d['total_earnings'] = $session['user_role'] == 1 ? $this->totalEarnings() : $this->totalEarnings2();
        $d['user_role'] = $session['user_role'];
        return $d;
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