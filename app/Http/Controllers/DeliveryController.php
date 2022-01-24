<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Wards;
use App\Models\Province;
use App\Models\Feeship;
use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller
{
    public function  delivery(){
        $city = City::orderby('matp','ASC')->get();

         return view('admin.Delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }

    }
    public function insert_delivery(Request $request){
        $data = $request->all();
        $num = filter_var($request->fee_ship,FILTER_SANITIZE_NUMBER_INT);
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $num;
        $fee_ship->save();
    }

    public function select_feeship(){
        $feeship = Feeship::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '<div class="table-responsive">
			<table class="table table-bordered">
				<thread>
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th>
						<th>Tên xã phường</th>
						<th>Phí ship</th>
						<th>Actions</th>
					</tr>
				</thread>
				<tbody>
				';

        foreach($feeship as $key => $fee){

            $output.='
					<tr>
						<td>'.$fee->city->name_city.'</td>
						<td>'.$fee->province->name_quanhuyen.'</td>
						<td>'.$fee->wards->name_xaphuong.'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'VND </td>
						<td><a href="'.url('delete-delivery/'.$fee->fee_id).'" class="btn btn-danger">Xóa</a></td>
					</tr>
					';
        }

        $output.='
				</tbody>
				</table></div>
				';

        echo $output;


    }

    public function update_delivery(Request $request){
        $data = $request->all();
         $fee_ship = Feeship::find($data['feeship_id']);
         $fee_value = rtrim($data['fee_value']);
         $fee_ship->fee_feeship = $fee_value;
         $fee_ship->save();
    }

    public function delete_delivery($id){
         Feeship::find($id)->delete();
         Session::put('delivery','Xóa phí vận chuyển thành công');
         return redirect()->back();
    }
}
