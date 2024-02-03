<template>
    <div>
      <div class="raw-material-input mb-4">
        Search Raw Material
        <input type="text" v-model="searchKeyword" class="form-control" placeholder="Search for Raw Material">
        <input type="text" v-model="selectedRawMaterial.id" name="raw_material_id" hidden>
        <div class="options p-2 border shadow" v-if="rawMaterialSearchResults.length">
          <small class="mb-2"><i>Showing {{ rawMaterialSearchResults.length }} results</i></small>
          <div class="item p-2" v-for="rawMaterial in rawMaterialSearchResults" :key="rawMaterial.id" @click="selectRawMaterial(rawMaterial)">
            [{{ rawMaterial.code }}] {{ rawMaterial.name }}
          </div>
        </div>
      </div>
  
      <div class="mb-3">
        Selected Raw Material
        <div class="border p-2" style="min-height: 100px;">
          <table>
            <tr>
              <td>Code</td>
              <td>: <strong>{{ selectedRawMaterial.code }}</strong></td>
            </tr>
            <tr>
              <td>Name</td>
              <td>: <strong>{{ selectedRawMaterial.name }}</strong></td>
            </tr>
            <tr>
              <td>Unit</td>
              <td>: <strong>{{ selectedRawMaterial.unit }}</strong></td>
            </tr>
          </table>
        </div>
      </div>
      
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
        <input type="number" step=".01" min="1" name="quantity" v-model="quantity" required class="form-control">
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
        rawMaterialSearchResults: [],
        selectedRawMaterial: {},
        searchKeyword: '',
        quantity: 1,
      };
    },
    computed: {
      isRawMaterialSelected() {
        return Object.keys(this.selectedRawMaterial).length > 0;
      },
    },
    methods: {
      selectRawMaterial(rawMaterial) {
        this.rawMaterialSearchResults = [];
        this.searchKeyword = '';
        this.selectedRawMaterial = rawMaterial;
      },
      doSearchRawMaterial: _.debounce(function () {
        this.rawMaterialSearchResults = [];
        axios
          .post('/api/raw-material/search', {
            keyword: this.searchKeyword,
          })
          .then((response) => {
            this.rawMaterialSearchResults = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }, 500),
    },
    watch: {
      searchKeyword() {
        if (this.searchKeyword.length > 2) {
          this.doSearchRawMaterial();
        }
      },
    },
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