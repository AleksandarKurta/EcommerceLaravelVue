<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Brands Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success float-right" @click="createCategoryModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
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
                    <tr v-for="category in categories.data" :key="category.id">
                      <td>{{ category.id }}</td>
                      <td>{{ category.name }}</td>
                      <td>{{ category.created_at }}</td>
                      <td>
                        <button class="btn btn-warning btn-sm" @click="editCategoryModal(category)">
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                      <td>
                          <button class="btn btn-danger btn-sm" @click="deleteCategory(category.id)">
                             <i class="fa fa-trash"></i>
                          </button>
                      </td>
                    </tr>
                  </tbody></table>
                </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="categories" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

         <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel" v-if="!editModal">Add New Category</h5>
                    <h5 class="modal-title" id="addNewLabel" v-else>Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  <form @submit.prevent="editModal ? editCategory() : createCategory() ">
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
            categories: {},
            form: new Form({
              id: '',
              name: ''
            })
          }
        },
        methods: {
           getResults(page = 1) {
            axios.get('api/categories?page=' + page)
              .then(response => {
                this.categories = response.data;
              });
          },
          loadCategories() {
            axios.get('api/categories')
              .then(({data}) => this.categories = data)
          },
          createCategoryModal() {
            this.editModal = false;
            this.form.reset();
            $('#addNew').modal('show')
          },
          createCategory() {
            this.$Progress.start()
            this.form.post('api/categories')
              .then(() => {
                Fire.$emit('loadCategoriesData');
                  toast.fire({
                  type: 'success',
                  title: 'Category created successfully'
                })
                this.$Progress.finish()
                $('#addNew').modal('hide')
              })
              .catch(() => {
                this.$Progress.fail()
              })
          },
          editCategoryModal(category) {
            this.editModal = true;
            this.form.clear()
            $('#addNew').modal('show')
            this.form.fill(category);
          },
          editCategory() {
            this.$Progress.start()
            this.form.put('api/categories/' + this.form.id)
              .then(() => {
                Fire.$emit('loadCategoriesData');
                  toast.fire({
                  type: 'success',
                  title: 'Category edited successfully'
                })
                this.$Progress.finish()
                $('#addNew').modal('hide')
              })
              .catch(() => {
                this.$Progress.fail()
              })
          },
          deleteCategory(id){
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
                  this.form.delete('api/categories/' + id)
                    .then(() => {
                      swal.fire(
                      'Deleted!',
                      'Your brand has been deleted.',
                      'success'
                      )
                      this.$Progress.finish()
                      Fire.$emit('loadCategoriesData');
                    })
                    .catch(() => {
                      this.$Progress.fail()
                    })
                }
              })
          }
        },
        created() {
          this.loadCategories();
          Fire.$on('loadCategoriesData', () => {
             this.loadCategories();
          });
        }
    }
</script>
