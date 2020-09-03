<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getResults($name = null){
        if(!$name)
            return $this->get();//se não tem parametros retorna todos os dados
        return $this->where('name', 'LIKE', "%{$name}%")->get();
    }
}
