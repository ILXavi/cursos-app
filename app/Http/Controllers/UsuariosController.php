<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Curso;

class UsuariosController extends Controller
{
    //
    public function crear(Request $req){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS
        
        $usuario = new Usuario();

        $usuario->nombre = $datos->nombre;
        $usuario->foto = $datos->foto;
        $usuario->email = $datos->email;
        $usuario->contraseña = $datos->contraseña;
        $usuario->activado = 1;

        /*if(isset($datos->email))
            $persona->email = $datos->email;*/

        //Escribir en la base de datos
        try{
            if(Usuario::where('email', '=', $datos->email)->first()){
                $respuesta['msg'] = "El email usado ya se encuentra registrado, pruebe con otro";
            }else{
                $usuario->save();
                $respuesta['msg'] = "Persona guardada con id ".$usuario->id;
            }
            
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function editar(Request $req,$id){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.


        //Buscar a la persona
        try{
            $usuario = Usuario::find($id);

            if($usuario){

                //VALIDAR LOS DATOS

                if(isset($datos->nombre))
                    $usuario->nombre = $datos->nombre;
                if(isset($datos->foto))
                    $usuario->foto = $datos->foto;
                if(isset($datos->contraseña))
                    $usuario->contraseña = $datos->contraseña;
                
                //Escribir en la base de datos
                    $usuario->save();
                    $respuesta['msg'] = "Usuario actualizado.";
            }else{
                $respuesta["msg"] = "Usuario no encontrado";
                $respuesta["status"] = 0;
            }
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }


    public function desactivar($id){

        $respuesta = ["status" => 1, "msg" => ""];

        //Buscar a la persona
        try{
            $usuario = Usuario::find($id);

            if($usuario && $usuario->activado==1){

                    $usuario->activado=0;
                    $usuario->save();
                    //$usuario->delete();
                    $respuesta['msg'] = "Usuario desactivado";
            }else{
                $respuesta["msg"] = "Usuario no encontrado";
                $respuesta["status"] = 0;
            }
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }


    
    public function listar(){

        $respuesta = ["status" => 1, "msg" => ""];
        try{
            $usuarios = Usuario::all();
            $respuesta['datos'] = $usuarios;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function ver($id){
        $respuesta = ["status" => 1, "msg" => ""];


        //Buscar a la persona
        try{
            $usuario = Usuario::find($id);
            $usuario->makeVisible(['created_at','updated_at']);
            $respuesta['datos'] = $usuario;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function comprar_curso($usuario_id, $curso_id){
        $respuesta = ["status" => 1, "msg" => ""];

        $usuario = Usuario::find($usuario_id);
        $curso = Curso::find($curso_id);
       

        if($usuario && $curso){
            $usuario->cursos()->attach($curso);
            $respuesta['msg'] = "Se ha matriculado al usuario ".$usuario->nombre. " al curso ".$curso->titulo;
        }else{
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Usuario no encontrado: ";
        }
        return response()->json($respuesta);

    }

    public function listar_comprados($usuario_id){

        $respuesta = ["status" => 1, "msg" => ""];

        $usuario = Usuario::find($usuario_id);
        

        if($usuario){
              
            $usuario->cursos;
            $respuesta['usuario'] = $usuario;
        }else{
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Usuario no encontrado: ";
        }
        return response()->json($respuesta);

    }

    
}
