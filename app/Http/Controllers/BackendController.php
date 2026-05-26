<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends Controller
{
    private $names = [
        1 => ['name' => 'Ana','age' => 30],
        2 => ['name' => 'Hector','age' => 25],
        3 => ['name' => 'Juan','age' => 35],

    ];

    public function getAll(){
        return response()->json($this->names);
    }

    // El parametro id es opcional, por lo que se le asigna un valor por defecto de 0
    public function get(int $id = 0){
        if(isset($this->names[$id])){
            return response()->json($this->names[$id]);
        }

        return response()->json(["error" => "No se encontró el nombre con el id: $id"], Response::HTTP_NOT_FOUND);
    }

    // Estoy simlulando crear uno nuevo pero reescribe el mismo id, por que no tenemos peristencia en base de datos
    public function create(Request $request){
        $person=[
            "id" => count($this->names) + 1,
            "name" => $request->input('name'),
            "age" => $request->input('age'),
        ];
        $this->names[$person['id']] = $person;

        return response()->json(["message" => "Persona creada exitosamente", "person" => $person], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id){
        if(isset($this->names[$id])){
            $this->names[$id]['name'] = $request->input("name", $this->names[$id]['name']);
            $this->names[$id]['age'] = $request->input('age', $this->names[$id]['age']);

            return response()->json(["message" => "Persona actualizada exitosamente", 
            "person" => $this->names[$id]]);
        }

        return response()->json(["error" => "No se encontró el nombre con el id: $id"], Response::HTTP_NOT_FOUND);
    }

    public Function delete(int $id)
    {
        if(isset($this->names[$id])){
            unset($this->names[$id]);
            return response()->json(["message" => "Persona eliminada exitosamente"]);
        }

        return response()->json(["error" => "No se encontró el nombre con el id: $id"], Response::HTTP_NOT_FOUND);
    }
}
