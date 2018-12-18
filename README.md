# Laravel 5.7 Admintemplate with ACL

Step-1: Install ACL Package
---------------------------------------
>> composer require spatie/laravel-permission

Step-2: Add the service provider in config/app.php file
--------------------------------------------------------
'providers' => [
    // ...
    
   Spatie\Permission\PermissionServiceProvider::class,
];

Step-3: Publish ACL migration file 
--------------------------------------------------------
>> php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"


Step-4: Publish the config/permission.php file 
--------------------------------------------------------
>> php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"


Step-5: Run the migration
----------------------------------
>> php artisan migrate

Step-6: First, add the Spatie\Permission\Traits\HasRoles trait to your User model(s):
-------------------------------------------------------------------------------------------

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    
   use ...,HasRoles;

    // ...
}

Step-7: When you need to create role or permission access in model or Controller, Just add those line.
--------------------------------------------------------------------------------------------------------
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;
