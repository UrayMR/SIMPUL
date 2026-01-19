<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUuids;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'category_id',
        'thumbnail_path',
        'title',
        'description',
        'price',
        'video_url',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'teacher_id' => 'string',
            'category_id' => 'string',
            'price' => 'decimal:2',
            'status' => 'string',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
