<template>
    <div>
        <h3>All orders</h3>
        <div class="custom-table-container">
            <el-table :data="sortableTableData" class="custom-table">
                <el-table-column prop="id" label="ID" width="180" sortable/>
                <el-table-column prop="name" label="Customer name" width="180" sortable/>
                <el-table-column prop="phone" label="Phone number" width="180" sortable/>
                <el-table-column prop="sum" label="Total sum" sortable/>
                <el-table-column align="right">
                    <template #header>
                        <el-input v-model="search" size="small" placeholder="Type to search"/>
                    </template>
                    <template #default="scope">
                        <el-button size="small">Edit</el-button>
                        <el-button
                            size="small"
                            type="danger"
                        >Delete
                        </el-button
                        >
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import {ElTable, ElTableColumn, ElInput, ElButton} from "element-plus";

export default defineComponent({
    name: 'HomeView',
    components: {
        ElTable,
        ElTableColumn,
        ElInput,
        ElButton
    },
    data: () => ({
        search: '',
        sortableTableData: [{}],
        tableData: [
            {
                id: 1,
                phone: '89829972256',
                name: 'Петров Олег Иванович',
                sum: '1125',
            },
            {
                id: 2,
                phone: '89048356924',
                name: 'Измайлова Марина Александровна',
                sum: '5030',
            },
            {
                id: 3,
                phone: '89120062811',
                name: 'Миронов Альберт Вячеславович',
                sum: '2249',
            },
            {
                id: 4,
                phone: '89220992809',
                name: 'Антонова Ильмира Рашитовна',
                sum: '7836',
            },
        ]
    }),
    mounted() {
        this.sortableTableData = this.tableData;
    },
    watch: {
        search(value) {
            if(value !== '') {
                this.sortableTableData = this.tableData.filter((data) => {
                    return data.id === Number(value) ||
                           data.name.toLowerCase().includes(value.toLowerCase()) ||
                           data.phone.toLowerCase().includes(value.toLowerCase()) ||
                           data.sum.toLowerCase().includes(value.toLowerCase());
                });
                console.log(this.sortableTableData)
            } else {
                this.sortableTableData = this.tableData;
            }
        }
    }
});
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
