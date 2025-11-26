<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Calendario Académico - Bienvenido" />
    
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-3">
                        <svg class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-2xl font-bold text-gray-900">Calendario Académico</span>
                    </div>
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium transition"
                        >
                            Panel
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium transition"
                            >
                                Acceso
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md"
                            >
                                Registro
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative overflow-hidden py-20 lg:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                Gestiona tu
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                                    Calendario Académico
                                </span>
                            </h1>
                            <p class="text-xl text-gray-600 leading-relaxed">
                                Organiza eventos, exámenes y fechas importantes de manera eficiente. 
                                Mantén a toda la comunidad educativa informada y sincronizada.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <Link
                                :href="route('calendar.public')"
                                class="px-8 py-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-xl font-semibold flex items-center gap-2"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Ver Calendario
                            </Link>
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('login')"
                                class="px-8 py-4 bg-white text-indigo-600 rounded-lg hover:bg-gray-50 transition shadow-md border-2 border-indigo-600 font-semibold"
                            >
                                Iniciar Sesión
                            </Link>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-3xl transform rotate-3 opacity-20"></div>
                        <img
                            src="/images/calendar_hero.png"
                            alt="Calendario Académico"
                            class="relative rounded-3xl shadow-2xl"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Características Principales
                    </h2>
                    <p class="text-xl text-gray-600">
                        Todo lo que necesitas para gestionar tu calendario académico
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-indigo-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Gestión de Eventos</h3>
                        <p class="text-gray-600">
                            Crea, edita y elimina eventos fácilmente. Organiza exámenes, vacaciones, reuniones y más.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-purple-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Vista Pública</h3>
                        <p class="text-gray-600">
                            Calendario público accesible para toda la comunidad educativa sin necesidad de login.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-green-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Exportar PDF</h3>
                        <p class="text-gray-600">
                            Descarga el calendario completo en formato PDF para imprimirlo o compartirlo offline.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-orange-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Historial de Cambios</h3>
                        <p class="text-gray-600">
                            Rastrea todas las modificaciones y revierte cambios cuando sea necesario.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-cyan-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Tipos de Eventos</h3>
                        <p class="text-gray-600">
                            Clasifica eventos por tipo: exámenes, vacaciones, reuniones, fechas límite y más.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-2xl p-8 hover:shadow-xl transition">
                        <div class="bg-yellow-600 w-14 h-14 rounded-xl flex items-center justify-center mb-6">
                            <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Panel Seguro</h3>
                        <p class="text-gray-600">
                            Acceso restringido para administradores con control total sobre la publicación de eventos.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Institute Image Section -->
        <section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <img
                            src="/images/academic_building.png"
                            alt="Instituto Académico"
                            class="rounded-2xl shadow-2xl"
                        />
                    </div>
                    <div class="text-white space-y-6">
                        <h2 class="text-4xl font-bold">
                            Diseñado para Instituciones Educativas
                        </h2>
                        <p class="text-xl text-indigo-100 leading-relaxed">
                            Nuestra plataforma está especialmente diseñada para satisfacer las necesidades 
                            de universidades, colegios e institutos. Mantén a estudiantes, profesores y 
                            personal administrativo siempre informados.
                        </p>
                        <div class="flex items-center space-x-4">
                            <div class="flex -space-x-2">
                                <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                                <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                                <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white"></div>
                            </div>
                            <span class="text-indigo-100">Usado por miles de estudiantes</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-12 shadow-2xl">
                    <h2 class="text-4xl font-bold text-white mb-6">
                        ¿Listo para organizar tu calendario?
                    </h2>
                    <p class="text-xl text-indigo-100 mb-8">
                        Comienza a gestionar tus eventos académicos de manera profesional
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <Link
                            :href="route('calendar.public')"
                            class="px-8 py-4 bg-white text-indigo-600 rounded-lg hover:bg-gray-50 transition shadow-lg font-semibold"
                        >
                            Explorar Calendario
                        </Link>
                        <Link
                            v-if="!$page.props.auth.user && canRegister"
                            :href="route('register')"
                            class="px-8 py-4 bg-indigo-800 text-white rounded-lg hover:bg-indigo-900 transition shadow-lg font-semibold border-2 border-white"
                        >
                            Crear Cuenta
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white font-bold text-lg">Calendario Académico</span>
                        </div>
                        <p class="text-sm">
                            Gestión profesional de eventos académicos para instituciones educativas.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Enlaces Rápidos</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <Link :href="route('calendar.public')" class="hover:text-white transition">
                                    Calendario Público
                                </Link>
                            </li>
                            <li v-if="canLogin">
                                <Link :href="route('login')" class="hover:text-white transition">
                                    Iniciar Sesión
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Tecnología</h3>
                        <p class="text-sm">
                            Desarrollado con Laravel, Vue.js e Inertia.js
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                    <p>&copy; 2025 Calendario Académico. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>
</template>
