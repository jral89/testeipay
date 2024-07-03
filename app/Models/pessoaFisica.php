<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoaFisica extends Model
{
    protected $table = 'pessoafisica';
    protected  $primaryKey = 'cpf';
    protected $fillable = ['cpf', 'nome', 'sobrenome', 'nascimento', 'email', 'genero'];
    public $timestamps = false;
    public $incrementing = false;
}
