<?php

namespace App\Repositories;

use App\Clientes;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;


class ClienteRepository extends BaseRepository
{

    /**
     * @var Post
     */
    protected $cliente;
    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Clientes $cliente)
    {
        $this->cliente     = $cliente;
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
        return Clientes::class;
    }


    public function allClientes()
    {
        return $this->cliente::orderBy('nombre', 'asc')->paginate(10);
    }

    public function store($data)
    {
        $cliente = Clientes::create([
            'nombre' => $data['nombre'],
            'cedula' => $data['cedula']
        ]);
        return $cliente->nombre;
    }

    public function clienteById($id)
    {
        return $this->cliente->find($id);
    }

    public function update($data, $id)
    {
        $convocatoria = Clientes::find($id);
        $convocatoria->nombre = $data['nombre'];
        $convocatoria->descripcion = $data['descripcion'];
        $convocatoria->save();
        return $convocatoria->nombre;
    }

    public function destroy($id)
    {
        $convocatoria = Clientes::find($id);
        $nombre = $convocatoria->nombre;
        $convocatoria->delete();
        return $nombre;
    }
}
