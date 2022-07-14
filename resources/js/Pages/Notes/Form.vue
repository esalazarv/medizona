<template>
    <Head title="Notes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a note
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 grid grid-cols-2 space-x-5">
                        <div class="mb-6">
                            <input
                                id="customer-search"
                                type="text"
                                @click="openCustomerDropDown"
                                placeholder="Search customers..."
                                v-model="customerParams.q"
                                v-debounce:300ms="searchCustomers"
                                class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <div v-click-outside="closeCustomerDropDown" :class="{ hidden: !customerDropDownOpen }"
                                 class="max-w-xs absolute z-10 bg-white divide-y divide-white-100 rounded shadow w-full dark:bg-white-700 shadow-lg shadow-gray-400/100">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                    <template v-if="customers.length">
                                        <li v-for="customer in customers">
                                            <a href="#"
                                               @click="selectCustomer(customer)"
                                               class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-600 text-gray-500 dark:hover:text-white">
                                                {{ customer.name }}
                                            </a>
                                        </li>
                                    </template>
                                    <li v-else class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-600 text-gray-500 dark:hover:text-white">
                                        No results found
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-6">
                            <input
                                id="item"
                                type="text"
                                @click="openItemDropDown"
                                placeholder="Search items..."
                                v-model="itemParams.q"
                                v-debounce:300ms="searchItems"
                                class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <div v-click-outside="closeItemDropDown" :class="{ hidden: !itemDropDownOpen }"
                                 class="max-w-xs absolute z-10 bg-white divide-y divide-white-100 rounded shadow w-full dark:bg-white-700 shadow-lg shadow-gray-400/100">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                    <template v-if="items.length">
                                        <li v-for="item in items">
                                            <a href="#"
                                               @click="selectItem(item)"
                                               class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-600 text-gray-500 dark:hover:text-white">
                                                {{ item.name }}
                                            </a>
                                        </li>
                                    </template>
                                    <li v-else class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-600 text-gray-500 dark:hover:text-white">
                                        No results found
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-2 space-x-5">
                        <div>
                            <div class="w-full block p-6 rounded-lg shadow-md bg-white">
                                <div class="grid grid-cols-8">
                                    <label for="customer-search" class="col-span-7 block mb-2 text-sm font-medium">
                                        Customer
                                    </label>
                                    <span
                                        v-if="customer.id"
                                        class="px-3 rounded-full text-gray-500 bg-gray-200 font-semibold text-sm flex align-center w-max cursor-pointer active:bg-gray-300 transition duration-300 ease">
                                        <button @click="removeCustomer" class="bg-transparent hover focus:outline-none">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times"
                                                 class="w-3" role="img" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 352 512">
                                                <path fill="currentColor"
                                                      d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                                                </path>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                                <h5 class=" text-gray-900 text-xl leading-tight font-medium mb-2">
                                    Name: {{customer.name}}
                                </h5>
                                <p class="text-gray-700 text-base mb-4">
                                    Email: {{customer.email}}
                                </p>
                                <div>
                                    Address:
                                    <p class="text-gray-700 text-base mb-4">
                                        {{customer.address}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <table class="w-full text-sm text-gray-800">
                                <thead>
                                    <tr>
                                        <th class="text-left">Name</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="text-right"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in selectedItems" class="bg-white border-b border-gray-200 py-5">
                                        <td>
                                            {{item.name}}
                                        </td>
                                        <td class="text-right px-2">
                                            {{numeral(item.price).format('$0,0.00')}}
                                        </td>
                                        <td class="w-24 px-2">
                                            <input
                                                id="item-qtty"
                                                type="number"
                                                min="0"
                                                v-model="item.quantity"
                                                class="w-24 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                            >
                                        </td>
                                        <td class="text-right">
                                            {{numeral(item.price * item.quantity).format('$0,0.00')}}
                                        </td>
                                        <td class="text-right px-5">
                                            <button @click="removeItem(item)" class="bg-transparent hover focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-6 flex justify-end content-end text-3xl">
                        Total: <span class="font-bold mx-4">{{numeral(total).format('$0,0.00')}}</span>
                    </div>
                    <div class="p-6 flex justify-end content-end text-3xl">
                        <button
                            :disabled="!canSubmit"
                            type="button"
                            :class="{disabled: !canSubmit }"
                            @click="submit"
                            class="disabled:opacity-55 disabled:bg-blue-300 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-3 text-center mr-2 mb-2">
                            Save Note
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia'

import ClickOutside from "@/Directives/ClickOutside";
import * as moment from "moment";
import * as numeral from "numeral";

export default {
    name: "Create",
    props: {
        note: {}
    },
    components: {
        Head,
        BreezeAuthenticatedLayout,
    },
    directives: {
        ClickOutside: ClickOutside
    },
    data: () => ({
        customerDropDownOpen: false,
        itemDropDownOpen: false,
        customerParams: {
            q: '',
        },
        itemParams: {
            q: '',
        },
        customers: [],
        items: [],
        customer: {},
        selectedItems: []
    }),
    computed: {
      total() {
          return this.selectedItems.reduce((total, item) => {
              const subtotal = item.price * item.quantity;
              return total += subtotal;
          }, 0);
      },
        canSubmit() {
          return this.customer.id && this.total
        }
    },
    methods: {
        moment: moment,
        numeral: numeral,
        async searchCustomers() {
            const params = this.customerParams;
            const { data } = await axios.get('/api/customers', { params }).then(({data}) => data);
            this.customers = data;
        },
        async searchItems() {
            const params = this.itemParams;
            const { data } = await axios.get('/api/items', { params }).then(({data}) => data);
            this.items = data;
        },
        async fetchNote(id) {
            const { data } = await axios.get(`/api/notes/${id}`, ).then(({data}) => data);
            this.customer = {...data.customer};
            this.selectedItems = [...data.items];
        },
        openCustomerDropDown (event) {
            event.stopPropagation();
            this.searchCustomers();
            this.customerDropDownOpen = true
        },
        closeCustomerDropDown() {
            this.customerDropDownOpen = false
        },
        selectCustomer(customer) {
            this.customer = customer;
            this.customerParams.q = ''
            this.closeCustomerDropDown()
        },
        removeCustomer() {
            this.customer = {};
        },
        openItemDropDown(event) {
            event.stopPropagation();
            this.searchItems();
            this.itemDropDownOpen = true
        },
        closeItemDropDown() {
            this.itemDropDownOpen = false
        },
        selectItem(item) {
            this.selectedItems.push({...item, quantity: 1})
            this.itemParams.q = ''
            this.closeItemDropDown()
        },
        removeItem(item) {
            const index = this.selectedItems.indexOf(item)
            this.selectedItems.splice(index, 1)
        },
        async createNote()  {
            const items = this.selectedItems
                .map(({id, quantity}) => ({id, quantity}));
            const payload = {
                customer_id: this.customer.id,
                items
            };

            await axios.post('/api/notes', payload).then(({data}) => data);
            Inertia.visit(route('dashboard'))
        },
        async updateNote()  {
            const items = this.selectedItems
                .map(({id, quantity}) => ({id, quantity}));
            const payload = {
                customer_id: this.customer.id,
                items
            };

            const {id} = this.note;
            await axios.patch(`/api/notes/${id}`, payload).then(({data}) => data);
            Inertia.visit(route('dashboard'))
        },
        async submit() {
            if (this.note.id) {
               return await this.updateNote();
            }
            return await this.createNote();
        }
    },
    mounted() {
        if (this.note.id) {
            this.fetchNote(this.note.id)
        }
    }
}
</script>

<style scoped>

</style>
