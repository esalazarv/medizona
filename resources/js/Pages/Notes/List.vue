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
                                required class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <a
                                :href="route('note.create')"
                                type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-3 text-center mr-2 mb-2">
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
                                        <td>
                                            <div class="grid grid-cols-2">
                                                <a :href="route('note.edit', { note })" class="bg-transparent hover focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <button @click="confirmDeletion(note)" class="bg-transparent hover focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
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
                        <div v-if="isDeleting" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="create-note">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <h3 class="font-bold text-lg leading-6 text-gray-900" id="modal-title">
                                                Delete note!!
                                            </h3>
                                        </div>
                                        <div class="mt-2">
                                            This action cannot be reversed, do you want to continue?
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button @click="deleteNote" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Save
                                        </button>
                                        <button @click="cancel = false" type="button" class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
        isConfirmDialogOpen: false,
        note: null,
    }),
    computed:{
        isDeleting() {
            return this.isConfirmDialogOpen && this.note
        }
    },
    methods: {
        moment: moment,
        numeral: numeral,
        async fetchNotes(params = {}) {
            const { data } = await axios.get('/api/notes', { params }).then(({data}) => data);
            this.notes = data;
        },
        search() {
            this.fetchNotes(this.params);
        },
        confirmDeletion(note) {
            this.note = note;
            this.isConfirmDialogOpen = true;
        },
        cancel() {
            this.note = null;
            this.isConfirmDialogOpen = false;
        },
        async deleteNote() {
            const {id} = this.note;
            await axios.delete(`/api/notes/${id}`).then(({data}) => data);
            const index = this.notes.indexOf(this.note);
            this.notes.splice(index, 1);
            this.note = null;
            this.isConfirmDialogOpen = false;
        }
    },
    mounted() {
        this.fetchNotes();
    }
}
</script>
