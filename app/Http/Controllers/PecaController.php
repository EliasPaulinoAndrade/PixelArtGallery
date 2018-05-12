<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peca;
use App\Avaliacao;
use Carbon\Carbon;
use Auth;

class PecaController extends Controller
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
    public function create(){
       
        return view('submit'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $peca = new Peca($request->all());
        $peca->data = Carbon::now();
        $peca->autor_id = Auth::user()->id;
        $peca->mySave();

        $imageFile = $request->file('imagem');
        $imageExtension = $imageFile->extension();
        $imageName = $peca->id . "." . $imageExtension;
        $imageFile->storeAs('public/pecas_images/', $imageName);

        $peca->imagem = $imageName;

        $peca->myUpdate();

        return redirect("/peca/$peca->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $peca = Peca::myFind($id);

        $avaliacao = null;
        if(Auth::user() != null){
            $avaliacao = Avaliacao::getAvaliacaoByAutorAndPeca(Auth::user()->id, $peca->id);
        }
        return view('peca', compact("peca", "avaliacao")); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peca = Peca::myFind($id);
        return view('edit', compact("peca")); 
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
        $peca = Peca::myFind($id);
        if($peca->autor_id != Auth::user()->id){
            return redirect("/home");
        }

        $peca->nome = $request->nome;
        $peca->descricao = $request->descricao;

        $peca->myUpdate();

        return redirect("/peca/".$peca->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peca = Peca::myFind($id);
        if($peca->autor_id != Auth::user()->id){
            return redirect("/home");
        }
        $peca->myDelete();

        return redirect("/home");
    }

    public function pecasByDate($begin, $end){
        $pecas = Peca::getSortedByDate($limit = $end, $offset = $begin); 

        $title = "Obras Mais Recentes";
        $currentLimit = $end;

        if(sizeof($pecas) == 0){
            return redirect("/peca/byDate/0/10");
        }

        return view('pecas', compact("pecas", "title", "currentLimit"));
    }

    public function pecasByEvaluation($begin, $end){
        $pecas = Peca::getBestEvalueted($limit = $end, $offset = $begin);

        $title = "Obras Mais Votadas";

        if(sizeof($pecas) == 0){
            return redirect("/peca/byDate/0/10");
        }

        return view('pecas', compact("pecas", "title"));
    }

}
