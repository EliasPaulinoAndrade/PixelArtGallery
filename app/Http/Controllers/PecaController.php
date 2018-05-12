<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peca;
use App\Avaliacao;
use Carbon\Carbon;
use Auth;

class PecaController extends Controller
{

    public function create(){
        /*mostra o formulario de submicao de obras*/

        return view('submit'); 
    }

    public function store(Request $request)
    {
        /*salva uma peca, jutamente com a image, que é salva na pasta storage, 
        usando o id da peca criada*/

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

    public function show($id)
    {        
        /*busca a peca e uma avaliacao dela feita pelo usuario logado, se houver retorna*/

        $peca = Peca::myFind($id);

        $avaliacao = null;
        if(Auth::user() != null){
            $avaliacao = Avaliacao::getAvaliacaoByAutorAndPeca(Auth::user()->id, $peca->id);
        }
        return view('peca', compact("peca", "avaliacao")); 
    }

    public function edit($id)
    {
        /*motra o formulario de edição de uma peca*/

        $peca = Peca::myFind($id);
        return view('edit', compact("peca")); 
    }

    public function update(Request $request, $id)
    {
        /*busca a peca pelo id, atualiza seus campos e a salva */
        $peca = Peca::myFind($id);
        if($peca->autor_id != Auth::user()->id){
            return redirect("/home");
        }

        $peca->nome = $request->nome;
        $peca->descricao = $request->descricao;

        $peca->myUpdate();

        return redirect("/peca/".$peca->id);
    }

    public function destroy($id)
    {
        /*remove uma peca do banco de dados*/
        
        $peca = Peca::myFind($id);
        if($peca->autor_id != Auth::user()->id){
            return redirect("/home");
        }
        $peca->myDelete();

        return redirect("/home");
    }

    public function pecasByDate($begin, $end)
    {
        /*retorna peças por update, o $title vai ser mostrado no header da pagina, o $id diz qual
        controller chamou a pagina*/

        $pecas = Peca::getSortedByDate($limit = $end - $begin, $offset = $begin); 

        $title = "Obras Mais Recentes";
        $currentLimit = $end;
        $id = "byDate";

        if(sizeof($pecas) == 0){
            return redirect("/home");
        }

        return view('pecas', compact("pecas", "title", "currentLimit", "id"));
    }

    public function pecasByEvaluation($begin, $end)
    {

        /*retorna pecas com melhor avaliacao, se houver avaliacao*/

        $pecas = Peca::getBestEvalueted($limit = $end, $offset = $begin);

        $title = "Obras Mais Votadas";
        $currentLimit = $end;
        $id = "byEvaluation";

        if(sizeof($pecas) == 0){
            return redirect("/home");
        }

        return view('pecas', compact("pecas", "title", "currentLimit", "id"));
    }

}
