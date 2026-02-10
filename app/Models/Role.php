<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Ghi chú (quan trọng)

timestamps = false → đúng với migration roles (không có created_at)

Quan hệ many-to-many chuẩn, dùng pivot user_roles
 */
class Role extends Model
{
  protected $fillable = [
    'name', // admin, owner, player, staff
  ];

  public $timestamps = false;

  public function users(): BelongsToMany
  {
    return $this->belongsToMany(
      User::class,
      'user_roles',
      'role_id',
      'user_id'
    );
  }
}
