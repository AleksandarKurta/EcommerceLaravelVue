<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdminOrIsAuthor()">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success float-right"  @click="newUserModal">Add New <i class="fa fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Created At</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td><span class="tag tag-success">{{ user.type | TextUppercase }}</span></td>
                      <td>{{ user.created_at | dateFilter }}</td>
                      <td>
                        <button class="btn btn-warning btn-sm" @click="editUserModal(user)">
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                      <td>
                          <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">
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

        <div v-else>
          <app-not-found></app-not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel" v-if="!editMode">Add New User</h5>
                    <h5 class="modal-title" id="addNewLabel" v-else>Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                  <form @submit.prevent="editMode ? editUser() : createUser()">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" name="name"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input v-model="form.email" type="email" name="email"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                      </div>
                      <div class="form-group">
                        <select name="type" class="form-control" v-model="form.type" id="type" :class="{ 'is-invalid': form.errors.has('type') }">
                          <option value="">Select User Role</option>
                          <option value="admin">Admin</option>
                          <option value="user">Standard User</option>
                          <option value="author">Author</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" v-model="form.bio" id="bio" cols="30" rows="5" placeholder="Short Bio for User" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                      </div>
                      <div class="form-group">
                        <label>Password</label>
                        <input v-model="form.password" type="password" name="password"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" v-if="!editMode">Create</button>
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
            editMode: false,
            users: {},
            form: new Form({
              id: '',
              name: '',
              email: '',
              password: '',
              type: '',
              bio: '',
              photo: ''
            })
          }
        },
        methods: {
          loadUsers(){
            if(this.$gate.isAdminOrIsAuthor()){
              axios.get('api/users')
              .then(({ data }) => (this.users = data.data))
            }
          },
          createUser() {
            this.$Progress.start()
            this.form.post('api/users')
              .then(() => {
                Fire.$emit('afterCreate');
                toast.fire({
                  type: 'success',
                  title: 'User created successfully'
                })
                this.$Progress.finish()
                $('#addNew').modal('hide')
              })
              .catch(() => {
                 this.$Progress.fail()
              });
          },
          deleteUser(id) {
            swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if(result.value){
                this.$Progress.start()
                this.form.delete('api/users/' + id)
                .then(() => {
                    swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                    this.$Progress.finish()
                    Fire.$emit('afterCreate');
                })
                .catch(() => {
                    swal.fire(
                      'Fail!',
                      'Error.',
                      'error'
                    )
                  this.$Progress.fail()
                })
              }
            })
          },
          newUserModal() {
            this.editMode = false;
            this.form.reset()
            $('#addNew').modal('show')
          },
          editUserModal(user) {
            this.editMode = true;
            this.form.clear()
            $('#addNew').modal('show')
            this.form.fill(user)
          },
          editUser() {
            this.$Progress.start()
            this.form.put('api/users/' + this.form.id)
              .then(() => {
                $('#addNew').modal('hide')
                toast.fire({
                  type: 'success',
                  title: 'User edited successfully'
                })
                this.$Progress.finish()
                Fire.$emit('afterCreate');
              })
              .catch(() => {
                this.$Progress.fail()
              })
          }
        },
        created() {
            this.loadUsers();
            Fire.$on('afterCreate', () => {
              this.loadUsers()
            });
        }
    }
</script>
