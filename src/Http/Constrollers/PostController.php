<?php 

namespace VoyagerExcel\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;
use VoyagerExcel\Exports\PostExport;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return Excel::download(new PostExport, 'demo-'.date('H:i:s').'.xls');
    }
}
