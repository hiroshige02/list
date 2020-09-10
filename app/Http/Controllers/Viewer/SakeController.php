<?php

namespace App\Http\Controllers\Viewer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterDefine;

class SakeController extends Controller
{

    function show($prefecture){
        //該当ID酒の存在チェック

        
        
        $viewData = [];
        $viewData['title'] = 'さわ音';
        $viewData['set_per_page'] = 2;

        return view('viewer.sake', $viewData);
    } 
}