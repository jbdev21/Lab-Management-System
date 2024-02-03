<template>
    <div>
      <div class="mb-3">
        <label for="particular" class="form-label">Particular <span class="text-danger">*</span></label>
        <input type="text" name="particular" class="form-control">
      </div>
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
        <input type="number" step=".01" min="1" name="quantity" v-model.number="quantity" class="form-control">
      </div>
      <div class="mb-3">
        <label for="unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
        <input type="number" step=".01" min="1" name="unit_price" v-model.number="unit_price" class="form-control">
      </div>
      <div class="mb-3">
        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text" id="basic-addon1">&#x20B1;</span>
          <input type="number" step=".01" min="0" readonly :value="purchasePrice" name="amount" class="form-control">
        </div>
      </div>
      
      <div class="mb-3">
        <button class="btn btn-success text-white" type="submit"><i class="fa fa-plus"></i> Add Item</button>
      </div>
    </div>
</template>
  
  <script>
  export default {
    data() {
      return {
        quantity: 1,
        unit_price: 1,
      };
    },
    computed: {
      purchasePrice: function () {
        return this.quantity * this.unit_price;
      }
    }
  };
  </script>
  <style lang="scss">
  .raw-material-input{
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