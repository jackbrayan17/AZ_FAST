<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products for the Merchant Client or Admin
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $products = Product::with('category', 'images')->get();
        } elseif ($user->hasRole('Merchant Client')) {
            $products = Product::with('category', 'images')->where('user_id', $user->id)->get();
        }

        return view('products.index', compact('products'));
    }

    // Show form to create a product
    public function create($storefrontId)
    {
       // $this->authorize('create', Product::class);

        $categories = Category::all(); // Get all categories
       
        return view('products.create', compact('categories', 'storefrontId'));

    }

    // Store a new product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate images
            'storefront_id' => 'required|exists:storefronts,id',
            'merchant_id' => 'required|exists:merchants,id',
        ]);

        // Create the product
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'storefront_id' => $request->storefront_id,
            'merchant_id' => $request->merchant_id,     
            'category_id' => $request->category_id,
        ]);

       // Handle image uploads
       if ($request->hasFile('images')) {
        $index = 1; // Initialize an index for naming
        foreach ($request->file('images') as $image) {
            // Create a unique name for each image
            $imageName = strtolower(str_replace(' ', '_', $product->name)) . '_' . $index . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('product_images', $imageName, 'public'); // Store images with the new name
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);
            $index++; // Increment the index
        }
    }



    return redirect()->route('storefronts.show', $request->storefront_id)
    ->with('success', 'Product created successfully');
  }

    // Show form to edit a product
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all(); // Get all categories
        return view('products.edit', compact('product', 'categories'));
    }
// Show a specific product
public function show(Product $product)
{
    // Load the category and images for the product
    $product->load('category', 'images');

    return view('products.show', compact('product'));
}

    // Update an existing product in the database
    public function update(Request $request, Product $product)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Update product details
        $product->update($request->all());
    
        // Handle image deletion if requested
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::findOrFail($imageId);
                Storage::delete('public/' . $image->image_path);
                $image->delete();
            }
        }
    
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    

    // Delete a product
    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->image_path);
            $image->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
