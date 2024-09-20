<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Import the HasRoles trait

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Use the HasRoles trait for role and permission management

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hash the password before saving it to the database.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Define the relationship with the Role model.
     * Since the Spatie package handles roles and permissions,
     * this relation is optional and can be used for customization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign a specific role to the user.
     *
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assignRoleToUser($role)
    {
        return $this->assignRole($role); // Using spatie's assignRole method
    }
}
