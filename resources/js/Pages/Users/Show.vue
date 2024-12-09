<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

export default {
    components: {Head, AuthenticatedLayout},
    props: {
        users: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/users');
        },
    }
};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Usuarios
            </h2>
        </template>,

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex justify-end mb-2">
                    <button
                        class = "bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none"
                        @click="goBack()"
                    >
                        Mostrar
                    </button>
                </div>


                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>

                    <div class="p-6 text-gray-900">
                        {{users.id}}
                    </div>

                    <div class="p-6 text-gray-900">
                        Nome: {{users.name}}
                    </div>

                    <div class="p-6 text-gray-900">
                        E-mail: {{users.email}}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
