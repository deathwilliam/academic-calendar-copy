<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    event: Object,
});

const form = useForm({
    title: props.event.title,
    description: props.event.description,
    start_date: props.event.start_date.substring(0, 16), // Format for datetime-local
    end_date: props.event.end_date.substring(0, 16),
    type: props.event.type,
    is_published: props.event.is_published,
});

const submit = () => {
    form.patch(route('events.update', props.event.id));
};
</script>

<template>
    <Head title="Edit Event" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="4"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="start_date" value="Start Date & Time" />
                                    <input
                                        id="start_date"
                                        v-model="form.start_date"
                                        type="datetime-local"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.start_date" />
                                </div>

                                <div>
                                    <InputLabel for="end_date" value="End Date & Time" />
                                    <input
                                        id="end_date"
                                        v-model="form.end_date"
                                        type="datetime-local"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.end_date" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="type" value="Event Type" />
                                <select
                                    id="type"
                                    v-model="form.type"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="general">General</option>
                                    <option value="exam">Exam</option>
                                    <option value="holiday">Holiday</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="deadline">Deadline</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.type" />
                            </div>

                            <!-- Published checkbox - Admin Only -->
                            <div v-if="$page.props.auth.user.role === 'administrador'" class="flex items-center">
                                <input
                                    id="is_published"
                                    v-model="form.is_published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                />
                                <InputLabel for="is_published" value="Published" class="ml-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Update Event</PrimaryButton>
                                <a
                                    :href="route('events.index')"
                                    class="text-sm text-gray-600 hover:text-gray-900"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
