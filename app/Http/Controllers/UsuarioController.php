<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use Auth;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function seguir($id)
    {
        /*se o usuario logado ja seguir o outro usuario, ele o deixa de seguir, 
        se nao, ele passa a seguir*/

        $usuario = Auth::user();
        if(!$usuario->seguindo()->check($id)){
            $usuario->seguindo()->add($id);
        }
        else{
            $usuario->seguindo()->remove($id);
        }
        return redirect("/usuario/$id");
    }

    public function show($id)
    {   
        /*retorna um usuario*/
        $usuario = Usuario::myFind($id);
        return view('profile', compact("usuario")); 
    }


    public function update(Request $request, $id)
    {
        /*atualiza os dados de um usuario, se houver imagem no request, atualiza a imagem*/
        $usuario = Usuario::myFind($id);
        if(Auth::user()->id != $usuario->id){
            return redirect("/usuario/$usuario->id");
        }

        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->descricao = $request->descricao;

        $imageFile = $request->file('imagem');
        if($imageFile != null){
            $imageExtension = $imageFile->extension();
            $imageName = $usuario->id . "." . $imageExtension;
            $imageFile->storeAs('public/perfil_images/', $imageName);
            $usuario->img_perfil = $imageName;
        }
        $usuario->myUpdate();


        return redirect("/usuario/$usuario->id");
    }
}
