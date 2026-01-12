<x-layout.base title="Inscription">
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-700">
            <h2 class="text-3xl font-bold text-center mb-6 text-gradient">Inscription</h2>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium mb-2">Nom complet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium mb-2">Rôle</label>
                    <select id="role" name="role" required
                            class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                        <option value="student">Étudiant (Membre d'équipe)</option>
                        <option value="project_manager">Étudiant (Chef de projet)</option>
                        <option value="teacher">Enseignant</option>
                    </select>
                </div>

                <div class="mb-4" x-data="passwordStrength()">
                    <label for="password" class="block text-sm font-medium mb-2">Mot de passe</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'"
                               id="password"
                               name="password"
                               required
                               x-model="password"
                               @input="checkStrength"
                               class="w-full px-4 py-2 pr-10 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-2" x-show="password.length > 0">
                        <div class="flex gap-1 mb-2">
                            <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 1 ? (strength === 1 ? 'bg-red-500' : strength === 2 ? 'bg-yellow-500' : strength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-700'"></div>
                            <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 2 ? (strength === 2 ? 'bg-yellow-500' : strength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-700'"></div>
                            <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 3 ? (strength === 3 ? 'bg-blue-500' : 'bg-green-500') : 'bg-gray-700'"></div>
                            <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 4 ? 'bg-green-500' : 'bg-gray-700'"></div>
                        </div>
                        <p class="text-xs" :class="strength === 1 ? 'text-red-500' : strength === 2 ? 'text-yellow-500' : strength === 3 ? 'text-blue-500' : 'text-green-500'" x-text="strengthText"></p>
                    </div>

                    <div class="mt-3 space-y-1 text-xs">
                        <div class="flex items-center gap-2" :class="hasMinLength ? 'text-green-500' : 'text-gray-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Au moins 12 caractères</span>
                        </div>
                        <div class="flex items-center gap-2" :class="hasLowerCase ? 'text-green-500' : 'text-gray-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Une minuscule (a-z)</span>
                        </div>
                        <div class="flex items-center gap-2" :class="hasUpperCase ? 'text-green-500' : 'text-gray-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Une majuscule (A-Z)</span>
                        </div>
                        <div class="flex items-center gap-2" :class="hasNumber ? 'text-green-500' : 'text-gray-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Un chiffre (0-9)</span>
                        </div>
                        <div class="flex items-center gap-2" :class="hasSpecialChar ? 'text-green-500' : 'text-gray-500'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Un caractère spécial (@$!%*#?&)</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                </div>

                <script>
                    function passwordStrength() {
                        return {
                            password: '',
                            showPassword: false,
                            strength: 0,
                            strengthText: '',
                            hasMinLength: false,
                            hasLowerCase: false,
                            hasUpperCase: false,
                            hasNumber: false,
                            hasSpecialChar: false,

                            checkStrength() {
                                this.hasMinLength = this.password.length >= 12;
                                this.hasLowerCase = /[a-z]/.test(this.password);
                                this.hasUpperCase = /[A-Z]/.test(this.password);
                                this.hasNumber = /[0-9]/.test(this.password);
                                this.hasSpecialChar = /[@$!%*#?&]/.test(this.password);

                                let score = 0;
                                if (this.hasMinLength) score++;
                                if (this.hasLowerCase) score++;
                                if (this.hasUpperCase) score++;
                                if (this.hasNumber) score++;
                                if (this.hasSpecialChar) score++;

                                if (score <= 2) {
                                    this.strength = 1;
                                    this.strengthText = 'Faible';
                                } else if (score === 3) {
                                    this.strength = 2;
                                    this.strengthText = 'Moyen';
                                } else if (score === 4) {
                                    this.strength = 3;
                                    this.strengthText = 'Bon';
                                } else {
                                    this.strength = 4;
                                    this.strengthText = 'Excellent';
                                }
                            }
                        }
                    }
                </script>

                <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold py-3 rounded-full hover:bg-blue-500/90 transition">
                    S'inscrire
                </button>
            </form>

            <p class="text-center mt-6 text-gray-400">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-500 transition">Se connecter</a>
            </p>
        </div>
    </div>
</x-layout.base>
