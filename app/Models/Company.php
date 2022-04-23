<?php

namespace App\Models;

use App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\User;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'email', 'website'];

    public $searchColumns = ['name', 'address', 'email', 'website'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function userCompanies()
    {
        return self::where('user_id', auth()->id())->orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
    }

    public static function booted()
    {
        static::addGlobalScope(new SearchScope);
    }

}

/*
Tinker Testing

1.php artisan tinker

2.use App\Models\Company

Get all records
Company::all()

Get only N records
Company::take(N)->get()

Get the first record
Company::first()

// get company by id 1
Company::find(1);

// get company by id 1, 2, 3
Company::find([1, 2, 3]);

Get record by other columns
Company::where('website', 'website-to-find')->first();

// Using magic method
Company::whereWebsite('website-to-find')->first();

Insert new record
// Instanciate the model
$company = new Company();
// Fill the model attributes
$company->name = "My Company";
$company->address = "My Address";
$company->email = "mycompany@test.com";
$company->website = "mywebsite.com";
// Persist the change to database
$company->save();

Update existing record
// Find the record that we need to update
$company = Company::find(1);

// Make some necesary changes
$company->email = "mywebsitecompany@test.com";
// Save the change
$company->save();

Delete record
// Get a record
$company = Company::find(1);

// remove the record
$company->delete();

// Delete a record without create object instance
Company::destroy(1);

// Delete 3 records without create object instance
Company::destroy([3, 4, 5]);

*/
