<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{

    use HasFactory;

    protected $table = 'locacoes';

    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    public function rules() {
        return [
            'cliente_id' => 'required',
            'carro_id' => 'required',
            'data_inicio_periodo' => 'required',
            'data_final_previsto_periodo' => 'required',
            'data_final_realizado_periodo' => 'required',
            'valor_diaria' => 'required',
            'km_inicial' => 'required',
            'km_final' => 'required'
        ];
    }

    public function feedback() {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'carro_id.required' => 'O carro é obrigatório.',
            'data_inicio_periodo.required' => 'A data início período é obrigatória.',
            'data_final_previsto_periodo.required' => 'A data final previsto período é obrigatória.',
            'data_final_realizado_periodo.required' => 'A data final realizado período é obrigatória.',
            'valor_diaria.required' => 'O valor diária é obrigatório.',
            'km_inicial.required' => 'O KM inicial é obrigatório.',
            'km_final.required' => 'O KM final é obrigatório.'
        ];
    }

}
