<template>
    <div>
        <h3>All orders</h3>
        <div class="custom-table-container">
            <el-table :data="sortableOrders" class="custom-table">
                <el-table-column prop="id" label="ID" width="180" sortable/>
                <el-table-column prop="name" label="Customer name" width="180" sortable/>
                <el-table-column prop="phone" label="Phone number" width="180" sortable/>
                <el-table-column prop="sum" label="Total sum" sortable/>
                <el-table-column align="right">
                    <template #header>
                        <el-input v-model="search" size="small" placeholder="Type to search"/>
                    </template>
                    <template #default="scope">
                        <el-button size="small">
                            <router-link :to="{ name: 'edit', params: { id: scope.row.id }}">
                                Edit
                            </router-link>
                        </el-button>
                        <el-button size="small" type="danger" @click="deleteOrder(scope.row.id)">Delete</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
import {ElButton, ElInput, ElLoading, ElTable, ElTableColumn} from "element-plus";

export default {
    name: 'HomeView',
    components: {
        ElTable,
        ElTableColumn,
        ElInput,
        ElButton,
        ElLoading
    },
    data: () => ({
        search: '',
        orders: [],
        sortableOrders: []
    }),
    async mounted() {
        await this.fetchData();
    },
    watch: {
        search(value) {
            if(value !== '') {
                this.sortableOrders = this.orders.filter((data) => {
                    return data.id === Number(value) ||
                        data.name.toLowerCase().includes(value.toLowerCase()) ||
                        data.phone.toLowerCase().includes(value.toLowerCase()) ||
                        data.sum.toLowerCase().includes(value.toLowerCase());
                });
            } else {
                this.sortableOrders = this.orders;
            }
        }
    },
    methods: {
        async fetchData() {
            const response = await this.$axios.get('orders');
            this.orders = response.data.orders;
            this.sortableOrders = this.orders;
        },

        async deleteOrder(id) {
            if(confirm(`Вы действительно хотите удалить заказ №${id} ?`)) {
                await this.$axios.delete(`orders/${id}`);

                this.orders =  this.sortableOrders.filter((order) => order.id !== id);
                this.sortableOrders = this.orders;
            }
        }
    }
}
</script>

<style scoped>
.custom-table-container {
    padding-right: 15%;
    padding-left: 15%;
}
.custom-table {
    border-radius: 10px;
    box-shadow: 10px 10px 20px darkgray;
}
</style>
