<template>
  <div>
    <h3>Create new order</h3>

      <div class="custom-form-container">
          <el-form class="custom-form" ref="formRef" :model="form">
              <el-form-item label="Name" prop="name" :rules="[{ required: true, message: 'name is required' }]">
                  <el-input class="custom-input" v-model="form.name"  placeholder="Иванов Иван" required />
              </el-form-item>
              <el-form-item label="Phone" prop="phone" :rules="[{ required: true, message: 'Phone is required' }]">
                  <el-input class="custom-input" v-model="form.phone" placeholder="79820000000" required />
              </el-form-item>
              <el-form-item label="Sum" prop="sum" :rules="[{ required: true, message: 'Sum is required' }]">
                  <el-input class="custom-input" v-model="form.sum"   placeholder="1000" required />
              </el-form-item>
              <el-button submit @click="createOrder">Save</el-button>
          </el-form>
      </div>
  </div>
</template>

<script>
import {ElForm, ElInput, ElButton, ElFormItem} from 'element-plus';

export default {
    components: {
        ElForm,
        ElInput,
        ElButton,
        ElFormItem
    },
    data: () => ({
        form: {
            name: '',
            phone: '',
            sum: ''
        }
    }),
    methods: {
        async createOrder() {
            const form = this.$refs.formRef

            form.validate(async (valid) => {
                if (!valid) {
                    return false;
                }

                const response = await this.$axios.post('orders', this.form);

                if (response.status === 201) {
                    this.$router.push('/');
                }
            })
        }
    }
}
</script>

<style>
.custom-form-container{
    padding-left: 40%;
    padding-right: 40%;
}

.custom-form {
    padding: 10px;
    border-radius: 10px;
    box-shadow: 10px 10px 20px darkgrey;
}

.custom-input {

}
</style>
