<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Authorization</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center h-screen w-full justify-center">
<div class="bg-white rounded-lg p-10 max-w-md space-y-3">
    <h1 class="font-bold text-lg">{{ $client->name }} wilt toegang tot je account</h1>
    <p>Als je op goedkeuren klikt zal de {{ $client->name }} toegang krijgen tot de volgende gegevens:</p>

    <ul class="ml-4">
        @foreach($scopes as $scope)
            <li class="list-disc">{{ $scope->description }}</li>
        @endforeach
    </ul>

    <div class="grid grid-cols-2 text-center gap-5">
        <form class="w-full" method="post" action="{{ route('passport.authorizations.approve') }}">
            @csrf

            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">

            <button type="submit" class="w-full bg-green-500 hover:bg-green-500/80 rounded-md text-white py-2 px-3">
                Goedkeuren
            </button>
        </form>

        <!-- Cancel Button -->
        <form class="w-full" method="post" action="{{ route('passport.authorizations.deny') }}">
            @csrf
            @method('DELETE')

            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">

            <button type="submit" class="w-full bg-red-500 hover:bg-red-500/80 rounded-md text-white py-2 px-3">
                Afwijzen
            </button>
        </form>
    </div>
</div>
</body>

</html>
