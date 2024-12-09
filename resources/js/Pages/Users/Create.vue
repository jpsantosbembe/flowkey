<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    methods: {
        goBack() {
            this.$inertia.visit('/users');
        },
    },
    setup() {
        const form = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        });

        const submit = () => {
            form.post("/users", {
                onSuccess: () => {
                    alert("Usuário criado com sucesso!");
                },
            });
        };

        return { form, submit };
    },
};
</script>

<template>
    <Head title="Criar Usuário" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Criar Usuário
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input
                                    v-model="form.name"
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                                <input
                                    v-model="form.email"
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                                <input
                                    v-model="form.password"
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirme a Senha</label>
                                <input
                                    v-model="form.password_confirmation"
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>

                            <div class="flex justify-end">
                                <SecondaryButton
                                    class="mr-2"
                                    @click="goBack()"
                                >
                                    Voltar
                                </SecondaryButton>
                                <PrimaryButton type="submit">Cadastrar</PrimaryButton>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
