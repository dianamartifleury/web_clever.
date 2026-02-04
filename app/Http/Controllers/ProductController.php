<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Mostrar el dashboard con categorías y productos
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Cargar categorías con sus productos (filtrados si hay búsqueda)
        $categories = Category::with(['products' => function ($q) use ($query) {
            if ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('description', 'like', "%$query%");
            }
        }])
        ->orderBy('name')
        ->get();

        foreach ($categories as $category) {
            $category->setRelation('products', $category->products ?? collect());
        }

        return view('dashboard-products', compact('categories', 'query'));
    }

    /**
     * Mostrar formulario para crear un nuevo producto
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard-products-create', compact('categories'));
    }

    /**
     * Guardar un nuevo producto en la base de datos
     */
    public function store(Request $request)
{
    // Validación
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'stock' => 'nullable|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB
    ]);

    $data = $request->only(['name', 'description', 'stock', 'category_id']);

    // Subida de imagen si existe
    if ($request->hasFile('image_path') && $request->file('image_path')->isValid()) {
        $path = $request->file('image_path')->store('productos', 'public');
        $data['image_path'] = $path;
    }

    // Crear el producto
    Product::create($data);

    return redirect()->route('dashboard.products')
                     ->with('success', '✅ Producto añadido correctamente.');
}


    /**
     * Mostrar detalle de un producto para editar
     */
    public function show(Product $product)
    {
        return view('dashboard-products-show', compact('product'));
    }

    /**
     * Actualizar un producto completo
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'stock', 'category_id']);

        // Si sube una nueva imagen, guardarla y eliminar la antigua si existe
        if ($request->hasFile('image_path')) {
            // Eliminar imagen antigua
            if ($product->imagen) { 
                Storage::disk('public')->delete($product->imagen);
            }
            $path = $request->file('image_path')->store('productos', 'public');
            $data['image_path'] = $path;
        }

        $product->update($data);

        return redirect()->route('dashboard.products.show', $product)
                         ->with('success', '✅ Producto actualizado correctamente.');
    }

    /**
     * Mostrar vista de confirmación para eliminar un producto
     */
    public function confirmDelete(Product $product)
    {
        return view('dashboard-products-delete', compact('product'));
    }

    /**
     * Actualizar solo el stock
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->update(['stock' => $request->stock]);

        return redirect()->back()->with('success', '✅ Stock actualizado correctamente.');
    }

    /**
     * Eliminar un producto de la base de datos
     */
    public function destroy(Product $product)
    {
        // Borrar la imagen si existe
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }


        $product->delete();

        return redirect()->route('dashboard.products')->with('success', '🗑️ Producto eliminado correctamente.');
    }

    public function portfolio()
    {
        $categories = Category::with('products')->get();
        return view('portfolio', compact('categories'));
    }

}
