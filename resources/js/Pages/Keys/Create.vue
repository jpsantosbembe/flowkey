<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    props: {
        guardhouses: Array,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/keys');
        },
    },
    setup() {
        const form = useForm({
            label: "",
            description: "",
            guardhouse_id: "",
        });
        const submit = () => {
            form.post("/keys", {
                onSuccess: () => {
                    alert("Key criado com sucesso!");
                },
            });
        };
        return { form, submit };
    },
};
</script>

<template>
    <Head title="Criar Chave" />

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Keys -> Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Campo Nome -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Etiqueta</label>
                                <input
                                    v-model="form.label"
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.label" class="text-red-500 text-sm">{{ form.errors.label }}</span>
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <input
                                    v-model="form.description"
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</span>
                            </div>

                            <!-- Campo Seleção de Campus -->
                            <div>
                                <label for="campuses_id" class="block text-sm font-medium text-gray-700">Guarita</label>
                                <select
                                    v-model="form.guardhouse_id"
                                    id="campuses_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione uma guarita</option>
                                    <option v-for="guardhouse in guardhouses" :key="guardhouse.id" :value="guardhouse.id">
                                        {{ guardhouse.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.guardhouse_id" class="text-red-500 text-sm">{{ form.errors.guardhouse_id }}</span>
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end">
                                <SecondaryButton class="mr-2" @click="goBack">
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
