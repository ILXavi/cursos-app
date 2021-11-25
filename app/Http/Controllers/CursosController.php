<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursosController extends Controller
{
    //
    public function crear(Request $req){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS
        
        $curso = new Curso();

        $curso->titulo = $datos->titulo;
        $curso->descripcion = $datos->descripcion;
        $curso->foto = $datos->foto;
        

        //Escribir en la base de datos
        try{
            $curso->save();
            $respuesta['msg'] = "Se ha creado el curso con id ".$curso->id;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function listar(){

        $respuesta = ["status" => 1, "msg" => ""];
        try{
            $cursos = Curso::all();
            $respuesta['datos'] = $cursos;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }

}
