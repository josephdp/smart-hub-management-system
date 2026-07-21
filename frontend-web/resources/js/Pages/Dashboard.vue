<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    equipments: Array
});

const page = usePage();
const processingId = ref(null);

// Form state untuk Create Data Master
const form = ref({
    name: '',
    description: '',
    stock: 1
});

const handleCreateEquipment = () => {
    // Mengambil token atau mengirim request dengan kredensial sesi
    fetch('http://127.0.0.1:8000/api/equipments', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(form.value)
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok) {
            alert('Data master peralatan berhasil ditambahkan!');
            form.value.name = '';
            form.value.description = '';
            form.value.stock = 1;
            router.reload();
        } else {
            alert('Gagal: ' + (data.message || JSON.stringify(data.errors) || 'Terjadi kesalahan.'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Gagal terhubung ke server API Backend.');
    });
};

// Fungsi Delete Data Master
const handleDeleteEquipment = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data alat ini?')) {
        fetch(`http://127.0.0.1:8000/api/equipments/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })
        .then(res => {
            if (res.ok) {
                alert('Data berhasil dihapus!');
                router.reload();
            } else {
                alert('Gagal menghapus data.');
            }
        });
    }
};

// Fungsi Check-in
const handleCheckIn = (id) => {
    if (confirm('Apakah Anda yakin ingin memproses check-in untuk alat ini?')) {
        processingId.value = id;
        
        fetch(`http://127.0.0.1:8000/api/check-in/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok) {
                alert('Check-in berhasil diproses dan email terkirim!');
                router.reload();
            } else {
                alert('Gagal: ' + (data.message || 'Terjadi kesalahan.'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal terhubung ke server API Backend.');
        })
        .finally(() => {
            processingId.value = null;
        });
    }
};
</script>

<template>
    <Head title="Smart-Hub Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Smart-Hub Inventory & Transaction Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- MODUL 1: MANAGE DATA MASTER (CREATE & LIST) -->
                <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Tambah Data Master Peralatan</h3>
                    <form @submit.prevent="handleCreateEquipment" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" v-model="form.name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <input type="text" v-model="form.description" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" v-model="form.stock" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div class="md:col-span-3">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition-all">
                                Simpan Data Master Baru
                            </button>
                        </div>
                    </form>
                </div>

                <!-- MODUL 2: LIST & MANAGE TRANSACTION -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold">List Master Data & Transaksi Check-In</h3>
                            <span class="px-3 py-1 text-sm text-green-700 bg-green-100 rounded-full">
                                Sistem Terhubung ke Cloud DB (Supabase)
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Alat</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Deskripsi</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Stok</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Aksi Master (Delete)</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Aksi Transaksi (Check-In)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="item in equipments" :key="item.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ item.description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-semibold">{{ item.stock }} Unit</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button @click="handleDeleteEquipment(item.id)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                                                Hapus
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button 
                                                @click="handleCheckIn(item.id)"
                                                :disabled="processingId === item.id"
                                                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition-all disabled:opacity-50 text-sm"
                                            >
                                                {{ processingId === item.id ? 'Memproses...' : 'Check-In Alat' }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="equipments.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data peralatan yang tersedia di database.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>