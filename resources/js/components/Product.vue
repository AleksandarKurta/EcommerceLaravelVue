<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success float-right" @click="createProductModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Brand</th>
                      <th>Price</th>
                      <th>Created At</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                    <tr v-for="product in products.data" :key="product.id">
                      <td>{{ product.id }}</td>
                      <td>{{ product.name }}</td>
                      <td>{{ product.brand.name }}</td>
                      <th>{{ product.price }}</th>
                      <th>{{ product.created_at | dateFilter }}</th>
                      <td></td>
                      <td>
                        <button class="btn btn-warning btn-sm" @click="editProductModal(product)">
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                      <td>
                          <button class="btn btn-danger btn-sm" @click="deleteProduct(product.id)">
                             <i class="fa fa-trash"></i>
                          </button>
                      </td>
                    </tr>
                  </tbody></table>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel" v-if="!editModal">Add New Product</h5>
                    <h5 class="modal-title" id="addNewLabel" v-else>Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  <form @submit.prevent="editModal ? editProduct() : createProduct()">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" name="name"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="brand">Select Brand</label>
                        <select name="brand" class="form-control" v-model="form.brand_id" id="type" :class="{ 'is-invalid': form.errors.has('brand') }">
                          <option v-for="brand in brands" v-bind:value="brand.id">{{ brand.name }}</option>
                        </select>
                      </div>
                      <div class="form-group">
                      <label for="category">Select Categories</label><br>
  
                        <div v-for="category in allCategories">
                          <label>
                              <input
                                      type="checkbox"
                                      :value="category.id"                                   
                                      v-model="form.categories"
                                      > {{ category.name }}
                                      <span></span>
                          </label>
                        </div>
                     
                      </div>
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input v-model="form.price" type="number" name="price"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                        <has-error :form="form" field="price"></has-error>
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" v-model="form.description" id="description" cols="30" rows="5" placeholder="Short Description for User" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                        <has-error :form="form" field="description"></has-error>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" v-if="!editModal">Create</button>
                        <button type="submit" class="btn btn-success" v-else>Update</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editModal: false,
                products: {},
                brands: {},
                allCategories: {},
                form: new Form({
                    id: '',
                    name: '',
                    brand_id: '',
                    categories: [],
                    price: '',
                    description: '',
                    created_at: ''
                })
            }
        },
        methods: {
            loadProducts() {
              axios.get('api/products')
                .then((data) => (this.products = data))
            },
            loadBrands(){
              axios.get('api/brands')
                .then(({data}) => (this.brands = data.data))
            },
            loadCategories(){
              axios.get('api/categories')
                .then(({data}) => (this.allCategories = data.data))
            },
            createProductModal() {
              this.editModal = false;
              this.form.reset()
              $('#addNew').modal('show')
            },
            createProduct() {
              this.$Progress.start()
              axios.post('api/products', this.form)
                .then(() => {
                    Fire.$emit('loadProductsData');
                    toast.fire({
                      type: 'success',
                      title: 'Product created successfully'
                    })
                    this.$Progress.finish()
                    $('#addNew').modal('hide')
                })
                .catch(() => {
                  this.$Progress.fail()
                })
            },
            editProductModal(product) {
              this.editModal = true;
              this.form.clear()
              $('#addNew').modal('show')
              this.form.fill(product) 
              this.form.categories = [];        
              for(let pro of product.categories){
                this.form.categories.push(pro.id);
              }
            },
            editProduct() {
              this.$Progress.start()
              this.form.put('api/products/' + this.form.id)
                .then(() => {
                  Fire.$emit('loadProductsData');
                  toast.fire({
                    type: 'success',
                    title: 'User edited successfully'
                  })
                  this.$Progress.finish()
                  $('#addNew').modal('hide')
                })
                .catch(() => {
                  this.$Progress.fail()
                })
            },
            deleteProduct(id){
              swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              })
                .then((result) => {
                  if(result.value){
                    this.$Progress.start()
                    this.form.delete('api/products/' + id)
                    .then(() => {
                      swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                      this.$Progress.finish()
                      Fire.$emit('loadProductsData');
                    })
                    .catch(() => {
                      this.$Progress.fail()
                      swal("Failed", "There was something wrong", "warning")
                    })
                  }
                })
            }
        },
        created() {
            this.loadProducts();
            this.loadBrands();
            this.loadCategories();
            Fire.$on('loadProductsData', () => {
              this.loadProducts();
              this.loadBrands();
              this.loadCategories();
            })
        }
    }
</script>