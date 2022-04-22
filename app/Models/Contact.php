<?php

namespace App\Models;

use App\Scopes\FilterScope;
use App\Scopes\ContactSearchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'company_id'];

    public $filterColumns = ['company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public static function booted()
    {
        static::addGlobalScope(new FilterScope);
        static::addGlobalScope(new ContactSearchScope);
    }
}
