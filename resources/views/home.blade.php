<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divina Arte - Personalizados e Artesanato</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E7DFD2] min-h-screen">
    <!-- Header/Navigation -->
    <header class="bg-white/80 backdrop-blur-sm border-b border-[#E7DFD2]/20 sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xl font-bold text-purple-900">Divina Arte</span>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#sobre" class="text-purple-900/80 hover:text-purple-900 transition-colors">Sobre</a>
                    <a href="#produtos" class="text-purple-900/80 hover:text-purple-900 transition-colors">Produtos</a>
                    <a href="#contato" class="text-purple-900/80 hover:text-purple-900 transition-colors">Contato</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-purple-900 text-white rounded-lg font-medium hover:bg-purple-800 transition-colors">
                            Painel de Controle
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-900 text-white rounded-lg font-medium hover:bg-purple-800 transition-colors">
                            Entrar
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <h1 class="text-4xl md:text-6xl font-bold text-purple-900 leading-tight">
                    Personalizados e artesanato feitos com amor
                </h1>
                <p class="text-lg text-purple-900/80">
                    Transformamos suas ideias em peças únicas e especiais. Cada produto é feito à mão com muito carinho e atenção aos detalhes. Enviamos para todo o Brasil!
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://wa.me/SEU_NUMERO" target="_blank" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Peça pelo WhatsApp
                    </a>
                    <a href="#produtos" class="px-6 py-3 border-2 border-purple-900 text-purple-900 rounded-lg font-medium hover:bg-purple-900 hover:text-white transition-colors text-center">
                        Ver Produtos
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-900 to-purple-600 rounded-2xl transform rotate-6 blur-xl opacity-20"></div>
                <img src="https://images.unsplash.com/photo-1459411552884-841db9b3cc2a" alt="Artesanato" class="relative rounded-2xl shadow-xl w-full">
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="bg-white/50 backdrop-blur-sm py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 rounded-xl bg-white shadow-sm border border-purple-900/10">
                    <div class="w-12 h-12 bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-purple-900 mb-2">Produtos Personalizados</h3>
                    <p class="text-purple-900/70">Criamos peças únicas de acordo com seu desejo, tornando cada item verdadeiramente especial.</p>
                </div>

                <div class="p-6 rounded-xl bg-white shadow-sm border border-purple-900/10">
                    <div class="w-12 h-12 bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-purple-900 mb-2">Envio para Todo Brasil</h3>
                    <p class="text-purple-900/70">Entregamos em qualquer lugar do país, levando nosso artesanato até você com todo cuidado.</p>
                </div>

                <div class="p-6 rounded-xl bg-white shadow-sm border border-purple-900/10">
                    <div class="w-12 h-12 bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-purple-900 mb-2">Feito com Amor</h3>
                    <p class="text-purple-900/70">Cada peça é confeccionada com dedicação e carinho, garantindo a qualidade que você merece.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white/50 backdrop-blur-sm border-t border-purple-900/10 mt-16">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <svg class="w-8 h-8 text-purple-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xl font-bold text-purple-900">Divina Arte</span>
                </div>
                <p class="text-purple-900/60 text-sm">
                    © 2024 Divina Arte. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>
</html> 