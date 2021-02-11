<?php

namespace App\Repositories;

use App\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;


class ProductoRepository extends BaseRepository
{

    /**
     * @var Post
     */
    protected $producto;
    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Product $producto)
    {
        $this->producto     = $producto;
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
        return Product::class;
    }

    public function getEntidadId()
    {
        return $this->userRepository->getEntidadId();
    }

    public function allProducts()
    {
        return $this->producto::orderBy('name', 'asc')->paginate(10);
    }

    public function store($data)
    {
        //$entidad = $this->userRepository->getEntidadId();        
        $producto = Product::create([
            'name' => $data['name'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio']
        ]);
        return $producto->name;
    }

    public function getConvocatoriaId($id)
    {
        return $this->convocatoria->find($id);
    }

    public function update($data, $id)
    {
        $convocatoria = Product::find($id);
        $convocatoria->nombre = $data['nombre'];
        $convocatoria->descripcion = $data['descripcion'];
        $convocatoria->save();
        return $convocatoria->nombre;
    }

    public function destroy($id)
    {
        $convocatoria = Product::find($id);
        $nombre = $convocatoria->nombre;
        $convocatoria->delete();
        return $nombre;
    }
}
