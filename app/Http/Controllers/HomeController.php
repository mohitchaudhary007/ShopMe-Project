<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get all slides, status check was causing empty results
        $slides = Slide::all()->take(3);
        
        // Get some featured products for the home page
        $featuredProducts = Product::where('featured', 1)->take(8)->get();
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price','<>','')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured',1)->get()->take(8);
        return view('index',compact('slides', 'featuredProducts', 'categories', 'sproducts', 'fproducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name'=>'require|max:100',
            'email'=>'require|email',
            'phone'=>'require|numeric|digits:10',
            'comment'=>'require'
        ]);
        $contact = new contact();
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->phone=$request->phone;
        $contact->email=$request->email;
        $content->save();
        return redirect()->back()->with('success', 'Your message has been sent successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function about()
    {
        return view('about');
    }
}
