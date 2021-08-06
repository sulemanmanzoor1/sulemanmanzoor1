<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    //
    public function index()
    {

        $data['title'] = __('file.services');
        $data['services'] = Service::get();
        $data['activePage'] = 'services';
        return view('admin.service.index', $data);
    }

    public function block(Request $request)
    {

        $service = Service::findorfail($request->service_id);
        $service->block = $request->block;
        $service->update();
        $message = array('message' => 'service is updated', 'status' => 200);
        echo json_encode($message);
        die;
    }
}
