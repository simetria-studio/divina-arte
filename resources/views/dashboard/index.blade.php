@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header', 'Bem-vindo de volta')
@section('subheader', 'Visão geral do seu negócio')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Sales Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="font-semibold text-gray-900">Total Vendas</h2>
                    <div class="flex items-baseline mt-1">
                        <p class="text-2xl font-bold text-gray-900">R$ 6.650,05</p>
                        <span class="ml-2 text-sm font-semibold text-green-600">+10%</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">+R$ 150 hoje</p>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="font-semibold text-gray-900">Total Pedidos</h2>
                    <div class="flex items-baseline mt-1">
                        <p class="text-2xl font-bold text-gray-900">1.212.321</p>
                        <span class="ml-2 text-sm font-semibold text-red-600">-4%</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">+2.990 hoje</p>
                </div>
            </div>
        </div>

        <!-- Visitors Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="font-semibold text-gray-900">Visitantes</h2>
                    <div class="flex items-baseline mt-1">
                        <p class="text-2xl font-bold text-gray-900">820.100</p>
                        <span class="ml-2 text-sm font-semibold text-green-600">+8%</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">+120 hoje</p>
                </div>
            </div>
        </div>

        <!-- Refunds Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-50 text-red-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="font-semibold text-gray-900">Reembolsos</h2>
                    <div class="flex items-baseline mt-1">
                        <p class="text-2xl font-bold text-gray-900">21.980</p>
                        <span class="ml-2 text-sm font-semibold text-red-600">+4%</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">+31 hoje</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Pedidos Recentes</h2>
                <p class="mt-1 text-sm text-gray-500">Últimos 5 pedidos realizados</p>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach(range(1, 5) as $index)
                <div class="p-6 flex items-center">
                    <div class="flex-shrink-0">
                        <span class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">Pedido #00{{ $index }}</h3>
                            <p class="text-sm text-gray-500">Há {{ rand(1, 59) }} minutos</p>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Cliente: João Silva</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Pago
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">R$ {{ number_format(rand(100, 1000), 2, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-6 bg-gray-50 rounded-b-xl">
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Ver todos os pedidos <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-8">
            <!-- Popular Products -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Produtos Populares</h2>
                    <p class="mt-1 text-sm text-gray-500">Top 5 produtos mais vendidos</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach(range(1, 5) as $index)
                        <div class="flex items-center">
                            <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">Produto {{ $index }}</h3>
                                <p class="text-sm text-gray-500">{{ rand(10, 100) }} vendas este mês</p>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">R$ {{ number_format(rand(50, 500), 2, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900">Visão Rápida</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Produtos em Baixa</dt>
                        <dd class="mt-1 flex items-baseline justify-between">
                            <div class="flex items-baseline text-xl font-semibold text-red-600">
                                12
                                <span class="ml-2 text-sm font-medium text-gray-500">itens</span>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Pedidos Pendentes</dt>
                        <dd class="mt-1 flex items-baseline justify-between">
                            <div class="flex items-baseline text-xl font-semibold text-yellow-600">
                                8
                                <span class="ml-2 text-sm font-medium text-gray-500">pedidos</span>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection


