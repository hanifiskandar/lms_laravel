<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'nric',
        'dob',
        'marital_status',
        'mobile_phone',
        'office_phone',
        'designation',
        'position_level',
        'department_id',
        'address_line1',
        'address_line2',
        'address_line3',
        'city',
        'state',
        'postcode',
        'country',
        'spouse_name',
        'spouse_nric',
        'spouse_job',
        'spouse_employer',
        'role',
        'is_active',
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

    public function leaveLimits()
    {
        return $this->hasMany(LeaveLimit::class, 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Children::class, 'user_id');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'user_id');
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'user_id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }
}
