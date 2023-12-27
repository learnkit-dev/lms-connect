# SSO IdP

The LMS does support SSO IdP. You can easily connect other services to the LMS by obtaining some client credentials.

## Use the client
We expose some endpoints to the service provider to authorize access. Users will be prompted to grant or deny access to their account.

You can use [https://github.com/ploi/roadmap](https://github.com/ploi/roadmap) as a reference on how to connect to lms-connect.

## LMS preparation
This section is for internal use only.

```Bash
php artisan migrate
php artisan passport:install
php artisan vendor:publish --tag="lms-connect-views"
```

## Generating a new client
Simply run the well known passport command and create a new client.
```Bash
php artisan passport:client
```
