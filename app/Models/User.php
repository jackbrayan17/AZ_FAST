<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Import the HasRoles trait
use App\Models\Merchant;
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
        'username',
        'email',
        'password',
        'phone',
        'role'
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
     * Define a relationship with roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function profileImage()
    {
        return $this->hasOne(Image::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
                    ->where('model_type', self::class); // This sets the model_type correctly
    }
    
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    /**
     * Define a relationship with KYC.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
// app/Models/User.php

public function merchant()
{
    return $this->hasOne(Merchant::class); // Assuming one user has one merchant profile
}


    public function kyc()
    {
        return $this->hasOne(KYC::class);
    }
}
