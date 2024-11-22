<?php

namespace App\Http\Controllers;

use App\Admin\BranchDistrict;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CsvsImport;
use App\Admin\Order;
use App\Admin\Shop;
use App\Admin\Company;
use App\Admin\CoverageArea;
use App\Admin\WeightPrice;
use App\Admin\CsvData;
use App\Admin\Employee;
use App\Admin\Merchant;
use App\Admin\OrderConfirm;
use App\Admin\OrderStatusHistory;
use Session;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;



class CsvController extends Controller
{


    public function file_download(Request $request)
    {

        $file_path = public_path('sample-csv/' . 'sample.csv');
        return response()->download($file_path);
    }

    public function file_upload(Request $request)
    {

        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $merchants = Merchant::orderBy('merchants.business_name')->join('users', 'merchants.user_id', 'users.id')
            ->where('users.role', 12)
            ->get();


        return view('Admin.CsvImport.csv_file_upload', compact('shop', 'merchants'));
    }


    public function file_upload_merchants(Request $request)
    {

        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $merchants = Merchant::orderBy('merchants.business_name')->join('users', 'merchants.user_id', 'users.id')
            ->where('users.role', 12)
            ->get();


        return view('Admin.CsvImport.csv_file_upload_merchant', compact('shop', 'merchants'));
    }
    public function file_upload_express(Request $request)
    {
        $shop = Shop::orderBy('id', 'DESC')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $merchants = Merchant::orderBy('merchants.business_name')->join('users', 'merchants.user_id', 'users.id')
            ->where('users.role', 12)
            ->get();


        return view('Admin.CsvImport.csv_file_upload_express', compact('shop', 'merchants'));
    }


