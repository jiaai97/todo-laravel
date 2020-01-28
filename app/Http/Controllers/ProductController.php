<?php
  
namespace App\Http\Controllers;
  
use App\Product;
use Illuminate\Http\Request;
use Validator;
  
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::latest();

        if ($request->has('search')) {
            $products->where('name', $request->input('search'));
        }

        $products = $products->paginate(5);
  
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $posts = DB::table('products')->where('name', 'like', '%'.$search.'%')->paginate(5);
        return view('index', ['posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $v = Validator::make($data, [
            'name' => 'required',
            'detail' => 'required',
        ]);

        if ($v->fails()) {
            Session::flash('error', 'Validation fails');
            return back()->withInput($data);
        }

        Product::create($data);

        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $v = Validator::make($data, [
            'name' => 'required',
            'detail' => 'required',
        ]);

        if ($v->fails()) {
            Session::flash('error', 'Validation fails');
            return back()->withInput($data);
        }

        $product = Product::find($id);
  
        $product->update($data);
  
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
  
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}