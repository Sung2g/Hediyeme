<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giris</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <div class="mx-auto flex min-h-screen max-w-md items-center px-4">
        <div class="w-full rounded-2xl bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Admin Giris</h1>
            <p class="mt-1 text-sm text-gray-500">/acp/admin-login</p>

            <form action="{{ route('acp.login.store') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">E-Posta</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Sifre</label>
                    <input type="password" name="password" class="w-full rounded-lg border-gray-300">
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" value="1">
                    Beni hatirla
                </label>

                <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                    Giris Yap
                </button>
            </form>

            <p class="mt-4 text-xs text-gray-500">
                Varsayilan admin: admin@hediyeme.com / password
            </p>
        </div>
    </div>
</body>
</html>
