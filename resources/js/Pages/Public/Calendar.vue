<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    events: Array,
    filters: Object,
});

// Estado de búsqueda y filtros
const search = ref(props.filters?.search || '');
const selectedType = ref(props.filters?.type || '');
const startDate = ref(props.filters?.start_date || '');
const endDate = ref(props.filters?.end_date || '');

// Vista actual (month, week, day)
const currentView = ref('month');

// Fecha actual para navegación
const currentDate = ref(new Date());
const currentMonth = ref(currentDate.value.getMonth());
const currentYear = ref(currentDate.value.getFullYear());

const monthNames = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

// Tipos de eventos
const eventTypes = [
    { value: '', label: 'Todos los tipos' },
    { value: 'general', label: 'General' },
    { value: 'exam', label: 'Examen' },
    { value: 'holiday', label: 'Vacaciones' },
    { value: 'meeting', label: 'Reunión' },
    { value: 'deadline', label: 'Fecha límite' },
];

// Aplicar filtros
const applyFilters = () => {
    router.get(route('calendar.public'), {
        search: search.value,
        type: selectedType.value,
        start_date: startDate.value,
        end_date: endDate.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Limpiar filtros
const clearFilters = () => {
    search.value = '';
    selectedType.value = '';
    startDate.value = '';
    endDate.value = '';
    applyFilters();
};

// Cálculos para vista mensual
const daysInMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value + 1, 0).getDate();
});

const firstDayOfMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value, 1).getDay();
});

const calendarDays = computed(() => {
    const days = [];
    const totalDays = daysInMonth.value;
    const firstDay = firstDayOfMonth.value;

    for (let i = 0; i < firstDay; i++) {
        days.push(null);
    }

    for (let day = 1; day <= totalDays; day++) {
        days.push(day);
    }

    return days;
});

// Cálculos para vista semanal
const weekDays = computed(() => {
    const days = [];
    const today = new Date(currentYear.value, currentMonth.value, currentDate.value.getDate());
    const dayOfWeek = today.getDay();
    const startOfWeek = new Date(today);
    startOfWeek.setDate(today.getDate() - dayOfWeek);

    for (let i = 0; i < 7; i++) {
        const day = new Date(startOfWeek);
        day.setDate(startOfWeek.getDate() + i);
        days.push(day);
    }

    return days;
});

// Obtener eventos para un día específico
const getEventsForDay = (day) => {
    if (!day) return [];
    
    const date = new Date(currentYear.value, currentMonth.value, day);
    return props.events.filter(event => {
        const start = new Date(event.start_date);
        const end = new Date(event.end_date);
        return date >= new Date(start.toDateString()) && date <= new Date(end.toDateString());
    });
};

// Obtener eventos para una fecha específica (para vista semanal/diaria)
const getEventsForDate = (date) => {
    return props.events.filter(event => {
        const start = new Date(event.start_date);
        const end = new Date(event.end_date);
        const checkDate = new Date(date.toDateString());
        return checkDate >= new Date(start.toDateString()) && checkDate <= new Date(end.toDateString());
    });
};

// Navegación
const previousMonth = () => {
    if (currentMonth.value === 0) {
        currentMonth.value = 11;
        currentYear.value--;
    } else {
        currentMonth.value--;
    }
};

const nextMonth = () => {
    if (currentMonth.value === 11) {
        currentMonth.value = 0;
        currentYear.value++;
    } else {
        currentMonth.value++;
    }
};

const previousWeek = () => {
    currentDate.value.setDate(currentDate.value.getDate() - 7);
    currentDate.value = new Date(currentDate.value);
};

const nextWeek = () => {
    currentDate.value.setDate(currentDate.value.getDate() + 7);
    currentDate.value = new Date(currentDate.value);
};

const previousDay = () => {
    currentDate.value.setDate(currentDate.value.getDate() - 1);
    currentDate.value = new Date(currentDate.value);
};

const nextDay = () => {
    currentDate.value.setDate(currentDate.value.getDate() + 1);
    currentDate.value = new Date(currentDate.value);
};

