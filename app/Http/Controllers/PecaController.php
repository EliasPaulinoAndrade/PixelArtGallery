<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peca;
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
        return view('peca', compact("peca")); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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