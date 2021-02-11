<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;

class ClientesController extends Controller
{
    // functions
    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository    = $clienteRepository;
    }

    public function index()
    {
        return $this->clienteRepository->allClientes();
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function show($id)
    {
        $cliente = $this->clienteRepository->clienteById($id);
        return view('cliente.detalle', compact('cliente'));
    }

    public function store(Request $request)
    {
        $cliente = $this->clienteRepository->store($request->all());
        return $cliente;
    }

    public function destroy($id)
    {
        $cliente = $this->clienteRepository->destroy($id);
        return redirect()->route('cliente')->withErrors('Cliente ' . $cliente . ' eliminado exitosamente !');
    }
}
