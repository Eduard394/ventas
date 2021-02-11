<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductoRepository;
use App\Product;

class ProductController extends Controller
{

	// functions
	/** @var  convocatoriaRepository */
	private $productoRepository;

	public function __construct(ProductoRepository $productoRepository)
	{
		$this->productoRepository    = $productoRepository;
	}

	public function all()
	{
		return $this->productoRepository->allProducts();
	}

	public function formProduct()
	{
		return view('products.create');
	}


	public function store(Request $request)
	{
		$producto = $this->productoRepository->store($request->all());
		return $producto;
	}

	public function allProducts()
	{
		$products = Product::orderBy('name', 'asc')->paginate(10);
		return $products;
	}

	public function update(Request $request, $id)
	{
		$data     = $request->all();
		$convocatoria = $this->convocatoriaRepository->update($data, $id);
		return redirect()->back()->withSuccess('¡ convocatoria ' . $convocatoria . ' editado exitosamente !');
	}
}
