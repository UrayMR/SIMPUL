<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property \App\Models\Teacher|null $teacher
 */
class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_TEACHER = 'teacher';

    public const ROLE_STUDENT = 'student';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_PENDING = 'pending';

    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'role' => 'string',
            'status' => 'string',
            'email_verified_at' => 'datetime',
        ];
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
}
