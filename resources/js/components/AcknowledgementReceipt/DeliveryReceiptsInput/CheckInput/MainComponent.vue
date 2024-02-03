<template>
    <div>
        <a href="#" class="pull-right" @click="theModal.show()"><i class="fa fa-plus"></i> Add Check</a>
        Post Dated Checks
        <table class="table">
            <thead>
                <tr>
                    <th>Check Number</th>
                    <th>Bank</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(check, index) in checks" :key="index">
                    <td>
                        {{ check.checkNumber }}
                        <input type="hidden" name="check_number[]" :value="check.checkNumber">
                        <input type="hidden" name="bank[]" :value="check.bank">
                        <input type="hidden" name="check_date[]" :value="check.checkDate">
                        <input type="hidden" name="check_amount[]" :value="check.amount">
                    </td>
                    <td>{{ check.bank }}</td>
                    <td>{{ toPeso(check.amount) }}</td>
                    <td class="text-end"><button class="btn btn-sm btn-danger py-0 px-2" @click.prevent="checks.splice(index, 1)" ><i class="fa fa-remove"></i></button></td>
                </tr>
                <tr v-if="checks.length < 1">
                    <td colspan="4" class="text-center">No check yet</td>
                </tr>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="checkModalForm" tabindex="-1" aria-labelledby="checkModalFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Check</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="addCheck">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="bank" class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="text" v-model="amount" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="bank" class="form-label">Bank <span class="text-danger">*</span></label>
                                <input type="text" v-model="bank" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="number" class="form-label">Check Number <span class="text-danger">*</span></label>
                                <input type="text" v-model="checkNumber" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="check_date" class="form-label">Check Date <span class="text-danger">*</span></label>
                                <input type="date" v-model="checkDate" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Check</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
export default {
    data(){
        return {
            checks: [],

            bank: '',
            checkNumber: '',
            checkDate: '',
            amount: '',

            theModal: null
        }
    },
    mounted() {
        this.theModal = new Modal(document.getElementById('checkModalForm'));
    },
    computed:{
        totalAmount(){
            var total = 0
            this.checks.forEach((e) => {
                total += parseFloat(e.amount)
            })
            
            return total;
        }
    },
    watch:{
        totalAmount(){
            this.$emit("updated", this.totalAmount)
        }
    },
    methods: {
        addCheck(){
            this.checks.push({
                bank: this.bank,
                checkNumber: this.checkNumber,
                checkDate: this.checkDate,
                amount: this.amount,
            })

            this.bank = ''
            this.checkNumber = ''
            this.checkDate = ''
            this.amount = ''

            this.theModal.hide()
        },

        toPeso(number){
            let peso = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
            });

            return peso.format(number)
        },
        

    }
}
</script>

<style>

</style>