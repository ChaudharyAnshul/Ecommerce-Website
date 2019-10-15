<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\processors;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = processors::get();
        // return($products);
        return view('admin.products')->with('showproducts',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'serialNo' => 'required',
            'modelNo' => 'required',
            'category' => 'required',
            'productName' => 'required',
            'codeName' => 'required',
            'price' => 'required',
            'generation' => 'required',
            'cores' => 'required',
            'threads' => 'required',
            'baseSpeed' => 'required',
            'turboSpeed' => 'required',
            'cache' => 'required',     
            'compatibility' => 'required',
            'categoryId' => 'required',
            'p_image1' => 'image|max:1999',
            'p_image2' => 'image|nullable|max:1999',
            'p_image3' => 'image|nullable|max:1999',


        ]);
        
        //  Handle file upload

        if($request->hasFile('p_image1')){
            // Get File Name with Extension
            $fileNamewithExtension = $request->file('p_image1')->getClientOriginalName();
            // Get just File name
            $file = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('p_image1')->getClientOriginalExtension();
            // File Name to store 
            $fileNameToStore1 = $file.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('p_image1')->storeAs('public/processor_images', $fileNameToStore1);

        }else{
            $fileNameToStore1 = "noimagetostore.jpg"; 
        }
        if($request->hasFile('p_image2')){
            // Get File Name with Extension
            $fileNamewithExtension = $request->file('p_image2')->getClientOriginalName();
            // Get just File name
            $file = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('p_image2')->getClientOriginalExtension();
            // File Name to store 
            $fileNameToStore2 = $file.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('p_image2')->storeAs('public/processor_images', $fileNameToStore2);

        }else{
            $fileNameToStore2 = "noimagetostore.jpg"; 
        }
        if($request->hasFile('p_image3')){
            // Get File Name with Extension
            $fileNamewithExtension = $request->file('p_image3')->getClientOriginalName();
            // Get just File name
            $file = pathinfo($fileNamewithExtension, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('p_image3')->getClientOriginalExtension();
            // File Name to store 
            $fileNameToStore3 = $file.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('p_image3')->storeAs('public/processor_images', $fileNameToStore3);

        }else{
            $fileNameToStore3 = "noimagetostore.jpg"; 
        }

        $processor = new processors();
        $processor->serialNo = $request->input('serialNo');
        $processor->modelNo = $request->input('modelNo');
        $processor->title = $request->input('title');
        $processor->description = $request->input('description');
        $processor->brand = $request->input('category');
        $processor->productName = $request->input('productName');
        $processor->codeName = $request->input('codeName');
        $processor->price = $request->input('price');
        $processor->generation = $request->input('generation');
        $processor->cores = $request->input('cores');
        $processor->threads = $request->input('threads');
        $processor->baseSpeed = $request->input('baseSpeed');
        $processor->turboSpeed = $request->input('turboSpeed');
        $processor->cache = $request->input('cache');
        $processor->compatibility = $request->input('compatibility');
        $processor->categoryId = $request->input('categoryId');
        $processor->inStock = $request->input('inStock');
        $processor->p_image1 = $fileNameToStore1;
        $processor->p_image2 = $fileNameToStore2;
        $processor->p_image3 = $fileNameToStore3;
        
        $processor->save();
        return redirect('/admin/home')->with('success', 'Data saved');
        // return($request);
        
        // return('Store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return($id);
        $products = processors::get()->where('modelNo','=',$id);
        // return($products);
        $modelNo = $products[0]->modelNo;
        return view('admin.viewProduct')->with('viewproduct',($products[0]))->with('model', $modelNo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = processors::get()->where('modelNo','=',$id);
        // return($products);
        return view('admin.editProduct')->with('editproduct',($products[0]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'serialNo' => 'required',
            'modelNo' => 'required',
            'category' => 'required',
            'productName' => 'required',
            'codeName' => 'required',
            'price' => 'required',
            'generation' => 'required',
            'cores' => 'required',
            'threads' => 'required',
            'baseSpeed' => 'required',
            'turboSpeed' => 'required',
            'cache' => 'required',     
            'compatibility' => 'required',
            'categoryId' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $serialNo = $request->input('serialNo');
        $modelNo = $request->input('modelNo');
        $category = $request->input('category');
        $productName = $request->input('productName');
        $price = $request->input('price');
        $generation = $request->input('generation');
        $cores = $request->input('cores');
        $threads = $request->input('threads');
        $baseSpeed = $request->input('baseSpeed');
        $turboSpeed = $request->input('turboSpeed');
        $cache = $request->input('cache');
        $compatibility = $request->input('compatibility');
        $categoryId = $request->input('categoryId');

        $result = DB::table('processors')->update(['title' => $title, 'description' => $description, 'serialNo' => $serialNo, 'modelNo'=>$modelNo, 'categoryId'=>$category,'productName'=>$productName,'price'=>$price,'generation'=>$generation,'cores'=>$cores, 'threads'=>$threads, 'baseSpeed'=>$baseSpeed, 'cache'=>$cache,'turboSpeed'=>$turboSpeed,'compatibility'=>$compatibility,'categoryId'=>$categoryId   ]);

        if($result){
            return redirect('/admin/home')->with('success', 'Product details updated');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return("gg");
    }



    /**
     * 
     * Redirect to the admin page to delete old and obsolute products
     * @return \Illuminate\Http\Response
     */
    public function deleteproduct($id)
    {
        $result = processors::where('modelNo', '=', $id )->delete();
            if($result){
                return redirect('/admin/home')->with('success','Record has been deleted');
        }
        
    }


    /**
     * 
     * Redirect to the admin page to delete old and obsolute products
     * @return \Illuminate\Http\Response
     */
    public function addproduct()
    {
        return view('admin.addProducts');
    }


    /**
     * 
     * Redirect to the admin page to delete old and obsolute products
     * @return \Illuminate\Http\Response
     */
    public function addoffers()
    {
        return view("admin.addOffers");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProducts(Request $request){
        
        $this->validate($request,[
            'component'=>'required',
            'serialNo' => 'required'
        ]);
        if($request->input('component') == 'processors'){
            $pro = processors::where('serialno', '=', $request->input('serialNo'))->get();
            // return($pro[0]);
            if($pro[0]->p_image1 != 'noimagetostore.jpg'){
                // deleting img1
                Storage::delete('public/processor_images/'.$pro[0]->p_image1);
            }
            if($pro[0]->p_image2 != 'noimagetostore.jpg'){
                // deleting img1
                Storage::delete('public/processor_images/'.$pro[0]->p_image2);
            }
            if($pro[0]->p_image3 != 'noimagetostore.jpg'){
                // deleting img1
                Storage::delete('public/processor_images/'.$pro[0]->p_image3);
            }
            $result = processors::where('serialno', '=', $request->input('serialNo') )->delete();
            if($result){
                return redirect('/admin/home')->with('success','Record has been deleted');
            }
            // return($request->input('component'));
        }elseif($request->input('component') == 'gpu'){
            
            return($request->input('component'));
        }else{
            
            return($request->input('component'));
        }
    }
}
