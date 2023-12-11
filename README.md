# Installation
You need an API key to access this package. 

## Setup
The package is an extension to the LMS package. Version 3.1 of the LMS comes with a new plugin system. You can enable the API for specific teams. Go to the team settings and enable the plugin in the "Plugins tab".

## Authentication
We use Sanctum for easy authentication in the API. An API key is needed to make requests to the API. You can generate one with the command: `php artisan lms-connect:create-api-token`. If you don't have access via SSH, please contact us.

Example code:
```php
use Illuminate\Support\Facades\Http;

public function boot()
{
    Http::macro('lms', function () {
        $token = config('services.lms.api_key');
    
        return Http::baseUrl('https://cursuskit.test/lms-connect/api/v1')
            ->withHeaders([
                'Authorization': "Bearer $token"
            ]);
    });
}
```

## Routes
### Base url `lms-connect/api/v1/{team:slug}`

### Groups `groups`

### Group scores `groups/scores`
This endpoint is used for getting results for groups for a given team.

### Users `users`

