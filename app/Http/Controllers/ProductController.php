<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $class = 'badge bg-danger';
                    if($row->status == '1'){ $class = 'badge bg-success'; }
                    return '<span class="'.$class.'">'.$row->product_status.'</span>';
                   
                })
               
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProducts">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProducts">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        $categories = Categories::where('status','1')->pluck('name','id');
        return view('admin.products.index',compact('categories'));
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'categories_id' => 'required',
            'price' =>  'required',
            'qty' => 'required',
            'description' =>'required',
        ]);
       
        if($validate->fails()){
            return response()->json(['error'=>$validate->errors()]);
        }
     
        try {   
           
            Products::create([
                'name' => $request->name,
                'categories_id' => $request->categories_id,
                'price' => $request->price,
                'qty' => $request->qty,
                'description' => $request->description,
                'status' => '1',  /* (1 for Active , 0 for Block) */
            ]);

            return response()->json(['success'=>'Product saved successfully.']);

        } catch (\Throwable $th) {
            return response()->json(['error'=>'Something went wrong.']);
        }
    }
  
    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
          
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Products::find($id);
         
        return response()->json($data);
    }
  
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $request->validate([
            'name' => 'required',
            'categories_id' => 'required',
            'price' =>  'required',
            'qty' => 'required',
            'description' =>'required',
        ]);

        try {
            if(!empty($id)){
               $data =  Products::find($id);
                $status = '0';
                if($request->status == 'true'){ $status = '1'; } 

                $value = [
                    'name' => $request->name,
                    'categories_id' => $request->categories_id,
                    'price' => $request->price,
                    'qty' => $request->qty,
                    'description' => $request->description,
                    'status' => $status,  
                ];
               
               $data->update($value);
                return response()->json(['success'=>'Products saved successfully.']);
                
            }else{
                return response()->json(['error'=>'Something went wrong.']);
            }
        } catch (\Throwable $th) {

            return response()->json(['error'=>'Something went wrong.']);

        }
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::find($id)->delete();
        return response()->json(['success'=>'Products deleted successfully.']);
    }
  
}
