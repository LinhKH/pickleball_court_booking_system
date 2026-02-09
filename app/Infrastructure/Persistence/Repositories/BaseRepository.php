<?php

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
  public function __construct(protected Model $model) {}

  public function find(int $id)
  {
    return $this->model->findOrFail($id);
  }
}
