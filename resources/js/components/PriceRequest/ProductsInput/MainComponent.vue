<template>
    <div>
       <div class="product-input mb-4">
           Search Product
           <input type="text" v-model="searchKeyword" class="form-control" placeholder="Search for Product">
           <div class="options p-2 border shadow" v-if="productSearchResults.length">
               <small class="mb-2"><i>Showing {{ productSearchResults.length }} results</i></small>
               <div class="item p-2" v-for="product in productSearchResults" :key="product.id" @click="selectProduct(product)">
                   [{{ product.abbreviation }}] {{ product.description }}
               </div>
           </div>
       </div>
   
       <div class="mb-3">
           Selected Product
           <div class="border p-2" style="min-height: 100px;">
               <table>
                   <tr>
                       <td>Abbreviation</td>
                       <td>: <strong>{{ selectedProduct.abbreviation }}</strong></td>
                   </tr>
                   <tr>
                       <td>Brand Name</td>
                       <td>: <strong>{{ selectedProduct.brand_name }}</strong></td>
                   </tr>
                   <tr>
                       <td>Description</td>
                       <td>: <strong>{{ selectedProduct.description }}</strong></td>
                   </tr>
                   <tr>
                       <td>Price</td>
                       <td>: <strong>{{ selectedProduct.retail_price }}</strong></td>
                   </tr>
                   <tr>
                       <td>Type</td>
                       <td>: <strong>{{ selectedProduct.type }}</strong></td>
                   </tr>
               </table>
           </div>
       </div>
       <div class="mb-3" v-if="selectedProduct.recent_sales_order?.length">
           Top 5 Previous Pricing
           <table class="table">
               <thead>
                   <tr>
                       <td>Date</td>
                       <td>DR #</td>
                       <td>Price</td>
                       <td></td>
                   </tr>
               </thead>
               <tbody>
                   <tr v-for="recent_sales_order in selectedProduct.recent_sales_order" :key="recent_sales_order.id">
                       <td>{{ recent_sales_order.effectivity_date }}</td>
                       <td>{{ recent_sales_order.so_number }}</td>
                       <td>{{ recent_sales_order.amount }}</td>
                       <td class="text-end">
                           <button class="btn-sm btn-primary py-0 btn text-white px-2"><i class="fa fa-check"></i></button>
                       </td>
                   </tr>
               </tbody>
           </table>
       </div>  
       <input type="hidden" name="product_id" :value="selectedProduct.id">
       <div class="mb-3">
           <label for="unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
           <div class="input-group">
               <span class="input-group-text" id="basic-addon1">&#x20B1;</span>
               <input type="number" step=".01" min="0" readonly :value="selectedProduct.retail_price" name="unit_price" required class="form-control">
           </div>  
       </div>
   
       <div class="mb-3">
           <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
           <input type="number" step=".01" min="0" name="quantity" v-model="quantity" required class="form-control">
       </div>
       
       <div class="mb-3">
           <label for="discount" class="form-label">Discount <span class="text-danger">*</span></label>
           <div class="input-group">
               <span class="input-group-text" id="basic-addon1">&#x20B1;</span>
               <input type="number" step=".01" min="0" name="discount" v-model="discount" required class="form-control">
           </div>  
       </div>
       <div class="mb-3">
           <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
           <div class="input-group">
               <span class="input-group-text" id="basic-addon1">&#x20B1;</span>
               <input type="number" step=".01" min="0" readonly :value="finalPrice" name="amount" required class="form-control">
           </div>
       </div>
       <div class="mb-3">
           <button class="btn btn-success text-white" type="submit"><i class="fa fa-plus"></i> Add Item</button>
       </div>
    </div>
   </template>
   <script>
    export default {
       props: ['customerid', 'soid'],
       data(){
           return {
               productSearchResults : [],
               selectedProduct: {},
               searchKeyword: '',
               quantity: 1,
               discount: 0
           }
       },
       computed:{
           isProductSelected(){
               return Object.keys(this.selectedProduct).length > 0
           },
           finalPrice(){
               if(this.isProductSelected){
                   return (this.selectedProduct.retail_price * this.quantity) - this.discount
               }
               return 0.00
           }
       },
   
       watch:{
           searchKeyword(){
               if(this.searchKeyword.length > 2){
                   this.doSearchProduct()
               }
           }
       },
   
       methods:{
           selectProduct(product){
               this.productSearchResults = []
               this.searchKeyword = ''
               this.selectedProduct = product
           },
           doSearchProduct: _.debounce(function(){
               this.productSearchResults = []
               axios.post('/api/product/sales-order/details/search', {
                       keyword: this.searchKeyword,
                       customer_id: this.customerid,
                       sales_order_id: this.soid,
                   })
                   .then( response => {
                       this.productSearchResults = response.data
                   })
                   .catch( error => {
                       console.log(error)
                   })
           }, 500)
       }
    }
   </script>
   
   <style lang="scss">
       .product-input{
           position: relative;
   
           .options{
               z-index: 1;
               position: absolute;
               list-style: none;
               width: 100%;
               margin-top:5px;
               background-color: #fff;
   
               .item{
                   padding:0px;
                   width: 100%;
                   cursor: pointer;
                   border-radius: 5px;
   
                   &:hover{
                       background-color: rgba(187, 187, 187, 0.133);
                   }
               }
           }
       }
   </style>