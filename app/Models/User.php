<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Academy;
use App\Models\UserPlan;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


    protected $fillable = [
        'first_name',
        'last_name',
        'is_admin',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
    
    public function userAdWatch()
    {
        return $this->hasMany(UserAdWatch::class);
    }
    
     public function userAdLike()
    {
        return $this->hasMany(UserAdLike::class);
    }


    public function userPlan()
    {
        return $this->hasOne(UserPlan::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function academy()
    {
        return $this->hasOne(Academy::class);
    }
    
    public function reachedRecruitmentDeclarationExpireTime()
    {
        if ($this->userPlan) {
            return $this->userPlan?->plan->declaration_expire_days < Carbon::parse($this->userPlan->created_at)->diffInDays(now());
        }
        return true;
    }

    public function reachedRecruitmentDeclarationQuantityLimitation($quantity)
    {
        if (is_int($this->userPlan?->plan->recruitment_declaration_quantity)) {
            return $this->userPlan?->plan->recruitment_declaration_quantity <= $quantity;
        }
        return true;
    }
}
