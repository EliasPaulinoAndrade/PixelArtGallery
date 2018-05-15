<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comentario;
use App\Avaliacao;
use Carbon\Carbon;
use Auth;

class ComentarioController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'descricao' => 'required|string|max:255',
            'avaliacao' => 'required|numeric|min:1|max:5'
        ]);
        /*salva um comentario e uma avaliacao no banco*/

        $comentario = new Comentario($request->all());
        $comentario->data = Carbon::now();
        $comentario->autor_id = Auth::user()->id;
        $comentario->mySave();

        $avaliacao = Avaliacao::getAvaliacaoByAutorAndPeca(Auth::user()->id, $request->peca_id);

        /*se ja houver avaliacao, da update, se nao, cria uma*/
        if($avaliacao == null){
            $avaliacao = new Avaliacao(['nota' => $request->avaliacao, 'autor_id' => Auth::user()->id, 'peca_id' => $request->peca_id]);
            $avaliacao->mySave();
        }
        else{
            $avaliacao->nota = $request->avaliacao;
            $avaliacao->myUpdate();
        }
        return redirect("/peca/$comentario->peca_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