    public function import_regular_merchants(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt',

        ], [
            'csv_file.required' => 'Select your csv file',
            'csv_file.mimes' => 'Upload csv file only!',
        ]);


        if ($validate->fails()) {

            return back()->withErrors($validate->errors());
        }
        if (Auth::user()->role != 12) {
            if (!$request->merchant) {
                return back()->withErrors($validate->errors());
            }
            $merchant = Merchant::where('user_id', $request->merchant)->first();
        } else {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }




        Excel::import(new CsvsImport, $request->csv_file);

        //  return  session('session_data');


        if (session()->has('type_error_msg')) {

            return view('Admin.CsvImport.csv_file_upload');
        }

        Session::put('shop', $request->merchant);
        // $shop  =$request->shop;    
        $user_id  = $request->merchant;

        $district = BranchDistrict::where('z_id', $merchant->zone_id)
            ->orderBy('d_name', 'asc')
            ->get();

        $districts = BranchDistrict::where('z_id', $merchant->zone_id)
            ->orderBy('d_name', 'asc')
            ->first();

        $areas =  CoverageArea::where('zone_id', $merchant->zone_id)->where('district_id', $districts->d_id)->get();

        $zone_datas = CoverageArea::orderBy('zone_name', 'asc')->get()->unique('zone_name');
        $zones = CoverageArea::orderBy('zone_name', 'asc')->first();

        $area_datas = CoverageArea::orderBy('area', 'asc')->where('zone_name', $zones->zone_name)->get();


        $weights_prices = WeightPrice::orderBy('title', 'asc')->get();



        return view('Admin.CsvImport.data_show_merchants', compact('district', 'areas', 'zone_datas', 'area_datas', 'weights_prices', 'user_id', 'merchant'));
    }

    public function import_express_merchants(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt',

        ], [
            'csv_file.required' => 'Select your csv file',
            'csv_file.mimes' => 'Upload csv file only!',
        ]);


        if ($validate->fails()) {

            return back()->withErrors($validate->errors());
        }
        if (Auth::user()->role != 12) {
            if (!$request->merchant) {
                return back()->withErrors($validate->errors());
            }
            $merchant = Merchant::where('user_id', $request->merchant)->first();
        } else {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }




        Excel::import(new CsvsImport, $request->csv_file);

        //  return  session('session_data');


        if (session()->has('type_error_msg')) {

            return view('Admin.CsvImport.csv_file_upload');
        }

        Session::put('shop', $request->merchant);
        // $shop  =$request->shop;    
        $user_id  = $request->merchant;

        $district = BranchDistrict::where('z_id', $merchant->zone_id)
            ->orderBy('d_name', 'asc')
            ->get();

        $districts = BranchDistrict::where('z_id', $merchant->zone_id)
            ->orderBy('d_name', 'asc')
            ->first();

        $areas =  CoverageArea::where('zone_id', $merchant->zone_id)->where('district_id', $districts->d_id)->get();

        $zone_datas = CoverageArea::orderBy('zone_name', 'asc')->get()->unique('zone_name');
        $zones = CoverageArea::orderBy('zone_name', 'asc')->first();

        $area_datas = CoverageArea::orderBy('area', 'asc')->where('zone_name', $zones->zone_name)->get();


        $weights_prices = WeightPrice::orderBy('title', 'asc')->get();



        return view('Admin.CsvImport.data_show_express_merchants', compact('district', 'areas', 'zone_datas', 'area_datas', 'weights_prices', 'user_id', 'merchant'));
    }
    public function import(Request $request)
    {

        // dd($request->all());

        $validate = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt',

        ], [
            'csv_file.required' => 'Select your csv file',
            'csv_file.mimes' => 'Upload csv file only!',
        ]);


        if ($validate->fails()) {

            return back()->withErrors($validate->errors());
        }
        if (Auth::user()->role != 12) {
            if (!$request->merchant) {
                return back()->withErrors($validate->errors());
            }
            $merchant = Merchant::where('user_id', $request->merchant)->first();
        } else {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }




        Excel::import(new CsvsImport, $request->csv_file);

        //  return  session('session_data');


        if (session()->has('type_error_msg')) {

            return view('Admin.CsvImport.csv_file_upload');
        }

        Session::put('shop', $request->merchant);
        // $shop  =$request->shop;    
        $user_id  = $request->merchant;

        $zone_datas = CoverageArea::orderBy('zone_name', 'asc')->get()->unique('zone_name');

        $zones = CoverageArea::orderBy('zone_name', 'asc')->first();

        $area_datas = CoverageArea::orderBy('area', 'asc')->where('zone_name', $zones->zone_name)->get();

        $weights_prices = WeightPrice::orderBy('title', 'asc')->get();



        return view('Admin.CsvImport.data_show', compact('zone_datas', 'area_datas', 'weights_prices', 'user_id', 'merchant'));
    }

    public function import_express(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt',

        ], [
            'csv_file.required' => 'Select your csv file',
            'csv_file.mimes' => 'Upload csv file only!',
        ]);


        if ($validate->fails()) {

            return back()->withErrors($validate->errors());
        }
        if (Auth::user()->role != 12) {
            if (!$request->merchant) {
                return back()->withErrors($validate->errors());
            }
            $merchant = Merchant::where('user_id', $request->merchant)->first();
        } else {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
        }




        Excel::import(new CsvsImport, $request->csv_file);

        //  return  session('session_data');


        if (session()->has('type_error_msg')) {

            return view('Admin.CsvImport.csv_file_upload');
        }

        Session::put('shop', $request->merchant);
        // $shop  =$request->shop;    
        $user_id  = $request->merchant;

        $zone_datas = CoverageArea::orderBy('zone_name', 'asc')->get()->unique('zone_name');

        $zones = CoverageArea::orderBy('zone_name', 'asc')->first();

        $area_datas = CoverageArea::orderBy('area', 'asc')->where('zone_name', $zones->zone_name)->get();

        $weights_prices = WeightPrice::orderBy('title', 'asc')->get();



        return view('Admin.CsvImport.data_show_express', compact('zone_datas', 'area_datas', 'weights_prices', 'user_id', 'merchant'));
    }

    public function submit(Request $request)
    {

          
        for ($i = 0; $i < count($request->data); $i++) {

            $covarage_area = CoverageArea::where('zone_name', $request->data[$i][6])->where('area', $request->data[$i][7])->first();
            
            $weight_price = WeightPrice::where('title', $request->data[$i][8])->first();
           
            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //     ->join('shops','shops.id','employees.shop_id')
            //    ->join('merchants','merchants.user_id','employees.merchant_id')
            //     -> select('employees.*','shops.*','merchants.*')
            //    ->first();

            $collection = $request->data[$i][5];
            $district = $covarage_area->district;
            $inside = $covarage_area->inside;
            
            // if(Auth::user()->role==14){
            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //         ->join('shops','shops.id','employees.shop_id')
            //     ->join('merchants','merchants.user_id','employees.merchant_id')
            //         -> select('employees.*','shops.*','merchants.*')
            //     ->first();
            //     $shop=$shopInfo->shop_name;
            //     $user_id = $shopInfo->merchant_id;
            // }else{
            //     $shop=$request->data[$i][9];
            //     $shopInfo = Merchant::where('merchants.user_id',Auth::user()->id) ->first();
            //     //$shop=Session::get('shop');
            //     $user_id = $shopInfo->user_id;
            // }
            if (Auth::user()->role == 12) {

                $shopInfo = Merchant::where('merchants.user_id', Auth::user()->id)->first();
                $user_id = $shopInfo->user_id;
            } else {
                $user_id = $request->user_id;
                $shopInfo = Merchant::where('merchants.user_id', $user_id)->first();
            }

           

            //Merchant 
            $m_discount = $shopInfo->m_discount;
            $outside_discount = $shopInfo->outside_dhaka_regular;
            $sub_discount = $shopInfo->sub_dhaka_regular;

            $outside_return_discount = $shopInfo->return_outside_dhaka_discount;
            $inside_return_discount = $shopInfo->return_inside_dhaka_discount;
            $sub_return_discount = $shopInfo->return_sub_dhaka_discount;



         

            /* city calculation */

            $inside_city_regular_discount = $shopInfo->m_ind_city_Re;
            $outside_city_regular_discount = $shopInfo->m_out_city_Re;
            $subcity_city_regular_discount = $shopInfo->m_sub_city_Re;


            // if ($covarage_area->inside === 0) {
            //     //outside-Dhaka

            //     $delivery = $weight_price->out_Re  - $outside_discount;
                
                 
              
            //     $return = $weight_price->out_ReC - $outside_return_discount;
            // } elseif ($covarage_area->inside === 1) {
            //     //Inside Dhaka

            //     $delivery = $weight_price->ind_Re - $m_discount;
               
            //     $return = $weight_price->ind_ReC - $inside_return_discount;
            // } elseif ($covarage_area->inside === 2) {
            //     //Sub Dhaka
            //     $delivery = $weight_price->sub_Re - $sub_discount;
            //     $return = $weight_price->sub_ReC - $sub_return_discount;
            // }
            
    //  if (isset($covarage_area->inside)) {
    //     switch ($covarage_area->inside) {
    //     case 0: // Outside Dhaka
    //         $delivery = $weight_price->out_Re - $outside_discount;
    //         $return = $weight_price->out_ReC - $outside_return_discount;
    //         break;

    //     case 1: // Inside Dhaka
    //         $delivery = $weight_price->ind_Re - $m_discount;
    //         $return = $weight_price->ind_ReC - $inside_return_discount;
    //         break;

    //     case 2: // Sub Dhaka
    //         $delivery = $weight_price->sub_Re - $sub_discount;
    //         $return = $weight_price->sub_ReC - $sub_return_discount;
    //         break;

    //     default:
    //                 throw new Exception("Invalid coverage area value: {$covarage_area->inside}");
    //         }
    //     } else {
    //         throw new Exception("Coverage area value is not set.");
    //     }


            /*City Calculation*/

            // if ($covarage_area->city_track === 5) {
            //     //outside-city
            //     $delivery = $weight_price->out_city_Re  - $outside_city_regular_discount;
            //     $return = $weight_price->out_ReC - $outside_return_discount;
            // } elseif ($covarage_area->city_track === 3) {
            //     //Inside city
            //     $delivery = $weight_price->ind_city_Re - $inside_city_regular_discount;
            //     $return = $weight_price->ind_ReC - $inside_return_discount;
            // } elseif ($covarage_area->city_track === 4) {
            //     //Sub city
            //     $delivery = $weight_price->sub_city_Re - $subcity_city_regular_discount;
            //     $return = $weight_price->sub_ReC - $sub_return_discount;
            // }




            /*calculate cod*/
            // if ($covarage_area->inside === 0) {
            //     //outside
            //     $m_cod = (($collection) * $shopInfo->m_outside_dhaka_cod) / 100;
            //     $co = $weight_price->outside_dhaka_cod;
            //     $cod = (($collection - $delivery) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->inside === 1) {
            //     //inside
            //     $m_cod = (($collection) * $shopInfo->m_cod) / 100;
            //     $co = $weight_price->cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->inside === 2) {
            //     //sub
            //     $m_cod = (($collection) * $shopInfo->m_sub_dhaka_cod) / 100;
            //     $co = $weight_price->sub_dhaka_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // }
            
            // Ensure necessary variables like $collection, $delivery, and $shopInfo are properly defined before this block
        //     if (!isset($covarage_area->inside)) {
        //         throw new Exception("Coverage area information is missing.");
        //     }
            
        //     switch ($covarage_area->inside) {
        //         case 0: // Outside Dhaka
        //             $m_cod = ($collection * $shopInfo->m_outside_dhaka_cod) / 100;
        //             $co = $weight_price->outside_dhaka_cod;
        //             $cod = (($collection - $delivery) * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
            
        //         case 1: // Inside Dhaka
        //             $m_cod = ($collection * $shopInfo->m_cod) / 100;
        //             $co = $weight_price->cod;
        //             $cod = ($collection * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
            
        //         case 2: // Sub Dhaka
        //             $m_cod = ($collection * $shopInfo->m_sub_dhaka_cod) / 100;
        //             $co = $weight_price->sub_dhaka_cod;
        //             $cod = ($collection * $co) / 100;
        //             $fCod = $cod - $m_cod;
        //             break;
            
        //         default:
        //             throw new Exception("Invalid coverage area value.");
        //     }

        //   // Ensure to handle the calculated $fCod appropriately after this block



            /*calculate cod city*/

            // if ($covarage_area->city_track === 5) {
            //     //outside
            //     $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
            //     $co = $weight_price->outside_city_cod;
            //     $cod = (($collection - $delivery) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->city_track === 3) {
            //     //inside
            //     $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
            //     $co = $weight_price->inside_city_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->city_track === 4) {
            //     //sub
            //     $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
            //     $co = $weight_price->sub_city_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // }


            if (isset($covarage_area->inside)) {
                // Coverage area-based calculation
                switch ($covarage_area->inside) {
                    case 0: // Outside Dhaka
                        $delivery = $weight_price->out_Re - $outside_discount;
                        $return = $weight_price->out_ReC - $outside_return_discount;
                        break;
            
                    case 1: // Inside Dhaka
                        $delivery = $weight_price->ind_Re - $m_discount;
                        $return = $weight_price->ind_ReC - $inside_return_discount;
                        break;
            
                    case 2: // Sub Dhaka
                        $delivery = $weight_price->sub_Re - $sub_discount;
                        $return = $weight_price->sub_ReC - $sub_return_discount;
                        break;
            
                    default:
                        throw new Exception("Invalid coverage area value: {$covarage_area->inside}");
                }
            } elseif (isset($covarage_area->city_track)) {
                // City track-based calculation
                switch ($covarage_area->city_track) {
                    case 5: // Outside City
                        $delivery = $weight_price->out_city_Re - $outside_city_regular_discount;
                        $return = $weight_price->out_ReC - $outside_return_discount;
                        break;
            
                    case 3: // Inside City
                        $delivery = $weight_price->ind_city_Re - $inside_city_regular_discount;
                        $return = $weight_price->ind_ReC - $inside_return_discount;
                        break;
            
                    case 4: // Sub City
                        $delivery = $weight_price->sub_city_Re - $subcity_city_regular_discount;
                        $return = $weight_price->sub_ReC - $sub_return_discount;
                        break;
            
                    default:
                        throw new Exception("Invalid city track value: {$covarage_area->city_track}");
                }
            } else {
                throw new Exception("Coverage area or city track value is not set.");
            }
            
            if (isset($covarage_area->inside)) {
                // Coverage area-based COD calculation
                switch ($covarage_area->inside) {
                    case 0: // Outside Dhaka
                        $m_cod = ($collection * $shopInfo->m_outside_dhaka_cod) / 100;
                        $co = $weight_price->outside_dhaka_cod;
                        $cod = (($collection - $delivery) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 1: // Inside Dhaka
                        $m_cod = ($collection * $shopInfo->m_cod) / 100;
                        $co = $weight_price->cod;
                        $cod = ($collection * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 2: // Sub Dhaka
                        $m_cod = ($collection * $shopInfo->m_sub_dhaka_cod) / 100;
                        $co = $weight_price->sub_dhaka_cod;
                        $cod = ($collection * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    default:
                        throw new Exception("Invalid coverage area value.");
                }
            } elseif (isset($covarage_area->city_track)) {
                // City-based COD calculation
                switch ($covarage_area->city_track) {
                    case 5: // Outside City
                        $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
                        $co = $weight_price->outside_city_cod;
                        $cod = (($collection - $delivery) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 3: // Inside City
                        $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
                        $co = $weight_price->inside_city_cod;
                        $cod = (($collection) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 4: // Sub City
                        $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
                        $co = $weight_price->sub_city_cod;
                        $cod = (($collection) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    default:
                        throw new Exception("Invalid city track value.");
                }
            } else {
                throw new Exception("Coverage area or city track value is not set.");
            }
            
            // Handle or return $fCod after the conditional logic
            
            //Calculate Merchant Cod And Insurance

            $m_insurance =  (($collection - $delivery) * $shopInfo->m_insurance) / 100;
            //Calculate Weight Price Cod And Insurance

            $ins = $weight_price->insurance;

            $insurance = (($collection - $delivery) * $ins) / 100;

            //final Cod Insurance after minus Merchant Cod and Insurance

            $fInsurance = $insurance - $m_insurance;

            //Mercahnt Pay
            $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));

            $order = new Order;

            $order->user_id = $shopInfo->user_id;

            //tracking id generate
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }
            $company = Company::orderBy('id', 'DESC')->first();
            $h = $company->company_initial;
            $id = $user_id;  //Auth::user()->id;
            $s = $sl + 1;
            $dat = date('y');
            // $rand_code = rand(11, 99);
            $track = $h . $id . $dat . $s;

            $order->tracking_id = $track;
            $order->order_id = $request->data[$i][0];
            $order->customer_name = $request->data[$i][1];
            $order->customer_phone = $request->data[$i][2];
            $order->customer_address = $request->data[$i][3];
            $order->product = $request->data[$i][4];
            $order->collection = $request->data[$i][5];
            // $order->zone = $request->data[$i][7];
            $order->area = $request->data[$i][7];
            $order->weight = $request->data[$i][8];
            $order->remarks = $request->data[$i][9];
            $order->category = 'Category';
            $order->type = 'Regular';
            $order->district = $district;
            $order->pickup_date = date('Y-m-d');
            $order->shop = $shopInfo->business_name;
            $order->inside = $inside;
            $order->isPartial = 1;
            $order->status = 'Order Placed';
            // $order->shop_id   = Shop::where('shop_name',$shop)->first()->id;
            $order->shop_id = 0;
            $order->area_id   = CoverageArea::where('area', $request->data[$i][7])->first()->id;
            $order->save();
            // return json_encode($order);  


            $orderconfirm = new OrderConfirm;
            $orderconfirm->tracking_id = $track;
            $orderconfirm->colection = $collection;
            $orderconfirm->delivery = $delivery;
            $orderconfirm->insurance = $fInsurance;
            $orderconfirm->cod = $fCod;
            $orderconfirm->merchant_pay = $m_pay;
            $orderconfirm->return_charge = $return;
            $orderconfirm->save();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $track;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Order Placed';
            $data->save();
        }


        session()->forget('session_data');

        return json_encode(array('data' => 'data saved'));
    }

    public function submit_regular_merchants(Request $request)
    {
        for ($i = 0; $i < count($request->data); $i++) {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
            $covarage_area = CoverageArea::where('zone_id', $merchant->zone_id)->where('area', $request->data[$i][7])->first();
            $weight_price = WeightPrice::where('title', $request->data[$i][8])->first();

            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //     ->join('shops','shops.id','employees.shop_id')
            //    ->join('merchants','merchants.user_id','employees.merchant_id')
            //     -> select('employees.*','shops.*','merchants.*')
            //    ->first();

            $collection = $request->data[$i][5];
            $district = $covarage_area->district;
            $inside = $covarage_area->inside;

            // if(Auth::user()->role==14){
            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //         ->join('shops','shops.id','employees.shop_id')
            //     ->join('merchants','merchants.user_id','employees.merchant_id')
            //         -> select('employees.*','shops.*','merchants.*')
            //     ->first();
            //     $shop=$shopInfo->shop_name;
            //     $user_id = $shopInfo->merchant_id;
            // }else{
            //     $shop=$request->data[$i][9];
            //     $shopInfo = Merchant::where('merchants.user_id',Auth::user()->id) ->first();
            //     //$shop=Session::get('shop');
            //     $user_id = $shopInfo->user_id;
            // }
            if (Auth::user()->role == 12) {

                $shopInfo = Merchant::where('merchants.user_id', Auth::user()->id)->first();
                $user_id = $shopInfo->user_id;
            } else {
                $user_id = $request->user_id;
                $shopInfo = Merchant::where('merchants.user_id', $user_id)->first();
            }



            //Merchant 
            $m_discount = $shopInfo->m_discount;
            $outside_discount = $shopInfo->outside_dhaka_regular;
            $sub_discount = $shopInfo->sub_dhaka_regular;

            $outside_return_discount = $shopInfo->return_outside_dhaka_discount;
            $inside_return_discount = $shopInfo->return_inside_dhaka_discount;
            $sub_return_discount = $shopInfo->return_sub_dhaka_discount;




            /* city calculation */

            $inside_city_regular_discount = $shopInfo->m_ind_city_Re;
            $outside_city_regular_discount = $shopInfo->m_out_city_Re;
            $subcity_city_regular_discount = $shopInfo->m_sub_city_Re;


            if ($covarage_area->inside === 0) {
                //outside-Dhaka

                $delivery = $weight_price->out_Re  - $outside_discount;
                $return = $weight_price->out_ReC - $outside_return_discount;
            } elseif ($covarage_area->inside === 1) {
                //Inside Dhaka

                $delivery = $weight_price->ind_Re - $m_discount;
                $return = $weight_price->ind_ReC - $inside_return_discount;
            } elseif ($covarage_area->inside === 2) {
                //Sub Dhaka
                $delivery = $weight_price->sub_Re - $sub_discount;
                $return = $weight_price->sub_ReC - $sub_return_discount;
            }

            /*City Calculation*/

            if ($covarage_area->city_track === 5) {
                //outside-city
                $delivery = $weight_price->out_city_Re  - $outside_city_regular_discount;
                $return = $weight_price->out_ReC - $outside_return_discount;
            } elseif ($covarage_area->city_track === 3) {
                //Inside city
                $delivery = $weight_price->ind_city_Re - $inside_city_regular_discount;
                $return = $weight_price->ind_ReC - $inside_return_discount;
            } elseif ($covarage_area->city_track === 4) {
                //Sub city
                $delivery = $weight_price->sub_city_Re - $subcity_city_regular_discount;
                $return = $weight_price->sub_ReC - $sub_return_discount;
            }




            /*calculate cod*/
            if ($covarage_area->inside === 0) {
                //outside
                $m_cod = (($collection) * $shopInfo->m_outside_dhaka_cod) / 100;
                $co = $weight_price->outside_dhaka_cod;
                $cod = (($collection - $delivery) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->inside === 1) {
                //inside
                $m_cod = (($collection) * $shopInfo->m_cod) / 100;
                $co = $weight_price->cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->inside === 2) {
                //sub
                $m_cod = (($collection) * $shopInfo->m_sub_dhaka_cod) / 100;
                $co = $weight_price->sub_dhaka_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            }


            /*calculate cod city*/

            if ($covarage_area->city_track === 5) {
                //outside
                $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
                $co = $weight_price->outside_city_cod;
                $cod = (($collection - $delivery) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->city_track === 3) {
                //inside
                $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
                $co = $weight_price->inside_city_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->city_track === 4) {
                //sub
                $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
                $co = $weight_price->sub_city_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            }




            //Calculate Merchant Cod And Insurance

            $m_insurance =  (($collection - $delivery) * $shopInfo->m_insurance) / 100;
            //Calculate Weight Price Cod And Insurance

            $ins = $weight_price->insurance;

            $insurance = (($collection - $delivery) * $ins) / 100;

            //final Cod Insurance after minus Merchant Cod and Insurance

            $fInsurance = $insurance - $m_insurance;

            //Mercahnt Pay
            $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));

            $order = new Order;

            $order->user_id = $shopInfo->user_id;

            //tracking id generate
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }
            $company = Company::orderBy('id', 'DESC')->first();
            $h = $company->company_initial;
            $id = $user_id;  //Auth::user()->id;
            $s = $sl + 1;
            $dat = date('y');
            // $rand_code = rand(11, 99);
            $track = $h . $id . $dat . $s;

            $order->tracking_id = $track;
            $order->order_id = $request->data[$i][0];
            $order->customer_name = $request->data[$i][1];
            $order->customer_phone = $request->data[$i][2];
            $order->customer_address = $request->data[$i][3];
            $order->product = $request->data[$i][4];
            $order->collection = $request->data[$i][5];
            // $order->zone = $request->data[$i][7];
            $order->area = $request->data[$i][7];
            $order->weight = $request->data[$i][8];
            $order->remarks = $request->data[$i][9];
            $order->category = 'Category';
            $order->type = 'Regular';
            $order->district = $district;
            $order->pickup_date = date('Y-m-d');
            $order->shop = $shopInfo->business_name;
            $order->inside = $inside;
            $order->isPartial = 1;
            $order->status = 'Order Placed';
            // $order->shop_id   = Shop::where('shop_name',$shop)->first()->id;
            $order->shop_id = 0;
            $order->area_id   = CoverageArea::where('area', $request->data[$i][7])->first()->id;
            $order->save();
            // return json_encode($order);  


            $orderconfirm = new OrderConfirm;
            $orderconfirm->tracking_id = $track;
            $orderconfirm->colection = $collection;
            $orderconfirm->delivery = $delivery;
            $orderconfirm->insurance = $fInsurance;
            $orderconfirm->cod = $fCod;
            $orderconfirm->merchant_pay = $m_pay;
            $orderconfirm->return_charge = $return;
            $orderconfirm->save();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $track;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Order Placed';
            $data->save();
        }


        session()->forget('session_data');

        return json_encode(array('data' => 'data saved'));
    }


    public function submit_express(Request $request)
    {


        for ($i = 0; $i < count($request->data); $i++) {

            $covarage_area = CoverageArea::where('zone_name', $request->data[$i][6])->where('area', $request->data[$i][7])->first();
            $weight_price = WeightPrice::where('title', $request->data[$i][8])->first();

            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //     ->join('shops','shops.id','employees.shop_id')
            //    ->join('merchants','merchants.user_id','employees.merchant_id')
            //     -> select('employees.*','shops.*','merchants.*')
            //    ->first();

            $collection = $request->data[$i][5];
            $district = $covarage_area->district;
            $inside = $covarage_area->inside;

            // if(Auth::user()->role==14){
            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //         ->join('shops','shops.id','employees.shop_id')
            //     ->join('merchants','merchants.user_id','employees.merchant_id')
            //         -> select('employees.*','shops.*','merchants.*')
            //     ->first();
            //     $shop=$shopInfo->shop_name;
            //     $user_id = $shopInfo->merchant_id;
            // }else{
            //     $shop=$request->data[$i][9];
            //     $shopInfo = Merchant::where('merchants.user_id',Auth::user()->id) ->first();
            //     //$shop=Session::get('shop');
            //     $user_id = $shopInfo->user_id;
            // }
            if (Auth::user()->role == 12) {

                $shopInfo = Merchant::where('merchants.user_id', Auth::user()->id)->first();
                $user_id = $shopInfo->user_id;
            } else {
                $user_id = $request->user_id;
                $shopInfo = Merchant::where('merchants.user_id', $user_id)->first();
            }



            //Merchant 
            $m_discount = $shopInfo->ur_discount;
            $outside_discount = $shopInfo->outside_dhaka_express;
            $sub_discount = $shopInfo->sub_dhaka_express;

            $outside_return_discount = $shopInfo->return_outside_dhaka_discount;
            $inside_return_discount = $shopInfo->return_inside_dhaka_discount;
            $sub_return_discount = $shopInfo->return_sub_dhaka_discount;

            /* City Collection */
            $inside_city_express_discount = $shopInfo->m_ind_city_Ur;
            $outside_city_express_discount = $shopInfo->m_out_City_Ur;
            $subcity_city_express_discount = $shopInfo->m_sub_city_Ur;


            // if ($covarage_area->inside === 0) {
            //     //outside-Dhaka

            //     $delivery = $weight_price->out_Ur  - $outside_discount;
            //     $return = $weight_price->out_ReC - $outside_return_discount;
            // } elseif ($covarage_area->inside === 1) {
            //     //Inside Dhaka

            //     $delivery = $weight_price->ind_Ur - $m_discount;
            //     $return = $weight_price->ind_ReC - $inside_return_discount;
            // } elseif ($covarage_area->inside === 2) {
            //     //Sub Dhaka
            //     $delivery = $weight_price->sub_Ur - $sub_discount;
            //     $return = $weight_price->sub_ReC - $sub_return_discount;
            // }
            //   if (isset($covarage_area->inside)) {
            //     switch ($covarage_area->inside) {
            //     case 0: // Outside Dhaka
            //         $delivery = $weight_price->out_Re - $outside_discount;
            //         $return = $weight_price->out_ReC - $outside_return_discount;
            //         break;
        
            //     case 1: // Inside Dhaka
            //         $delivery = $weight_price->ind_Re - $m_discount;
            //         $return = $weight_price->ind_ReC - $inside_return_discount;
            //         break;
        
            //     case 2: // Sub Dhaka
            //         $delivery = $weight_price->sub_Re - $sub_discount;
            //         $return = $weight_price->sub_ReC - $sub_return_discount;
            //         break;
        
            //     default:
            //                 throw new Exception("Invalid coverage area value: {$covarage_area->inside}");
            //         }
            //     } else {
            //         throw new Exception("Coverage area value is not set.");
            //     }


            // if ($covarage_area->city_track === 5) {
            //     //outside-Dhaka

            //     $delivery = $weight_price->out_Ur  - $outside_city_express_discount;
            //     $return = $weight_price->out_ReC - $outside_return_discount;
            // } elseif ($covarage_area->city_track === 3) {
            //     //Inside Dhaka

            //     $delivery = $weight_price->ind_Ur - $inside_city_express_discount;
            //     $return = $weight_price->ind_ReC - $inside_return_discount;
            // } elseif ($covarage_area->city_track === 4) {
            //     //Sub Dhaka
            //     $delivery = $weight_price->sub_Ur - $sub_discount;
            //     $return = $weight_price->sub_ReC - $subcity_city_express_discount;
            // }


            /*calculate cod*/
            // if ($covarage_area->inside === 0) {
            //     //outside
            //     $m_cod = (($collection) * $shopInfo->m_outside_dhaka_cod) / 100;
            //     $co = $weight_price->outside_dhaka_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->inside === 1) {
            //     //inside
            //     $m_cod = (($collection) * $shopInfo->m_cod) / 100;
            //     $co = $weight_price->cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->inside === 2) {
            //     //sub
            //     $m_cod = (($collection) * $shopInfo->m_sub_dhaka_cod) / 100;
            //     $co = $weight_price->sub_dhaka_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // }
            
            // if (!isset($covarage_area->inside)) {
            //     throw new Exception("Coverage area information is missing.");
            // }
            
            // switch ($covarage_area->inside) {
            //     case 0: // Outside Dhaka
            //         $m_cod = ($collection * $shopInfo->m_outside_dhaka_cod) / 100;
            //         $co = $weight_price->outside_dhaka_cod;
            //         $cod = (($collection - $delivery) * $co) / 100;
            //         $fCod = $cod - $m_cod;
            //         break;
            
            //     case 1: // Inside Dhaka
            //         $m_cod = ($collection * $shopInfo->m_cod) / 100;
            //         $co = $weight_price->cod;
            //         $cod = ($collection * $co) / 100;
            //         $fCod = $cod - $m_cod;
            //         break;
            
            //     case 2: // Sub Dhaka
            //         $m_cod = ($collection * $shopInfo->m_sub_dhaka_cod) / 100;
            //         $co = $weight_price->sub_dhaka_cod;
            //         $cod = ($collection * $co) / 100;
            //         $fCod = $cod - $m_cod;
            //         break;
            
            //     default:
            //         throw new Exception("Invalid coverage area value.");
            // }

            // /*calculate cod city*/

            // if ($covarage_area->city_track === 5) {
            //     //outside
            //     $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
            //     $co = $weight_price->outside_city_cod;
            //     $cod = (($collection - $delivery) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->city_track === 3) {
            //     //inside
            //     $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
            //     $co = $weight_price->inside_city_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // } elseif ($covarage_area->city_track === 4) {
            //     //sub
            //     $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
            //     $co = $weight_price->sub_city_cod;
            //     $cod = (($collection) * $co) / 100;
            //     $fCod = $cod - $m_cod;
            // }

            if (isset($covarage_area->inside)) {
                // Coverage area-based calculations
                switch ($covarage_area->inside) {
                    case 0: // Outside Dhaka
                        $delivery = $weight_price->out_Re - $outside_discount;
                        $return = $weight_price->out_ReC - $outside_return_discount;
                        break;
            
                    case 1: // Inside Dhaka
                        $delivery = $weight_price->ind_Re - $m_discount;
                        $return = $weight_price->ind_ReC - $inside_return_discount;
                        break;
            
                    case 2: // Sub Dhaka
                        $delivery = $weight_price->sub_Re - $sub_discount;
                        $return = $weight_price->sub_ReC - $sub_return_discount;
                        break;
            
                    default:
                        throw new Exception("Invalid coverage area value: {$covarage_area->inside}");
                }
            } elseif (isset($covarage_area->city_track)) {
                // City track-based calculations
                switch ($covarage_area->city_track) {
                    case 5: // Outside Dhaka (Express Delivery)
                        $delivery = $weight_price->out_Ur - $outside_city_express_discount;
                        $return = $weight_price->out_ReC - $outside_return_discount;
                        break;
            
                    case 3: // Inside Dhaka (Express Delivery)
                        $delivery = $weight_price->ind_Ur - $inside_city_express_discount;
                        $return = $weight_price->ind_ReC - $inside_return_discount;
                        break;
            
                    case 4: // Sub Dhaka (Express Delivery)
                        $delivery = $weight_price->sub_Ur -  $subcity_city_express_discount;
                        $return = $weight_price->sub_ReC -  $sub_return_discount;
                        break;
            
                    default:
                        throw new Exception("Invalid city track value: {$covarage_area->city_track}");
                }
            } else {
                throw new Exception("Coverage area or city track value is not set.");
            }
            
            // Handle $delivery and $return after the condition blocks
            

            //Calculate Merchant Cod And Insurance
            if (isset($covarage_area->inside)) {
                // Coverage area-based COD calculation
                switch ($covarage_area->inside) {
                    case 0: // Outside Dhaka
                        $m_cod = ($collection * $shopInfo->m_outside_dhaka_cod) / 100;
                        $co = $weight_price->outside_dhaka_cod;
                        $cod = (($collection - $delivery) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 1: // Inside Dhaka
                        $m_cod = ($collection * $shopInfo->m_cod) / 100;
                        $co = $weight_price->cod;
                        $cod = ($collection * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 2: // Sub Dhaka
                        $m_cod = ($collection * $shopInfo->m_sub_dhaka_cod) / 100;
                        $co = $weight_price->sub_dhaka_cod;
                        $cod = ($collection * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    default:
                        throw new Exception("Invalid coverage area value.");
                }
            } elseif (isset($covarage_area->city_track)) {
                // City-based COD calculation
                switch ($covarage_area->city_track) {
                    case 5: // Outside City
                        $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
                        $co = $weight_price->outside_city_cod;
                        $cod = (($collection - $delivery) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 3: // Inside City
                        $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
                        $co = $weight_price->inside_city_cod;
                        $cod = (($collection) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    case 4: // Sub City
                        $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
                        $co = $weight_price->sub_city_cod;
                        $cod = (($collection) * $co) / 100;
                        $fCod = $cod - $m_cod;
                        break;
            
                    default:
                        throw new Exception("Invalid city track value.");
                }
            } else {
                throw new Exception("Coverage area or city track value is not set.");
            }
            
            // Handle or return $fCod after the conditional logic
            
            $m_insurance =  (($collection - $delivery) * $shopInfo->m_insurance) / 100;
            //Calculate Weight Price Cod And Insurance

            $ins = $weight_price->insurance;

            $insurance = (($collection - $delivery) * $ins) / 100;

            //final Cod Insurance after minus Merchant Cod and Insurance

            $fInsurance = $insurance - $m_insurance;

            //Mercahnt Pay
            $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));

            $order = new Order;

            $order->user_id = $shopInfo->user_id;

            //tracking id generate
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }
            $company = Company::orderBy('id', 'DESC')->first();
            $h = $company->company_initial;
            $id = $user_id;  //Auth::user()->id;
            $s = $sl + 1;
            $dat = date('y');
            // $rand_code = rand(11, 99);
            $track = $h . $id . $dat . $s;

            $order->tracking_id = $track;
            $order->order_id = $request->data[$i][0];
            $order->customer_name = $request->data[$i][1];
            $order->customer_phone = $request->data[$i][2];
            $order->customer_address = $request->data[$i][3];
            $order->product = $request->data[$i][4];
            $order->collection = $request->data[$i][5];
            // $order->zone = $request->data[$i][7];
            $order->area = $request->data[$i][7];
            $order->weight = $request->data[$i][8];
            $order->remarks = $request->data[$i][9];
            $order->category = 'Category';
            $order->type = 'Urgent';
            $order->district = $district;
            $order->pickup_date = date('Y-m-d');
            $order->shop = $shopInfo->business_name;
            $order->inside = $inside;
            $order->isPartial = 1;
            $order->status = 'Order Placed';
            // $order->shop_id   = Shop::where('shop_name',$shop)->first()->id;
            $order->shop_id = 0;
            $order->area_id   = CoverageArea::where('area', $request->data[$i][7])->first()->id;
            $order->save();
            // return json_encode($order);  


            $orderconfirm = new OrderConfirm;
            $orderconfirm->tracking_id = $track;
            $orderconfirm->colection = $collection;
            $orderconfirm->delivery = $delivery;
            $orderconfirm->insurance = $fInsurance;
            $orderconfirm->cod = $fCod;
            $orderconfirm->merchant_pay = $m_pay;
            $orderconfirm->return_charge = $return;
            $orderconfirm->save();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $track;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Order Placed';
            $data->save();
        }


        session()->forget('session_data');

        return json_encode(array('data' => 'data saved'));
    }

    public function submit_express_merchants(Request $request)
    {

        for ($i = 0; $i < count($request->data); $i++) {
            $merchant = Merchant::where('user_id', Auth::user()->id)->first();
            $covarage_area = CoverageArea::where('zone_id', $merchant->zone_id)->where('area', $request->data[$i][7])->first();
            $weight_price = WeightPrice::where('title', $request->data[$i][8])->first();

            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //     ->join('shops','shops.id','employees.shop_id')
            //    ->join('merchants','merchants.user_id','employees.merchant_id')
            //     -> select('employees.*','shops.*','merchants.*')
            //    ->first();

            $collection = $request->data[$i][5];
            $district = $covarage_area->district;
            $inside = $covarage_area->inside;

            // if(Auth::user()->role==14){
            //     $shopInfo = Employee::where('employees.user_id',Auth::user()->id)
            //         ->join('shops','shops.id','employees.shop_id')
            //     ->join('merchants','merchants.user_id','employees.merchant_id')
            //         -> select('employees.*','shops.*','merchants.*')
            //     ->first();
            //     $shop=$shopInfo->shop_name;
            //     $user_id = $shopInfo->merchant_id;
            // }else{
            //     $shop=$request->data[$i][9];
            //     $shopInfo = Merchant::where('merchants.user_id',Auth::user()->id) ->first();
            //     //$shop=Session::get('shop');
            //     $user_id = $shopInfo->user_id;
            // }
            if (Auth::user()->role == 12) {

                $shopInfo = Merchant::where('merchants.user_id', Auth::user()->id)->first();
                $user_id = $shopInfo->user_id;
            } else {
                $user_id = $request->user_id;
                $shopInfo = Merchant::where('merchants.user_id', $user_id)->first();
            }



            //Merchant 
            $m_discount = $shopInfo->ur_discount;
            $outside_discount = $shopInfo->outside_dhaka_express;
            $sub_discount = $shopInfo->sub_dhaka_express;

            $outside_return_discount = $shopInfo->return_outside_dhaka_discount;
            $inside_return_discount = $shopInfo->return_inside_dhaka_discount;
            $sub_return_discount = $shopInfo->return_sub_dhaka_discount;

            /* City Collection */
            $inside_city_express_discount = $shopInfo->m_ind_city_Ur;
            $outside_city_express_discount = $shopInfo->m_out_City_Ur;
            $subcity_city_express_discount = $shopInfo->m_sub_city_Ur;


            if ($covarage_area->inside === 0) {
                //outside-Dhaka

                $delivery = $weight_price->out_Ur  - $outside_discount;
                $return = $weight_price->out_ReC - $outside_return_discount;
            } elseif ($covarage_area->inside === 1) {
                //Inside Dhaka

                $delivery = $weight_price->ind_Ur - $m_discount;
                $return = $weight_price->ind_ReC - $inside_return_discount;
            } elseif ($covarage_area->inside === 2) {
                //Sub Dhaka
                $delivery = $weight_price->sub_Ur - $sub_discount;
                $return = $weight_price->sub_ReC - $sub_return_discount;
            }


            if ($covarage_area->city_track === 5) {
                //outside-Dhaka

                $delivery = $weight_price->out_Ur  - $outside_city_express_discount;
                $return = $weight_price->out_ReC - $outside_return_discount;
            } elseif ($covarage_area->city_track === 3) {
                //Inside Dhaka

                $delivery = $weight_price->ind_Ur - $inside_city_express_discount;
                $return = $weight_price->ind_ReC - $inside_return_discount;
            } elseif ($covarage_area->city_track === 4) {
                //Sub Dhaka
                $delivery = $weight_price->sub_Ur - $sub_discount;
                $return = $weight_price->sub_ReC - $subcity_city_express_discount;
            }


            /*calculate cod*/
            if ($covarage_area->inside === 0) {
                //outside
                $m_cod = (($collection) * $shopInfo->m_outside_dhaka_cod) / 100;
                $co = $weight_price->outside_dhaka_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->inside === 1) {
                //inside
                $m_cod = (($collection) * $shopInfo->m_cod) / 100;
                $co = $weight_price->cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->inside === 2) {
                //sub
                $m_cod = (($collection) * $shopInfo->m_sub_dhaka_cod) / 100;
                $co = $weight_price->sub_dhaka_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            }

            /*calculate cod city*/

            if ($covarage_area->city_track === 5) {
                //outside
                $m_cod = (($collection) * $shopInfo->m_outside_city_cod) / 100;
                $co = $weight_price->outside_city_cod;
                $cod = (($collection - $delivery) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->city_track === 3) {
                //inside
                $m_cod = (($collection) * $shopInfo->m_inside_city_cod) / 100;
                $co = $weight_price->inside_city_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            } elseif ($covarage_area->city_track === 4) {
                //sub
                $m_cod = (($collection) * $shopInfo->m_sub_city_cod) / 100;
                $co = $weight_price->sub_city_cod;
                $cod = (($collection) * $co) / 100;
                $fCod = $cod - $m_cod;
            }

            //Calculate Merchant Cod And Insurance

            $m_insurance =  (($collection - $delivery) * $shopInfo->m_insurance) / 100;
            //Calculate Weight Price Cod And Insurance

            $ins = $weight_price->insurance;

            $insurance = (($collection - $delivery) * $ins) / 100;

            //final Cod Insurance after minus Merchant Cod and Insurance

            $fInsurance = $insurance - $m_insurance;

            //Mercahnt Pay
            $m_pay = $collection - ($delivery + ceil($fCod)  + ceil($fInsurance));

            $order = new Order;

            $order->user_id = $shopInfo->user_id;

            //tracking id generate
            if ($last = Order::all()->last()) {
                $sl = $last->id;
            } else {
                $sl = 0;
            }
            $company = Company::orderBy('id', 'DESC')->first();
            $h = $company->company_initial;
            $id = $user_id;  //Auth::user()->id;
            $s = $sl + 1;
            $dat = date('y');
            // $rand_code = rand(11, 99);
            $track = $h . $id . $dat . $s;

            $order->tracking_id = $track;
            $order->order_id = $request->data[$i][0];
            $order->customer_name = $request->data[$i][1];
            $order->customer_phone = $request->data[$i][2];
            $order->customer_address = $request->data[$i][3];
            $order->product = $request->data[$i][4];
            $order->collection = $request->data[$i][5];
            // $order->zone = $request->data[$i][7];
            $order->area = $request->data[$i][7];
            $order->weight = $request->data[$i][8];
            $order->remarks = $request->data[$i][9];
            $order->category = 'Category';
            $order->type = 'Urgent';
            $order->district = $district;
            $order->pickup_date = date('Y-m-d');
            $order->shop = $shopInfo->business_name;
            $order->inside = $inside;
            $order->isPartial = 1;
            $order->status = 'Order Placed';
            // $order->shop_id   = Shop::where('shop_name',$shop)->first()->id;
            $order->shop_id = 0;
            $order->area_id   = CoverageArea::where('area', $request->data[$i][7])->first()->id;
            $order->save();
            // return json_encode($order);  


            $orderconfirm = new OrderConfirm;
            $orderconfirm->tracking_id = $track;
            $orderconfirm->colection = $collection;
            $orderconfirm->delivery = $delivery;
            $orderconfirm->insurance = $fInsurance;
            $orderconfirm->cod = $fCod;
            $orderconfirm->merchant_pay = $m_pay;
            $orderconfirm->return_charge = $return;
            $orderconfirm->save();

            $data = new OrderStatusHistory();
            $data->tracking_id  = $track;
            $data->user_id      = Auth::user()->id;
            $data->status       = 'Order Placed';
            $data->save();
        }


        session()->forget('session_data');

        return json_encode(array('data' => 'data saved'));
    }
}
