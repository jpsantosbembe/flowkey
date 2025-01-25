<template>
    <Head title="Painel - Chaves" />

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Painel de Controle - Chaves
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center justify-between">
                            Lista de Chaves
                            <input
                                type="text"
                                placeholder="Pesquisar..."
                                class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:border-blue-500"
                                v-model="searchQuery"
                                @input="getKeys"
                            />
                        </h3>

                        <!-- Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div
                                v-for="key in keys"
                                :key="key.id"
                                class="relative p-4 border border-gray-300 rounded-lg bg-gray-50 shadow-md hover:shadow-lg cursor-pointer"
                                @click="openModal(key)"
                            >
                                <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ key.label }}</h4>
                                <p class="text-sm text-gray-600">{{ key.description }}</p>
                                <p class="text-sm text-gray-500 mt-1"><b>Guarita:</b> {{ key.guardhouse.name }}</p>
                            </div>
                        </div>

                        <p v-if="keys.length === 0" class="mt-4 text-gray-500">
                            Nenhuma chave registrada no momento.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Registrar retirada da chave
                </h3>
                <div class="mb-4">
                    <p><b>Etiqueta:</b> {{ selectedKey.label }}</p>
                    <p><b>Descrição:</b> {{ selectedKey.description }}</p>
                    <p><b>Guarita:</b> {{ selectedKey.guardhouse.name }}</p>
                </div>
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-600 mb-2">
                        Quem está retirando a chave?
                    </label>
                    <select
                        id="user"
                        v-model="personTakingKey"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300 focus:border-blue-500"
                    >
                        <option value="" disabled selected>Selecione o responsável</option>
                        <option v-for="user in selectedKey.users" :key="user.id" :value="user.name">
                            {{ user.name }}
                        </option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 mr-2"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="confirmTakeKey"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    permissions: {
        type: Array,
        required: true,
    },
});

const keys = ref([]);
const showModal = ref(false);
const searchQuery = ref('');
const selectedKey = ref({});
const personTakingKey = ref('');

function getKeys() {
    axios
        .get(route('api.keys'), {
            params: {
                search: searchQuery.value,
            },
        })
        .then(response => {
            keys.value = response.data;
        })
        .catch(error => {
            console.error("Erro ao buscar as chaves:", error);
        });
}

function openModal(key) {
    selectedKey.value = key;
    personTakingKey.value = '';
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
}

function confirmTakeKey() {
    if (!personTakingKey.value.trim()) {
        alert('Por favor, informe o nome da pessoa que está retirando a chave.');
        return;
    }
    console.log(`A chave ${selectedKey.value.label} foi retirada por ${personTakingKey.value}.`);

    closeModal();
}

onMounted(() => {
    getKeys();
});
</script>
