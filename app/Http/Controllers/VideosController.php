<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideosController extends Controller
{
    //
    public function crear(Request $req){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS
        
        $video = new Video();

        $video->titulo = $datos->titulo;
        $video->foto = $datos->foto;
        $video->enlace = $datos->enlace;
        $video->visto = 0;
        

        //Escribir en la base de datos
        try{
            $video->save();
            $respuesta['msg'] = "Se ha creado el video con id ".$video->id;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function listar(){

        $respuesta = ["status" => 1, "msg" => ""];
        try{
            $videos = Video::all();
            $respuesta['datos'] = $videos;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }

}
