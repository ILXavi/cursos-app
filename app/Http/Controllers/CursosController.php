<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    //
    public function crear(Request $req){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); 

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

    public function listar(Request $req){

        $respuesta = ["status" => 1, "msg" => ""];
        try{

            if($req -> has('titulo')){

               $cursos = Curso::select(['id','titulo','foto'])                        
                        ->withCount('videos as cantidad_videos')    
                        ->where('cursos.titulo','like','%'. $req -> input('titulo').'%')
                        ->get();
                
            }else{
                $cursos = Curso::select(['id','titulo','foto'])
                        ->withCount('videos as cantidad_videos')    
                        ->get();
               
            }
            
            $respuesta['datos'] = $cursos;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }


    
}
