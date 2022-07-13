<template>
    <Head title="Notes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 pb-2 grid grid-cols-3 bg-white border-b border-gray-200">
                        <div class="text-xl">
                            <input
                                v-model="params.q"
                                v-debounce:300ms="search"
                                type="search"
                                placeholder="Search..."
                                required class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <a type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-3 text-center mr-2 mb-2">
                                Create Note
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <table class="w-full text-sm text-left text-gray-800">
                            <thead>
                            <tr>
                                <th class="py-4 px-6">id</th>
                                <th class="py-4 px-6">Customer</th>
                                <th class="py-4 px-6">Date</th>
                                <th class="py-4 px-6">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                <template v-if="notes.length">
                                    <tr v-for="note in notes" class="bg-white border-b border-gray-200">
                                        <td class="py-4 px-6">{{note.id}}</td>
                                        <td class="py-4 px-6">{{note.customer.name}}</td>
                                        <td class="py-4 px-6">{{moment(note.date).format( 'YYYY-MM-DD')}}</td>
                                        <td class="py-4 px-6">{{numeral(note.total).format('$0,0.00')}}</td>
                                    </tr>
                                </template>
                                <tr v-else class="w-full text-sm text-center">
                                    <td colspan="5" class="w-full">
                                        <div class="p-6 flex flex-col items-center">
                                            <span class="py-5">Nothing here</span>
                                            <button
                                                type="button"
                                                @click="fetchNotes"
                                                class="max-w-xs text-gray-500 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-3 text-center mr-2 mb-2"
                                            >
                                                Cargar de nuevo
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import * as moment from 'moment'
import * as numeral from 'numeral'

export default {
    components: {
        Head,
        BreezeAuthenticatedLayout,
    },
    props: {
    },
    data: () => ({
        params: {
            q: '',
        },
        notes: [],
    }),
    methods: {
        moment: moment,
        numeral: numeral,
        async fetchNotes(params = {}) {
            const { data } = await axios.get('/api/notes', { params }).then(({data}) => data);
            this.notes = data;
        },
        search() {
            this.fetchNotes(this.params);
        }
    },
    mounted() {
        this.fetchNotes();
    }
}
</script>
