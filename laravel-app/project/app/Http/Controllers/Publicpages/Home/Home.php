<?php 
namespace App\Http\Controllers\Publicpages\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainModel;

class Home extends Controller
{
    function __construct() {
        $this->model = new MainModel();
    }
    public function defaultPage(){
        return 'HOME';
    }
}
?>