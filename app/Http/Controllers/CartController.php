<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine_detail;
use App\Models\User;
use App\Models\Day;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function view(Request $request){
        $id = $request->input('id');
        $data = [

            'cartData' => array_column($request->session()->get('cartData'), 'session_machine_id', 'session_machine_id')
            // 'records' => Machine_detail::whereIn('machine_id', $id)->get()
        ];
        // dd($data);
        return view('cart', $data);
    }
    public function index(Request $request){
        $data = [
            'CartData' => $request->session()->get('cartData.session_machine_id'),
        ];
        // dd($data);
        return view('cart', $data);
    }
    /*
    |--------------------------------------------------------------------------
    | 商品詳細 → カート画面へのSession情報保存
    |--------------------------------------------------------------------------
    */
    public function addCart(Request $request,)
    {
        $id = $request->input('id');
        //使用状況を確認
        $i = Day::join('day_machine_detail', 'days.day', '=', 'day_machine_detail.day')
        ->join('machine_details', 'day_machine_detail.machine_id', '=', 'machine_details.machine_id')
        ->whereIn('machine_details.machine_id',$id)->get('machine_details.machine_id')->all();
        $inUse = array_column($i, 'machine_id');
            // $inUse = Machine_detail::where('machine_status', '!=', '待機中')->where('machine_id',$id)->get();
            // dd($inUse);

        if(!empty($inUse)){
            $request->session()->flash('inUse', $inUse);
            return redirect()->route('pctool.error')->withInput();
        }
        else{
            foreach($id as $i){
            $param=[
                'id' => $i
            ];
            DB::update('UPDATE machine_details SET `machine_status` = "仮押中" where `machine_id` = :id', $param);

            }
            $sessionCartData = [
                'user_id' => Auth::user()->id,
                'session_machine_id' => $id,
            ];
            // $sessionCartData += $request->session()->get('cartData');
            $request->session()->put('cartData', $sessionCartData);
            // dd($request->session());

            return redirect()->route('cart.index');
        }

        //商品詳細画面のhidden属性で送信（Request）された商品IDと注文個数を取得し配列として変数に格納
        //inputタグのname属性を指定し$requestからPOST送信された内容を取得する。
        foreach($request->id as $sid){
            $cartData = 
        [
            'session_machine_id' => $sid, 
            // 'session_quantity' => $request->product_quantity, 
        ];

        //sessionにcartData配列が「無い」場合、商品情報の配列をcartData(key)という名で$cartDataをSessionに追加
        if (!$request->session()->has('cartData')) {
            $request->session()->put('cartData', $cartData);
        } else {
            //sessionにcartData配列が「有る」場合、情報取得
            $sessionCartData = $request->session()->get('cartData');

            //isSameMachineId定義 product_id同一確認フラグ false = 同一ではない状態を指定
            $isSameMachineId = false;
            // foreach ($sessionCartData as $index => $sessionData) {
            //     //product_idが同一であれば、フラグをtrueにする → 個数の合算処理、及びセッション情報更新。更新は一度のみ
            //     if ($sessionData['session_machine_id'] === $cartData['session_machine_id'] ) {
            //         $isSameMachineId = true;
            //         // $quantity = $sessionData['session_quantity'] + $cartData['session_quantity'];
            //         //cartDataをrootとしたツリー状の多次元連想配列の特定のValueにアクセスし、指定の変数でValueの上書き処理
            //         // $request->session()->put('cartData.' . $index . '.session_quantity', $quantity);
            //         break;
            //     }
            // }

            //product_idが同一ではない状態を指定 その場合であればpushする
            if ($isSameMachineId === false) {
                $request->session()->push('cartData', $cartData);
            }
        }
        }
        //POST送信された情報をsessionに保存 'users_id'(key)に$request内の'users_id'をセット
        $request->session()->put('users_id', ($request->users_id));
        return redirect()->route('cart.index');
    }

    /*
    |--------------------------------------------------------------------------
    | カート内商品表示
    |--------------------------------------------------------------------------
    */
    // public function index(Request $request)
    // {
    //     //渡されたセッション情報をkey（名前）を用いそれぞれ取得、変数に代入
    //     $sessionUser = User::find($request->session()->get('users_id'));

    //     //removeメソッドでの配列削除時の配列連番抜け対策
    //     if ($request->session()->has('cartData')) {
    //         $cartData = array_values($request->session()->get('cartData'));
    //     }

    //     if (!empty($cartData)) {
    //         $sessionMachineId = array_column($cartData, 'session_machine_id');
    //         $product = Machine_detail::find($sessionMachineId);

    //         foreach ($cartData as $index => &$data) {
    //             //二次元目の配列を指定している$dataに'product〜'key生成 Modelオブジェクト内の各カラムを代入
    //             //＆で参照渡し 仮引数($data)の変更で実引数($cartData)を更新する
    //             $data['machine_name'] = $product[$index]->machine_name;
    //             $data['machine_spec'] = $product[$index]->machine_spec;
    //         }

    //         unset($data);

    //         return view('products.cartlist', compact('sessionUser', 'cartData'));

    //     } else {

    //         return view('products.no_cart_list',  ['user' => Auth::user()]);
    //     }
    // }

    /*
    |--------------------------------------------------------------------------
    | カート内商品の削除
    |--------------------------------------------------------------------------
    */

    public function remove(Request $request){
        //session情報の取得（product_idと個数の2次元配列）
        $sessionCartData = $request->session()->get('cartData');

        //削除ボタンから受け取ったproduct_idと個数を2次元配列に
        $removeCartItem = [
            ['session_machine_id' => $request->product_id, 
            'session_quantity' => $request->product_quantity]
        ];

        //sessionデータと削除対象データを比較、重複部分を削除し残りの配列を抽出
        $removeCompletedCartData = array_udiff($sessionCartData, $removeCartItem, function ($sessionCartData, $removeCartItem) {
            $result1 = $sessionCartData['session_machine_id'] - $removeCartItem['session_machine_id'];
            $result2 = $sessionCartData['session_quantity'] - $removeCartItem['session_quantity'];
            return $result1 + $result2;
        });

        //上記の抽出情報でcartDataを上書き処理
        $request->session()->put('cartData', $removeCompletedCartData);
        //上書き後のsession再取得
        $cartData = $request->session()->get('cartData');

        //session情報があればtrue
        if ($request->session()->has('cartData')) {
            return redirect()->route('cartlist.index');
        }

        return view('products.no_cart_list', ['user' => Auth::user()]);

    }

}
