<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VentaRepository;

class VentasController extends Controller
{
    private $ventaRepository;

    public function __construct(VentaRepository $ventaRepository)
    {
        $this->ventaRepository    = $ventaRepository;
    }

    public function index()
    {
        return $this->ventaRepository->allVentas();
    }

    public function lista()
    {
        return view('ventas.lista');;
    }

    public function create()
    {
        $clientes = $this->ventaRepository->getClientes();
        $productos = $this->ventaRepository->getProductos();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $cliente = $this->ventaRepository->store($request->all());
        return $cliente;
    }
}
