<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use App\Services\FilterService\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'comment',
        'user_id',
        'moderator_id',
    ];

    protected $casts = [
        'status' => ApplicationStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class);
    }
}
