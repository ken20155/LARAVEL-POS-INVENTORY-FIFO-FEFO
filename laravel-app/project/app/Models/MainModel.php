<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainModel extends Model {
    public function getRow($sql, $param = [], $value = null) {
        $res = DB::select($sql, $param);
        if ($value != null && $res) {
            return $res[0]->{$value};
        } else {
            return $res ? $res[0] : false;
        }
    }
 
    public function getResults($sql, $param = []) {
        $res = DB::select($sql, $param);
        return $res ? $res : false;
    }

    public function insert($table, $data) {
        $builder = DB::table($table);
        $id = $builder->insertGetId($data);
        return ['results' => ($id ? true : false), 'id' => $id];
    }

    public function updateWhere($table, $where, $data) {
        $builder = DB::table($table);
        foreach ($where as $W) {
            if (isset($W['type'])) {
                if ($W['type'] == 'wherein') {
                    $builder->whereIn($W['field'], $W['value']);
                }
            } else {
                $builder->where($W['field'], $W['value']);
            }
        }
        return $builder->update($data);
    }
    public function batchInsert($table, $param = []) {
        // try {
            $builder = DB::table($table);
            $builder->insert($param);
            return true;
        // } catch (\Exception $e) {
        //     //throw $th;
        // }
        // return false;
    }
    public function deleteData($table,$param){
        $builder = DB::table($table);
        $builder->where($param)->delete();
        return true;
    }
}
