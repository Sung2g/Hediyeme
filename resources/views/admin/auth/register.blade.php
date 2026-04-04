<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin kayit — hediyeme</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-rose-900/40 via-slate-900 to-slate-950">
    <div class="mx-auto flex min-h-screen max-w-md items-center px-4 py-12">
        <div class="w-full rounded-2xl border border-slate-700/50 bg-slate-900/80 p-8 shadow-2xl shadow-black/40 backdrop-blur-xl">
            <div class="mb-8 flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-600 text-white shadow-lg shadow-rose-900/50">
                    <i data-lucide="user-plus" class="h-6 w-6"></i>
                </span>
                <div>
                    <h1 class="text-xl font-bold text-white">Yonetim kaydi</h1>
                    <p class="text-xs text-slate-400">/acp/admin-register</p>
                </div>
            </div>

            <form action="{{ route('acp.register.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-300">Ad</label>
                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" class="w-full rounded-xl border-slate-600 bg-slate-800/80 text-white placeholder-slate-500 focus:border-rose-500 focus:ring-rose-500" required>
                    @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-300">E-posta</label>
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="username" class="w-full rounded-xl border-slate-600 bg-slate-800/80 text-white placeholder-slate-500 focus:border-rose-500 focus:ring-rose-500" required>
                    @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-300">Sifre</label>
                    <input type="password" name="password" autocomplete="new-password" class="w-full rounded-xl border-slate-600 bg-slate-800/80 text-white focus:border-rose-500 focus:ring-rose-500" required>
                    @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-300">Sifre tekrar</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full rounded-xl border-slate-600 bg-slate-800/80 text-white focus:border-rose-500 focus:ring-rose-500" required>
                </div>

                <button type="submit" class="w-full rounded-xl bg-rose-600 py-3 text-sm font-bold text-white shadow-lg shadow-rose-900/30 transition hover:bg-rose-500">
                    Kayit ol ve panele gir
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-400">
                Zaten hesabiniz var mi?
                <a href="{{ route('acp.login') }}" class="font-medium text-rose-400 hover:text-rose-300">Giris yap</a>
            </p>
        </div>
    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
