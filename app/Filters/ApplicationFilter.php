<?php

namespace App\Filters;

use App\Services\FilterService\Filter;
use Illuminate\Http\Request;

class ApplicationFilter extends Filter
{
    /**
     * @var array
     */
    protected array $available = [
        'id',
        'name',
        'email',
        'status',
        'user_id',
        'moderator_id',
        'created_at',
        'updated_at',
        'create_from',
        'create_to',

        'sort', 'perPage'
    ];

    /**
     * Фильтры по умолчанию.
     *
     * @var array
     */
    protected array $defaults = [
        'sort' => '-id'
    ];

    public function __construct(Request $request)
    {
        $this->input = $this->prepareInput($request->all());

//        $this->defaults = array_merge($this->defaults, [
//            'create_from' => $request->input('create_from', null),
//            'create_to' => $request->input('create_to', null),
//        ]);
    }

    protected function init()
    {
        $this->addSortable('id');
        $this->addSortable('name');
        $this->addSortable('email');
        $this->addSortable('status');
        $this->addSortable('user_id');
        $this->addSortable('moderator_id');
        $this->addSortable('created_at');
        $this->addSortable('updated_at');
    }

    public function id($value)
    {
        return $this->builder->where($this->column('id'), $value);
    }

    public function name($value)
    {
        return $this->builder->where($this->column('name'), 'like', "%{$value}%");
    }

    public function email($value)
    {
        return $this->builder->where($this->column('email'), 'like', "%{$value}%");
    }

    public function status($value)
    {
        return $this->builder->where($this->column('status'), $value);
    }

    public function user_id($value)
    {
        return $this->builder->where($this->column('user_id'), $value);
    }

    public function moderator_id($value)
    {
        return $this->builder->where($this->column('moderator_id'), $value);
    }

    public function create_from($value)
    {
        return $this->builder->where($this->column('created_at'), '>=', $value);
    }

    public function create_to($value)
    {
        return $this->builder->where($this->column('created_at'), '<=', $value);
    }


}
