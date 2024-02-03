<template>
    <div>
      <div class="delivery-receipt-input mb-4">
        Search Delivery Receipt
        <input type="text" v-model="searchKeyword" class="form-control" placeholder="Search for Delivery Receipt Number">
        <input type="text" v-model="selectedDeliveryReceiptId" name="delivery_receipt_id" required hidden>
        <div class="options p-2 border shadow" v-if="deliveryReceiptResults.length > 0">
          <small class="mb-2"><i>Showing {{ deliveryReceiptResults.length }} results</i></small>
          <div class="item p-2" v-for="deliveryReceipt in deliveryReceiptResults" :key="deliveryReceipt.id" @click="selectDeliveryReceipt(deliveryReceipt)">
            DR# {{ deliveryReceipt.dr_number }}
          </div>
        </div>
      </div>
  
      <div class="mb-3" v-if="selectedDeliveryReceipt">
        Selected Delivery Receipt
        <div class="border p-2" style="min-height: 100px;">
            <table>
                <tr>
                    <td>DR#</td>
                    <td>: <strong>{{ selectedDeliveryReceipt.dr_number }}</strong></td>
                </tr>
                <tr>
                    <td>Effectivity Date</td>
                    <td>: <strong>{{ selectedDeliveryReceipt.salesOrder.effectivity_date }}</strong></td>
                </tr>
                <tr>
                    <td>Due Date</td>
                    <td>: <strong>{{ selectedDeliveryReceipt.salesOrder.due_date }}</strong></td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>: <strong>{{ toPeso(selectedDeliveryReceipt.amount) }}</strong></td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>: <strong>{{ selectedDeliveryReceipt.salesOrder.discount }}</strong></td>
                </tr>
                <tr>
                    <td>Outstanding Balance</td>
                    <td>: <strong>{{ toPeso(selectedDeliveryReceipt.balance) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

  
    <div class="mb-3" v-if="selectedDeliveryReceipt">
        <div v-if="modeOfPaymentPDC" class="pt-3">
            <CheckInput @updated="updateAmount"/>
        </div>
        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">&#x20B1;</span>
            <input type="number" step=".05" :min="1" v-model="amount" name="amount" :max="selectedDeliveryReceipt.balance" class="form-control" @input="updateAmount" required>
        </div>
        <label class="form-label mt-2"><small class="text-danger">**Over/Short Payment</small></label>
        <div class="input-group">
            <input :class="{ 'text-danger': amountDifference !== 0 }" type="text" class="form-control" :value="formattedAmountDifference" readonly>
        </div>
        
    </div>

    <div class="mb-3">
          <button class="btn btn-success text-white overlayed-form" :disabled="invalid" type="submit"><i class="fa fa-credit-card"></i> Add Payment</button>
      </div>
    </div>
  </template>
  
  <script>
  import CheckInput from "./CheckInput/MainComponent.vue"
  export default {
    components: {
      CheckInput
    },
    data() {
        return {
            searchKeyword: '',
            deliveryReceiptResults: [],
            selectedDeliveryReceiptId: null,
            selectedDeliveryReceipt: null,
            customerId: null,
            amount: 1,
            modePaymentPDC: null,
            bank: '', 
            checkNumber: '', 
            checkDate: '', 
        };
    },
    computed: {
        amountDifference() 
        {
            if (this.selectedDeliveryReceipt) {
                const amount = parseFloat(this.amount);
                const balance = parseFloat(this.selectedDeliveryReceipt.balance);

                if (!isNaN(amount) && !isNaN(balance)) {
                    return balance - amount;
                }
            }
            return 0;
        },
        invalid(){
          if (this.selectedDeliveryReceipt?.balance > 0){
            return false
          }
          return true;
        },
        formattedAmountDifference() 
        {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
            }).format(this.amountDifference);
        },
        modeOfPaymentPDC() {
            return this.modePaymentPDC === 'PDC';
        },
    },
    mounted() {
        const customerElement = document.getElementById('customer');
        if (customerElement) {
            this.customerId = customerElement.getAttribute('data-customer-id');
        }

        this.modePaymentPDC = document.getElementById('mode_payment').getAttribute('data-mode-payment-id');
    },
    watch: {
      searchKeyword() {
        if (this.searchKeyword.length > 1) {
          this.doSearchDeliveryReceipt();
        }
      },
    },
    methods: {
      updateAmount(amount){
          // console.log(amount)
          this.amount = amount
      },
      selectDeliveryReceipt(deliveryReceipt) {
        this.deliveryReceiptResults = [];
        this.searchKeyword = '';
        this.selectedDeliveryReceiptId = deliveryReceipt.id;
        this.selectedDeliveryReceipt = deliveryReceipt;
        this.amount = deliveryReceipt.balance
      },
      doSearchDeliveryReceipt() {
        axios.post('/api/delivery-receipts/detail-search', {
          keyword: this.searchKeyword,
          customer_id: this.customerId,
        })
        .then(response => {
          this.deliveryReceiptResults = response.data;
        })
        .catch(error => {
          console.log(error);
        });
      },
      toPeso(number){
            let peso = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
            });

            return peso.format(number)
        },
    },
  };
  </script>
  
  <style lang="scss">
    .delivery-receipt-input {
        position: relative;
    
        .options {
        z-index: 1;
        position: absolute;
        list-style: none;
        width: 100%;
        margin-top: 5px;
        background-color: #fff;
    
        .item {
            padding: 0px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
    
            &:hover {
            background-color: rgba(187, 187, 187, 0.133);
            }
        }
        }
    }
  </style>
  