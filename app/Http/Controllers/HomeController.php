<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('categories.index');
        return view('admin.dashboard.dashboard');
    }

    public function productList()
    {
        $product = Products::where('status','1')->get();
        return view('admin.products.list',compact('product'));
    }
}
