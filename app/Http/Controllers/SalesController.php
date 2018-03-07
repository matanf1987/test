<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sales = \App\Sales::all();
        return view('sales/index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('sales/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $sales = new \App\Sales();
        $product_name = $request->get('product_name');
        $price = $request->get('price');
        $currency = $request->get('currency');

        $url = 'https://preprod.paymeservice.com/api/generate-sale';
        $arr = array(
            "seller_payme_id" => "MPL14985-68544Z1G-SPV5WK2K-0WJWHC7N", // Use this static ID
            "sale_price" => $price, // From input. Price is in cents
            "currency" => $currency, // From input
            "product_name" => $product_name, // From input
            "installments" => "1", // Constant value
            "language" => "en" // Constant value
        );


        $result = $this->curl_request($url, $arr);

        $result_arr = json_decode($result);

//        $status_code = $result_arr->status_code;
//        $sale_url = $result_arr->sale_url;
//        $payme_sale_id = $result_arr->payme_sale_id;
//        $payme_sale_code = $price = $result_arr->price;
//        $transaction_id = $result_arr->transaction_id;
//        $currency = $result_arr->currency;
        //print_r($result_arr);

        $sales->sale_number = $result_arr->payme_sale_code;
        $sales->description = $product_name;
        $sales->amount = $price;
        $sales->currency = $currency;
        $sales->payment_link = $result_arr->sale_url;
        $sales->save();

        return redirect('payment')->with('sale_url', $result_arr->sale_url);
    }

    public function payment() {
        return view('sales/payment');
    }

    private function curl_request($url, $arr) {

        $data_string = json_encode($arr);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        return curl_exec($ch);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
