<?php

namespace App\Services\FilterService;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

trait Filterable {

    /**
     * @var Filter|null
     */
    protected ?Filter $filters;

    /**
     * Подготовленный запрос для фильрации
     *
     * @param $query Builder
     * @param Filter|null $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, ?Filter $filters): Builder
    {
        $this->filters = $filters;

        return $filters->apply($query);
    }

    /**
     * Добавляет к пагинации параметры фильтров
     *
     * @param Builder $query
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function scopePaginateFilter(Builder $query, int $perPage = 20): LengthAwarePaginator
    {
        $paginator = $query->paginate($perPage);

        if ($this->filters !== null) {
            $paginator->appends($this->filters->filters());
        }

        return $paginator;
    }

    /**
     * Добавляет к пагинации параметры фильтров
     *
     * @param Builder $query
     * @param int $perPage
     * @return Paginator
     */
    public function scopeSimplePaginateFilter(Builder $query, int $perPage = 20): \Illuminate\Contracts\Pagination\Paginator
    {
        $paginator = $query->simplePaginate($perPage);

        if ($this->filters !== null) {
            $paginator->appends($this->filters->filters());
        }

        return $paginator;
    }
}
