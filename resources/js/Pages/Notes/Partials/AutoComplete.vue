<template>
    <div>
        <label for="customer-search" class="block mb-2 text-sm font-medium">
            Customer
        </label>
        <input
            id="customer-search"
            type="text"
            @click="openDropDown"
            placeholder="Search customers..."
            v-debounce:300ms="search"
            class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
        >
        <div v-click-outside="closeDropDown" :class="{ hidden: !isDropDownOpen }"
             class="absolute z-10 bg-white divide-y divide-white-100 rounded shadow w-full dark:bg-white-700 shadow-lg shadow-gray-400/100">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-600 text-gray-500 dark:hover:text-white">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import ClickOutside from "@/Directives/ClickOutside";

export default {
    name: "AutoComplete",
    directives: {
        ClickOutside: ClickOutside
    },
    data: () => ({
        isDropDownOpen: false,
        customerParams: {
            q: '',
        },
        customers: [],
    }),
    methods: {
        async search() {
            const params = this.customerParams;
            const { data } = await axios.get('/api/customers', { params }).then(({data}) => data);
            this.customers = data;
        },
        openDropDown (event) {
            event.stopPropagation();
            this.customerDropDownOpen = true
        },
        closeDropDown() {
            this.customerDropDownOpen = false
        }
    }
}
</script>

<style scoped>

</style>