// Colores por tipo de evento
const getEventTypeColor = (type) => {
    const colors = {
        general: 'bg-blue-500',
        exam: 'bg-red-500',
        holiday: 'bg-green-500',
        meeting: 'bg-purple-500',
        deadline: 'bg-orange-500',
    };
    return colors[type] || colors.general;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const formatTime = (date) => {
    return new Date(date).toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Calendario Académico" />

    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Calendario Académico</h1>
                        <p class="mt-1 text-sm text-gray-600">Eventos y fechas importantes</p>
                    </div>
                    <a
                        :href="route('calendar.export-pdf')"
                        target="_blank"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Búsqueda y Filtros -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Buscar y Filtrar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Búsqueda por texto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Título o descripción..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            @keyup.enter="applyFilters"
                        />
                    </div>

                    <!-- Filtro por tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Evento</label>
                        <select
                            v-model="selectedType"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option v-for="type in eventTypes" :key="type.value" :value="type.value">
                                {{ type.label }}
                            </option>
                        </select>
                    </div>

                    <!-- Fecha inicio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input
                            v-model="startDate"
                            type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        />
                    </div>

                    <!-- Fecha fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input
                            v-model="endDate"
                            type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        />
                    </div>
                </div>

                <div class="flex gap-2">
                    <button
                        @click="applyFilters"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                    >
                        Aplicar Filtros
                    </button>
                    <button
                        @click="clearFilters"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                    >
                        Limpiar
                    </button>
                </div>
            </div>

            <!-- Selector de Vista y Controles -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <!-- Selector de Vista -->
                    <div class="flex gap-2">
                        <button
                            @click="currentView = 'month'"
                            :class="currentView === 'month' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-lg hover:opacity-90 transition"
                        >
                            Mes
                        </button>
                        <button
                            @click="currentView = 'week'"
                            :class="currentView === 'week' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-lg hover:opacity-90 transition"
                        >
                            Semana
                        </button>
                        <button
                            @click="currentView = 'day'"
                            :class="currentView === 'day' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
                            class="px-4 py-2 rounded-lg hover:opacity-90 transition"
                        >
                            Día
                        </button>
                    </div>

                    <!-- Navegación -->
                    <div class="flex items-center gap-4">
                        <button
                            @click="currentView === 'month' ? previousMonth() : currentView === 'week' ? previousWeek() : previousDay()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            ← Anterior
                        </button>
                        <h2 class="text-xl font-bold text-gray-800">
                            <span v-if="currentView === 'month'">{{ monthNames[currentMonth] }} {{ currentYear }}</span>
                            <span v-else-if="currentView === 'week'">Semana del {{ formatDate(weekDays[0]) }}</span>
                            <span v-else>{{ formatDate(currentDate) }}</span>
                        </h2>
                        <button
                            @click="currentView === 'month' ? nextMonth() : currentView === 'week' ? nextWeek() : nextDay()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        >
                            Siguiente →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vista Mensual -->
            <div v-if="currentView === 'month'" class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-7 gap-2">
                    <!-- Encabezados de días -->
                    <div
                        v-for="day in ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']"
                        :key="day"
                        class="text-center font-semibold text-gray-700 py-2"
                    >
                        {{ day }}
                    </div>

                    <!-- Días del calendario -->
                    <div
                        v-for="(day, index) in calendarDays"
                        :key="index"
                        class="min-h-24 border rounded-lg p-2"
                        :class="day ? 'bg-white hover:bg-gray-50' : 'bg-gray-100'"
                    >
                        <div v-if="day" class="h-full flex flex-col">
                            <span class="text-sm font-semibold text-gray-700 mb-1">{{ day }}</span>
                            <div class="flex-1 space-y-1">
                                <div
                                    v-for="event in getEventsForDay(day)"
                                    :key="event.id"
                                    :class="getEventTypeColor(event.type)"
                                    class="text-xs text-white px-2 py-1 rounded truncate"
                                    :title="event.title"
                                >
                                    {{ event.title }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista Semanal -->
            <div v-if="currentView === 'week'" class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-7 gap-2">
                    <div
                        v-for="(day, index) in weekDays"
                        :key="index"
                        class="border rounded-lg p-3"
                    >
                        <div class="text-center mb-2">
                            <div class="font-semibold text-gray-700">{{ dayNames[day.getDay()] }}</div>
                            <div class="text-sm text-gray-500">{{ day.getDate() }}</div>
                        </div>
                        <div class="space-y-2">
                            <div
                                v-for="event in getEventsForDate(day)"
                                :key="event.id"
                                :class="getEventTypeColor(event.type)"
                                class="text-xs text-white px-2 py-2 rounded"
                            >
                                <div class="font-semibold">{{ event.title }}</div>
                                <div class="text-xs opacity-90">{{ formatTime(event.start_date) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista Diaria -->
            <div v-if="currentView === 'day'" class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="space-y-4">
                    <div v-if="getEventsForDate(currentDate).length === 0" class="text-center py-8 text-gray-500">
                        No hay eventos para este día.
                    </div>
                    <div
                        v-for="event in getEventsForDate(currentDate)"
                        :key="event.id"
                        class="border-l-4 pl-4 py-3"
                        :class="getEventTypeColor(event.type).replace('bg-', 'border-')"
                    >
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-bold text-lg">{{ event.title }}</h4>
                                <p class="text-gray-600 mt-1">{{ event.description }}</p>
                                <div class="flex gap-4 mt-2 text-sm text-gray-500">
                                    <span>{{ formatTime(event.start_date) }} - {{ formatTime(event.end_date) }}</span>
                                    <span class="capitalize">{{ event.type }}</span>
                                </div>
                            </div>
                            <div
                                :class="getEventTypeColor(event.type)"
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold"
                            >
                                {{ event.type }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leyenda -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Leyenda</h3>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                        <span class="text-sm">General</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                        <span class="text-sm">Examen</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                        <span class="text-sm">Vacaciones</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded mr-2"></div>
                        <span class="text-sm">Reunión</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-500 rounded mr-2"></div>
                        <span class="text-sm">Fecha límite</span>
                    </div>
                </div>
            </div>

            <!-- Lista de Próximos Eventos -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold text-lg mb-4">Próximos Eventos</h3>
                <div v-if="events.length === 0" class="text-center py-8 text-gray-500">
                    No hay eventos publicados.
                </div>
                <div v-else class="space-y-3">
                    <div
                        v-for="event in events.slice(0, 10)"
                        :key="event.id"
                        class="border-l-4 pl-4 py-2"
                        :class="getEventTypeColor(event.type).replace('bg-', 'border-')"
                    >
                        <h4 class="font-semibold">{{ event.title }}</h4>
                        <p class="text-sm text-gray-600">{{ event.description }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ formatDate(event.start_date) }}
                            -
                            {{ formatDate(event.end_date) }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
