<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    event: Object,
    audits: Array,
});

const revertToVersion = (auditId) => {
    if (confirm('Are you sure you want to revert to this version?')) {
        router.post(route('events.revert', { event: props.event.id, audit: auditId }));
    }
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
</script>

<template>
    <Head title="Event History" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event History: {{ event.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-4">
                            <a
                                :href="route('events.index')"
                                class="text-indigo-600 hover:text-indigo-900"
                            >
                                ← Back to Events
                            </a>
                        </div>

                        <div v-if="audits.length === 0" class="text-center py-8 text-gray-500">
                            No history available for this event.
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="audit in audits"
                                :key="audit.id"
                                class="border rounded-lg p-4"
                            >
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold">{{ audit.event }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ formatDate(audit.created_at) }}
                                            by {{ audit.user?.name || 'System' }}
                                        </p>
                                    </div>
                                    <button
                                        v-if="audit.old_values"
                                        @click="revertToVersion(audit.id)"
                                        class="px-3 py-1 text-sm bg-orange-500 hover:bg-orange-600 text-white rounded"
                                    >
                                        Revert to this version
                                    </button>
                                </div>

                                <div v-if="audit.old_values" class="mt-3 text-sm">
                                    <p class="font-semibold mb-1">Changes:</p>
                                    <div class="bg-gray-50 p-3 rounded">
                                        <div
                                            v-for="(value, key) in audit.old_values"
                                            :key="key"
                                            class="mb-2"
                                        >
                                            <span class="font-medium">{{ key }}:</span>
                                            <div class="ml-4">
                                                <p class="text-red-600">
                                                    - {{ value }}
                                                </p>
                                                <p class="text-green-600">
                                                    + {{ audit.new_values[key] }}
                                                </p>
                                            </div>
                                        </div>
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
