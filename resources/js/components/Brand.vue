<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Brands Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success float-right" @click="createBrandModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Created At</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                    <tr v-for="brand in brands" :key="brand.id">
                      <td>{{ brand.id }}</td>
                      <td>{{ brand.name }}</td>
                      <td>{{ brand.created_at | dateFilter }}</td>
                      <td>
                        <button class="btn btn-warning btn-sm" @click="editBrandModal(brand)">
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                      <td>
                          <button class="btn btn-danger btn-sm" @click="deleteBrand(brand.id)">
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

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel" v-if="!editModal">Add New Brand</h5>
                    <h5 class="modal-title" id="addNewLabel" v-else>Edit Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  <form @submit.prevent="editModal ? editBrand() : createBrand()">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" name="name"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
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
            brands: {},
            form: new Form({
              id: '',
              name: '',
            })
          }
        },
        methods: {
          loadBrands(){
            axios.get('api/brands')
              .then(({ data }) => (this.brands = data.data))
          },
          createBrandModal(){
            this.editModal = false;
            this.form.reset()
            $('#addNew').modal('show')
          },
          createBrand() {
            this.$Progress.start()
            this.form.post('api/brands')
              .then(() => {
                Fire.$emit('loadBrandsData');
                toast.fire({
                  type: 'success',
                  title: 'Brand created successfully'
                })
                this.$Progress.finish()
                $('#addNew').modal('hide')
              })
              .catch(() => {
                 this.$Progress.fail()
              });
          },
          editBrandModal(brand) {
            this.editModal = true;
            this.form.clear()
            $('#addNew').modal('show')
            this.form.fill(brand)
          },
          editBrand() {
            this.$Progress.start()
            this.form.put('api/brands/' + this.form.id)
              .then(() => {
                Fire.$emit('loadBrandsData');
                 toast.fire({
                  type: 'success',
                  title: 'Brand edited successfully'
                })
                this.$Progress.finish()
                $('#addNew').modal('hide')
              })
              .catch(() => {
                this.$Progress.fail()
              })
          },
          deleteBrand(id) {
            swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            })
              .then((results) => {
                if(results.value){
                  this.$Progress.start()
                  this.form.delete('api/brands/' + id)
                    .then(() => {
                      swal.fire(
                      'Deleted!',
                      'Your brand has been deleted.',
                      'success'
                      )
                      this.$Progress.finish()
                      Fire.$emit('loadBrandsData');
                    })
                    .catch(() => {
                      this.$Progress.fail()
                    })
                }
              })
          }
        },
        created() {
            this.loadBrands();
            Fire.$on('loadBrandsData', () => {
              this.loadBrands()
            });
        }
    }
</script>
