# Authentication

You need an API key to connect to the LMS. We can provide you with an API key, so you can start using the API. The API key is attached to a user.

### Laravel example
```php
use Illuminate\Support\Facades\Http;

public function boot()
{
    Http::macro('lms', function () {
        $token = config('services.lms.api_key');
        $baseUrl = config('services.lms.base_url');
    
        return Http::baseUrl($baseUrl)
            ->withHeaders([
                'Authorization': "Bearer $token"
            ]);
    });
}
```

## Register API token (for system owners only)
<procedure title="Register a new API token" id="register-api-token">
<p>Login through SSH and navigate to the project.</p>
<step>Run <code>php artisan lms-connect:create-api-token</code></step>
<step>Search for a super admin and attach the API token</step>
<step>Write down the generated API token</step>
</procedure>
