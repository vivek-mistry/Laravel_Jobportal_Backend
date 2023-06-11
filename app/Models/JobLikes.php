<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobLikes extends Model
{
    use HasFactory;

    protected $table = 'job_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'job_id',
        'status'
    ];

    public function job()
    {
        return $this->hasOne(Jobs::class, 'id', 'job_id');
    }
}
