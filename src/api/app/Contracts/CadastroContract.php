<?php

namespace App\Contracts;

interface CadastroContract{

    public function save(array $dados):int;
    public function delete(int $id):bool;
    public function findById(int $id):array;
    public function findAll(array $filter):array;

}