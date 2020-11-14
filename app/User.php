<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function roles(){

        return $this->belongsToMany('App\Role','role_user','user_id','role_id')->withPivot('id');;

    }
    public function hasanyRoles($roles){

        if($this->roles()->whereIn('name',$roles)->first()){
            return true;
        }
        return false;
    }
    public function hasRole($role){

        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }
    public function user_type(){
        return $this->belongsTo(UserType::class);
    }
    public function likes(){
        return $this->hasMany('App\NewsPostLike');
    }

    public function user_log() {
        return $this->hasMany(User_log::class, 'user_id', 'id');
    }
}
