<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\LocacaoRepository;
use App\Models\Locacao;

class LocacaoController extends Controller
{
    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }

        return response()->json($locacaoRepository->getResultadoPaginado(3), 200);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $locacao = $this->locacao->create([
            'cliente_id' => $request->cliente_id,
            'carro_id' => $request->carro_id,
            'data_inicio_periodo' => $request->data_inicio_periodo,
            'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
            'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
            'valor_diaria' => $request->valor_diaria,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final
        ]);

        return response()->json($locacao, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe!'], 404);
        }

        return response()->json($locacao, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Integer $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe!'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach ($locacao->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($locacao->rules(), $locacao->feedback());
        }

        $locacao->fill($request->all());
        $locacao->save();

        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $locacao = $this->locacao->find($id);

        if ($locacao === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe!'], 404);
        }

        $locacao->delete();

        return response()->json(['msg' => 'A locaoção foi removida com sucesso!'], 200);
    }
}
