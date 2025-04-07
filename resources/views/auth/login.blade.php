<x-guest-layout>
    <div class="min-h-screen bg-[#E7DFD2] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center space-x-3">
                    <svg class="w-12 h-12 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-2xl font-bold text-purple-900">Divina Arte</span>
                </div>
            </div>

            <!-- Card de Login -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-8 border border-purple-900/10">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-purple-900">Bem-vindo(a) de volta!</h2>
                    <p class="mt-2 text-sm text-purple-900/70">
                        Entre com suas credenciais para acessar o painel
                    </p>
                </div>

                <x-validation-errors class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm" />

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-purple-900">
                            Email
                        </label>
                        <div class="mt-1">
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   class="appearance-none block w-full px-3 py-2.5 border border-purple-900/20 rounded-lg shadow-sm placeholder-purple-900/40 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-purple-900"
                                   placeholder="seu@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-purple-900">
                            Senha
                        </label>
                        <div class="mt-1">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required
                                   class="appearance-none block w-full px-3 py-2.5 border border-purple-900/20 rounded-lg shadow-sm placeholder-purple-900/40 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-purple-900"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" 
                                   type="checkbox"
                                   name="remember" 
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-purple-900/20 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-purple-900">
                                Lembrar-me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm font-medium text-purple-900 hover:text-purple-700">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-900 hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                            Entrar
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-purple-900 hover:text-purple-700 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar para o site
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
