<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class CategoriesController extends Controller
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
            $data = Categories::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $class = 'badge bg-danger';
                    if($row->status == '1'){ $class = 'badge bg-success'; }
                    return '<span class="'.$class.'">'.$row->categories_status.'</span>';
                   
                })
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategories">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategories">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('admin.categories.index');
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
            'description' => 'required',
            'photo' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        
        if($validate->fails()){
            return response()->json(['error'=>$validate->errors()]);
           
        }
    
        try {    

            $file_name = ""; 
            if ($request->hasFile("photo")) {
                 $img = $request->file("photo");
                 $img->store('public/images/');
                 $file_name = $img->hashName();
            }

            Categories::create([
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $file_name,
                'status' => '1',  /* (1 for Active , 0 for Block) */
            ]);

            return response()->json(['success'=>'categories saved successfully.']);

        } catch (\Throwable $th) {
            return response()->json(['error'=>'Something went wrong.']);
        }
    }
  
    /**
     * Display the specified resource.
     *
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
        $categories = Categories::find($id);       
        if(!empty($categories->photo)){
          $categories['photo'] =  asset('storage/images/'.$categories->photo);
        }
        return response()->json($categories);
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request, $id)
    {
     
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'photo' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        try {
            if(!empty($id)){
              
                $status = '0';
                if($request->status == 'true'){ $status = '1'; } 
                $data =  Categories::find($id);
                $file_name = $data->photo;
                if ($request->hasFile("photo")) {
                    $img = $request->file("photo");
                    if (Storage::exists('public/images/' . $data->photo)) {
                        Storage::delete('public/images/' . $data->photo);
                    }
                    $img->store('public/images/');
                    $file_name = $img->hashName();
                  }
                $data_ = [
                    'name' => $request->name,
                    'status' => $status,  
                    'description' => $request->description,
                    'photo' => $file_name,
                ];
               
                $data->update($data_);
                return response()->json(['success'=>'categories saved successfully.']);
                
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
        Categories::find($id)->delete();
        return response()->json(['success'=>'categories deleted successfully.']);
    }
  
}
