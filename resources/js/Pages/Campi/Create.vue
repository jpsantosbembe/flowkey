<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    props: {
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/campi');
        },
    },
    setup() {
        const form = useForm({
            nome: "",
        });
        const submit = () => {
            form.post("/campi", {
                onSuccess: () => {
                    alert("Campus criado com sucesso!");
                },
            });
        };
        return { form, submit };
    },
};
</script>

<template>
    <Head title="Criar Campus" />

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Campi -> Create
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
                                    v-model="form.nome"
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.nome" class="text-red-500 text-sm">{{ form.errors.nome }}</span>
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
