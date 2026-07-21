<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    transactions: {
        type: Array,
        default: () => []
    }
});

// Menggunakan useForm dari Inertia agar otomatis aman secara autentikasi & CSRF
const form = useForm({
    equipment_id: '',
    user_id: 1,
    borrow_time: '',
    status: 'borrowed'
});

const handleCreateTransaction = () => {
    // Format waktu agar sesuai dengan standar database
    const formattedTime = form.borrow_time ? form.borrow_time.replace('T', ' ') + ':00' : '';
    
    const payload = {
        equipment_id: form.equipment_id,
        user_id: form.user_id,
        borrow_time: formattedTime,
        status: form.status
    };

    // Gunakan fetch murni agar langsung menembak API backend port 8000
    fetch('http://127.0.0.1:8000/api/transactions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'include', // Membawa sesi kuki backend
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok) {
            alert('Transaksi peminjaman berhasil dibuat!');
            form.equipment_id = '';
            form.borrow_time = '';
            router.reload();
        } else {
            alert('Gagal: ' + (data.message || JSON.stringify(data.errors) || 'Terjadi kesalahan'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan koneksi ke server.');
    });
};

// Fungsi Update Status Transaksi
const handleUpdateStatus = (id, currentStatus) => {
    const newStatus = prompt('Masukkan status baru (contoh: returned / active):', currentStatus);
    if (!newStatus) return;

    // Menggunakan fetch dengan credential include agar kuki sesi web ikut terkirim
    fetch(`http://127.0.0.1:8000/api/transactions/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify({ status: newStatus })
    })
    .then(async res => {
        if (res.ok) {
            alert('Status transaksi berhasil diperbarui!');
            window.location.reload();
        } else {
            alert('Gagal memperbarui status.');
        }
    })
    .catch(err => console.error(err));
};
</script>

<template>
    <Head title="Manajemen Transaksi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Modul Manajemen Transaksi Peminjaman
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <!-- FORM CREATE TRANSAKSI -->
                <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Buat Transaksi Peminjaman Baru</h3>
                    <form @submit.prevent="handleCreateTransaction" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID Alat (Equipment ID)</label>
                            <input type="number" v-model="form.equipment_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 1" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu Pinjam</label>
                            <input type="datetime-local" v-model="form.borrow_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <input type="text" v-model="form.status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- LIST & UPDATE TRANSAKSI -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4">Daftar Riwayat Transaksi</h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ID Transaksi</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Alat</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Waktu Pinjam</th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">Aksi (Update)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="trx in transactions" :key="trx.id">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ trx.id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ trx.equipment ? trx.equipment.name : 'Alat ID: ' + trx.equipment_id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ trx.borrow_time }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded font-semibold">{{ trx.status }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button @click="handleUpdateStatus(trx.id, trx.status)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                                Update Status
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="!transactions || transactions.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data transaksi peminjaman.
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