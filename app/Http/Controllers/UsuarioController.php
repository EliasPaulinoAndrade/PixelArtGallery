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

    public function seguir($id){
        $usuario = Auth::user();
        if(!$usuario->seguindo()->check($id)){
            $usuario->seguindo()->add($id);
        }
        else{
            $usuario->seguindo()->remove($id);
        }
        return redirect("/usuario/$id");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Usuario::myFind($id);
        return view('profile', compact("usuario")); 
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
