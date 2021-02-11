<?php

namespace App\Repositories;

use App\VentaProducto;
use App\Ventas;
use App\Repositories\BaseRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\ProductoRepository;
use Illuminate\Support\Facades\DB;


class VentaRepository extends BaseRepository
{

    /**
     * @var Post
     */
    protected $venta;
    private $clienteRepository;
    private $productoRepository;
    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Ventas $venta, ClienteRepository $clienteRepository, ProductoRepository $productoRepository)
    {
        $this->venta     = $venta;
        $this->clienteRepository = $clienteRepository;
        $this->productoRepository = $productoRepository;
    }



    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'descripcion',
        'usuario_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ventas::class;
    }


    public function allVenta()
    {
        return $this->venta::orderBy('created_at', 'asc')->paginate(10);
    }

    public function store($data)
    {
        $venta = Ventas::create([
            'cliente_id' => $data['data']['cliente'],
            'valor' => $data['data']['total']
        ]);
        $this->set($venta->id, $data['data']['ventas']);

        return $venta->id;
    }

    public function ventaById($id)
    {
        return $this->venta->find($id);
    }

    public function update($data, $id)
    {
        $convocatoria = Ventas::find($id);
        $convocatoria->nombre = $data['nombre'];
        $convocatoria->descripcion = $data['descripcion'];
        $convocatoria->save();
        return $convocatoria->nombre;
    }

    public function destroy($id)
    {
        $convocatoria = Ventas::find($id);
        $nombre = $convocatoria->nombre;
        $convocatoria->delete();
        return $nombre;
    }

    public function getClientes()
    {
        return $this->clienteRepository->allClientes();
    }

    public function getproductos()
    {
        return $this->productoRepository->allProducts();
    }

    public function set($venta, $data)
    {
        foreach ($data as $key => $value) {
            $this->storeCompra($venta, $value['id'], $value['precio']);
        }
    }

    public function storeCompra($venta, $producto, $precio)
    {
        $venta = VentaProducto::create([
            'venta_id' => $venta,
            'producto_id' => $producto,
            'precio' => $precio
        ]);
        return $venta->id;
    }

    public function allVentas()
    {
        $ventas = DB::table('ventas')
            ->select('ventas.id', 'ventas.valor', 'clientes.nombre as cliente', 'ventas.created_at as fecha')
            ->join('clientes', 'clientes.id', '=', 'ventas.cliente_id')
            ->get();
        return $ventas;
    }
}
