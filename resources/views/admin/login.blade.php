<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#1B2A4A'
                        },
                        gold: {
                            DEFAULT: '#C9A227'
                        }
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-navy to-navy-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gold rounded-2xl mb-4 shadow-lg">
                <span
                    class="font-display text-white text-2xl font-bold">{{ substr($schoolName ?? 'S', 0, 1) }}</span>
            </div>
            <h1 class="text-white font-display text-3xl font-bold">Admin Panel</h1>
            <p class="text-white/60 text-sm mt-1">{{ $schoolName ?? 'School' }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-navy font-bold text-xl mb-6">Sign In to Continue</h2>
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-3 mb-5 text-sm">
                    {{ $errors->first() }}</div>
            @endif
            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-gold transition-colors text-sm">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-gold">
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>
                <button type="submit"
                    class="w-full bg-navy hover:bg-gold text-white font-bold py-3.5 rounded-xl transition-colors shadow-md">Sign
                    In</button>
            </form>
        </div>
        <p class="text-center text-white/40 text-xs mt-6">© {{ date('Y') }}
            {{ $schoolName ?? 'School' }}</p>
    </div>
</body>

</html>
