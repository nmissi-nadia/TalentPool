<?php

namespace App\Interfaces;

interface AnnonceRepositoryInterface
{
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
    public function stats();
}
