<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Usuario;

class UsuarioController extends Controller
{

    public function listar(Request $requets) {
       $usuario = Usuario::get();
        return response()->json([
            'status' => true,
            'msg' => 'listado',
            'data' => $usuario
        ]);
    }

    public function show($id) {
        $usuario = Usuario::find($id);
         return response()->json([
             'status' => true,
             'data' => $usuario
         ]);
    }


   public function store(Request $request)
   {
        $datos_recibidos = $request->all();
        $respuesta = [];
        $respuesta["status"] = false;

        $validator = Validator::make($datos_recibidos ,[
            'email' => 'required|max:50',
            'username' => 'required|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de información';
            $respuesta["validator"] = $validator->errors();
        } else {
            $usuario = new Usuario();
            $usuario->fill($datos_recibidos);
            $usuario->password =  password_hash($datos_recibidos["password"], PASSWORD_BCRYPT);
    
            if ($usuario->save()) {
                $respuesta["status"] = true;
                $respuesta["msg"] = 'Tipo creado de manera satisfactoria';
                $respuesta["data"] = $usuario;
            }else{                
                $respuesta["msg"] = 'El tipo de producto no pudo ser creado';
                $respuesta["data"] = $usuario;
            }
        }
        return response()->json($respuesta);
    }

   public function update(Request $request, $id)
   {
        $datos_recibidos = $request->all();
        $respuesta = [];
        $respuesta["status"] = false;

        $validator = Validator::make($datos_recibidos ,[
            'email' => 'required|max:50',
            'username' => 'required|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $respuesta["msg"] = 'Verificar los campos de información';
            $respuesta["validator"] = $validator->errors();
        } else {
            $usuario = Usuario::find($id);

            if (empty($usuario)) {
                    $respuesta["msg"] = 'El registro que desea actualizar no existe.';
            } else {  
            
                $usuario->fill($datos_recibidos);
                $usuario->password =  password_hash($datos_recibidos["password"], PASSWORD_BCRYPT);

                if($usuario->save()){
                    $respuesta["status"] = true;
                    $respuesta["msg"] = 'Actualizado correctamente.';
                    $respuesta["data"] = $usuario;
                }else{                
                    $respuesta["msg"] = 'No se puedo actualizar.';
                    $respuesta["data"] = $usuario;
                }
            }
        }
        return response()->json($respuesta);
    }

    public function destroy($id)
    {
        $respuesta = [];
        $respuesta["status"] = false;

        $usuario = Usuario::find($id);

        if ($usuario) {
            
            if ($usuario->delete()) {
                $respuesta["status"] = true;
                $respuesta["msg"] = "Registro eliminado correctamente.";
                $respuesta["data"] = $usuario;
            } else {
                $respuesta["msg"] = "No se puede eliminar el registro.";
                $respuesta["data"] = $usuario;
            }                       

        } else {
            $respuesta["msg"] = 'No se encontro el registro que intenta eliminar.';
        }          
       
        return response()->json($respuesta);
    }
}
