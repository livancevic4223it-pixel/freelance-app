<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // 👇 OVO MORA jer ti tabela NIJE jobs nego job_posts
    protected $table = 'job_posts';

    protected $fillable = [
        'title',
        'description',
        'budget',
        'category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
