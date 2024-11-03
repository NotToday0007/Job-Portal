<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Job extends Model
{
    protected $fillable = [
        'user_id', 'title', 'vacancy', 'job_type_id', 'category_id', 'location', 'company_name',
        'company_location', 'company_website', 'benefits', 'qualifications',
        'description', 'experience', 'salary', 'responsibility',
        'position', 'keywords','status',
    ];

    // Define relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with JobType
     public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id'); // Ensure 'job_type_id' is correctly specified
    }
    // Define relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(related: JobApply::class);
    }
    public function savedJobs()
    {
        return $this->hasMany(  related: JobSaved::class);
    }
}
