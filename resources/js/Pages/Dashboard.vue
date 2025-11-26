<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Bienvenido, {{ $page.props.auth.user.name }}</h3>
                        </div>

                        <!-- Administrador Dashboard -->
                        <div v-if="$page.props.auth.user.role === 'administrador'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="p-4 border rounded-lg bg-blue-50">
                                <h4 class="font-bold text-blue-800 mb-2">Gestión de Eventos</h4>
                                <p class="text-sm text-gray-600 mb-4">Administra todos los eventos del calendario académico.</p>
                                <div class="flex gap-2">
                                    <Link :href="route('events.index')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Ver Eventos
                                    </Link>
                                    <Link :href="route('events.create')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        Crear Nuevo Evento
                                    </Link>
                                </div>
                            </div>
                            
                            <div class="p-4 border rounded-lg bg-purple-50">
                                <h4 class="font-bold text-purple-800 mb-2">Vista Pública</h4>
                                <p class="text-sm text-gray-600 mb-4">Visualiza cómo ven el calendario los usuarios y estudiantes.</p>
                                <div class="flex gap-2">
                                    <a :href="route('calendar.public')" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 inline-block">
                                        Ver Calendario ↗
                                    </a>
                                    <a :href="route('calendar.export-pdf')" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 inline-block">
                                        Exportar PDF 📥
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Editor Dashboard -->
                        <div v-else-if="$page.props.auth.user.role === 'editor'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="p-4 border rounded-lg bg-green-50">
                                <h4 class="font-bold text-green-800 mb-2">Edición de Eventos</h4>
                                <p class="text-sm text-gray-600 mb-4">Crea y edita eventos del calendario académico.</p>
                                <div class="flex gap-2">
                                    <Link :href="route('events.index')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        Ver Eventos
                                    </Link>
                                    <Link :href="route('events.create')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Crear Evento
                                    </Link>
                                </div>
                            </div>
                            
                            <div class="p-4 border rounded-lg bg-purple-50">
                                <h4 class="font-bold text-purple-800 mb-2">Vista Pública</h4>
                                <p class="text-sm text-gray-600 mb-4">Visualiza cómo ven el calendario los usuarios.</p>
                                <div class="flex gap-2">
                                    <a :href="route('calendar.public')" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 inline-block">
                                        Ver Calendario ↗
                                    </a>
                                    <a :href="route('calendar.export-pdf')" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 inline-block">
                                        Exportar PDF 📥
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Auditor Dashboard -->
                        <div v-else-if="$page.props.auth.user.role === 'auditor'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="p-4 border rounded-lg bg-orange-50">
                                <h4 class="font-bold text-orange-800 mb-2">Auditoría de Eventos</h4>
                                <p class="text-sm text-gray-600 mb-4">Visualiza eventos y su historial de cambios.</p>
                                <div class="flex gap-2">
                                    <Link :href="route('events.index')" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
                                        Ver Eventos
                                    </Link>
                                </div>
                            </div>
                            
                            <div class="p-4 border rounded-lg bg-purple-50">
                                <h4 class="font-bold text-purple-800 mb-2">Vista Pública</h4>
                                <p class="text-sm text-gray-600 mb-4">Visualiza el calendario público.</p>
                                <div class="flex gap-2">
                                    <a :href="route('calendar.public')" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 inline-block">
                                        Ver Calendario ↗
                                    </a>
                                    <a :href="route('calendar.export-pdf')" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 inline-block">
                                        Exportar PDF 📥
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Default for other users -->
                        <div v-else class="mt-4">
                            <p class="text-gray-600">Bienvenido al Calendario Académico.</p>
                            <div class="mt-4">
                                <a :href="route('calendar.public')" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 inline-block">
                                    Ver Calendario Público ↗
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
