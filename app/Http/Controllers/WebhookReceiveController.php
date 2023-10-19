<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class WebhookReceiveController extends Controller
{
    public function __construct(){
    }

    public function index(){
        return view('home');
    }
	
	public function purchaseReceive(Request $request){
		$data = $request->all();
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit();
		Log::info('Showing the purchase receive for user: {data}', ['data' => json_encode($data)]);
	}
	
	public function tokenReceive(Request $request){
		$data = $request->all();
		echo json_encode($data);
		exit();
	}
}
