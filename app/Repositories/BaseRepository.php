<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class BaseRepository
{
    /**
     * Model class para repositorios.
     * @var string
     */
    protected $modelClass;

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newQuery()
    {
        return app($this->modelClass)->newQuery();
    }

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int $take
     * @param bool $paginate
     *  
     * @return EloquentCollection | Paginator
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if (true == $paginate) {
            return $query->paginate($take);
        }

        if ($take > 0 || false !== $take) {
            $query->take($take);
        }

        return $query->get();
    }

    protected function doQueryOffsetLimit($query = null, $offset = 0, $limit = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if (true == $paginate) {
            return $query->paginate($offset);
        }

        if ($offset > 0 || false !== $offset) {
            $query->skip($offset)->take($limit);
        }

        return $query->get();
    }

    /**
     * Retorna todos os registros.
     * Se $paginate é true retorna uma instancia de Paginator.
     * @param int  $take
     * @param bool $paginate
     *
     * @return EloquentCollection|Paginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->orderBy($column)->pluck($column, $key);
    }

    /**
     * Recupera um registro por seu ID
     * Se $fail for true  lança uma exceção se o modelo não for encontrado. https://laravel.com/docs/5.3/eloquent
     * Se $fail for false  retorna null
     * @param int  $id
     * @param bool $fail
     * @return Model
     */
    public function findByID($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }

    public function findToPublish($id)
    {
        return $this->newQuery()->where('conteudo_publico', '=', 1)->find($id);
    }
}
