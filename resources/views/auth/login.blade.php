<x-layout.base title="Connexion">
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-700">
            <h2 class="text-3xl font-bold text-center mb-6 text-gradient">Connexion</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold py-3 rounded-full hover:bg-blue-500/90 transition">
                    Se connecter
                </button>
            </form>

            <p class="text-center mt-6 text-gray-400">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-500 transition">S'inscrire</a>
            </p>
        </div>
    </div>
</x-layout.base>
