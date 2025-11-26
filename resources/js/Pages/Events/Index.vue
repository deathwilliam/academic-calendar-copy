<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

defineProps({
    events: Array,
});

const deleteEvent = (id) => {
    if (confirm('Are you sure you want to delete this event?')) {
        router.delete(route('events.destroy', id));
    }
};

const togglePublish = (event) => {
    router.patch(route('events.update', event.id), {
        ...event,
        is_published: !event.is_published,
    });
};

const getEventTypeColor = (type) => {
    const colors = {
        general: 'bg-blue-100 text-blue-800',
        exam: 'bg-red-100 text-red-800',
        holiday: 'bg-green-100 text-green-800',
        meeting: 'bg-purple-100 text-purple-800',
        deadline: 'bg-orange-100 text-orange-800',
    };
    return colors[type] || colors.general;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const isAdmin = () => {
    return window.Laravel?.user?.role === 'administrador' || false;
};
</script>

<template>
    <Head title="Event Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event Management</h2>
                    <span 
                        class="px-2 py-1 text-xs rounded-full"
                        :class="{
                            'bg-red-100 text-red-800': $page.props.auth.user.role === 'administrador',
                            'bg-blue-100 text-blue-800': $page.props.auth.user.role === 'editor',
                            'bg-purple-100 text-purple-800': $page.props.auth.user.role === 'auditor'
                        }"
                    >
                        {{ $page.props.auth.user.role.toUpperCase() }}
                    </span>
                </div>
                <!-- Create button - Admin & Editor only -->
                <Link
                    v-if="['administrador', 'editor'].includes($page.props.auth.user.role)"
                    :href="route('events.create')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                >
                    Create New Event
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="events.length === 0" class="text-center py-8 text-gray-500">
                            No events found. Create your first event!
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="event in events"
                                :key="event.id"
                                class="border rounded-lg p-4 hover:shadow-md transition-shadow"
                            >
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="text-lg font-semibold">{{ event.title }}</h3>
                                            <span
                                                :class="getEventTypeColor(event.type)"
                                                class="px-2 py-1 text-xs rounded-full"
                                            >
                                                {{ event.type }}
                                            </span>
                                            <span
                                                v-if="event.is_published"
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800"
                                            >
                                                Published
                                            </span>
                                            <span
                                                v-else
                                                class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800"
                                            >
                                                Draft
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-2">{{ event.description }}</p>
                                        <div class="text-sm text-gray-500">
                                            <p>Start: {{ formatDate(event.start_date) }}</p>
                                            <p>End: {{ formatDate(event.end_date) }}</p>
                                            <p class="mt-1">Created by: {{ event.user?.name }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-2 ml-4">
                                        <!-- Publish/Unpublish - Admin Only -->
                                        <button
                                            v-if="$page.props.auth.user.role === 'administrador'"
                                            @click="togglePublish(event)"
                                            class="px-3 py-1 text-sm rounded"
                                            :class="
                                                event.is_published
                                                    ? 'bg-gray-200 hover:bg-gray-300'
                                                    : 'bg-green-500 hover:bg-green-600 text-white'
                                            "
                                        >
                                            {{ event.is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                        <!-- Edit - Admin & Editor -->
                                        <Link
                                            v-if="['administrador', 'editor'].includes($page.props.auth.user.role)"
                                            :href="route('events.edit', event.id)"
                                            class="px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded text-center"
                                        >
                                            Edit
                                        </Link>
                                        <!-- History - All roles -->
                                        <Link
                                            :href="route('events.audits', event.id)"
                                            class="px-3 py-1 text-sm bg-purple-500 hover:bg-purple-600 text-white rounded text-center"
                                        >
                                            History
                                        </Link>
                                        <!-- Delete - Admin Only -->
                                        <button
                                            v-if="$page.props.auth.user.role === 'administrador'"
                                            @click="deleteEvent(event.id)"
                                            class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
