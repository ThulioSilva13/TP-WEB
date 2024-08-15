<?php
namespace App\Http\Controllers;

use App\Http\Middleware\Autenticador;
use App\Http\Requests\TimesFormRequest;
use App\Models\Time;
use Illuminate\Http\Request;

class Times extends Controller
{
    public function __construct()
    {
        $this->middleware(Autenticador::class)->except(['index']);
    }

    public function index(Request $request){
        $times = Time::query()->orderBy('nome')->get();
        $mensagemSucesso = $request->session()->get('mensagem');
        return view('times.index')
            ->with(compact('times', 'mensagemSucesso'));
    }

    public function create()
    {
        return view('times.create');
    }

    public function store(TimesFormRequest $request)
    {
        $time = Time::create($request->all());
        return to_route('times.index')
            ->with('mensagem', "Time '$time->nome' cadastrado com sucesso!");
    }

    public function destroy(Time $time)
    {
        $time->delete();
        return to_route('times.index')
            ->with('mensagem', "Time '$time->nome' excluído com sucesso!");
    }

    public function edit(Time $time)
    {
        return view('times.edit')->with(compact('time'));
    }

    public function update(TimesFormRequest $request, Time $time)
    {
        $time->update($request->all());
        return to_route('times.index')
            ->with('mensagem', "Time '$time->nome' alterado com sucesso!");
    }
}
