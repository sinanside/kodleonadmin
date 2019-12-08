<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.users']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $trans[lang+'.pages']['management'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.users']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">
            <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">{{ $trans[lang+'.users']['title'] }}</h3>

                <div class="card-tools">
                    <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.users']['addnew'] }} <i class="fas fa-user-plus fa-fw"></i></button>
                </div>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody><tr>
                        <th>#</th>
                        <th>{{ $trans[lang+'.users']['username'] }}</th>
                        <th>{{ $trans[lang+'.users']['email'] }}</th>
                        <th>{{ $trans[lang+'.users']['type'] }}</th>
                        <th>{{ $trans[lang+'.users']['registeredat'] }}</th>
                        <th>{{ $trans[lang+'.users']['modify'] }}</th>
                    </tr>

                    <tr v-for="user,index in users.data" :key="user.id">
                        <td>{{ index+1 }}</td>
                        <td>{{ user.username | upText }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <span class="badge badge-primary" v-if="user.type === 'admin'">{{ user.type | upText }}</span>
                            <span class="badge badge-success" v-else-if="user.type === 'author'">{{ user.type | upText }}</span>
                            <span class="badge badge-warning" v-else>{{ user.type | upText }}</span>
                        </td>
                        <td>{{ user.created_at | myDate }}</td>
                        <td>
                            <a href="#" @click="editModal(user)"><i class="fa fa-edit blue"></i></a> /
                            <a href="#" @click="deleteUser(user.id)"><i class="fa fa-trash red"></i></a>
                        </td>
                    </tr>
                    </tbody></table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
        </div>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.users']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.users']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <strong>{{ $trans[lang+'.users']['name'] }}</strong>
                            <input v-model="form.name" id="name" type="text" name="name"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <strong>{{ $trans[lang+'.users']['username'] }}</strong>
                            <input v-model="form.username" id="username" type="text" name="username"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                            <has-error :form="form" field="username"></has-error>
                        </div>

                        <div class="form-group">
                            <strong>{{ $trans[lang+'.users']['email'] }}</strong>
                            <input v-model="form.email" id="email" type="email" name="email"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <strong>{{ $trans[lang+'.users']['bio'] }}</strong>
                            <vue-editor :editorOptions="editorSettings"
                                        useCustomImageHandler
                                        @imageAdded="handleImageAdded"
                                        id="users_editor1"
                                        v-model="form.bio">
                            </vue-editor>
                        </div>

                        <div class="form-group">
                            <select v-model="form.type" id="type" name="type"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">{{ $trans[lang+'.users']['userrole'] }}</option>
                                <option value="admin">{{ $trans[lang+'.users']['admin'] }}</option>
                                <option value="author">{{ $trans[lang+'.users']['author'] }}</option>
                                <option value="user">{{ $trans[lang+'.users']['user'] }}</option>
                            </select>
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <input v-model="form.password" id="password" type="password" name="password" placeholder="Password"
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">{{ $trans[lang+'.users']['close'] }}</button>
                        <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.users']['update'] }}</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.users']['create'] }}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { VueEditor, Quill } from "vue2-editor";
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module";
    import axios from "axios";

    Quill.register("modules/imageDrop", ImageDrop);
    Quill.register("modules/imageResize", ImageResize);

    export default {
        components: {
            VueEditor
        },
        data() {
            return {
                lang: this.$lang,

                //vue2-editor config begins
                editorSettings: {
                    modules: {
                        imageDrop: true,
                        imageResize: {
                            modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
                        }
                    }
                },

                //vue2-editor config ends

                editmode: false,
                users: {},
                form: new Form(
                    {
                      id: '',
                      name: '',
                      username: '',
                      email: '',
                      password: '',
                      type: 'user',
                      bio: '',
                      photo: '',
                      remember: false
                    }
                )
            }
        },
        methods: {
            // VUE2 EDITOR IMAGE UPLOAD PLUGİN BEGINS

            handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
                // An example of using FormData
                // NOTE: Your key could be different such as:
                // formData.append('file', file)

                var formData = new FormData();
                formData.append("file", file);

                axios({
                    url: "/api/profile_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/profile/thumbs/"+result.data.data; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                        console.log("Picture:"+url);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            // VUE2 EDITOR IMAGE UPLOAD PLUGİN ENDS
            getResults(page = 1) {
                axios.get('/api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            updateUser() {
                this.$Progress.start();
               //console.log('editing data');
                this.form.put('/api/user/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'User info has been updated',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        toast.fire("Failed","There was an error","warning");

                    });
            },
            editModal(user) {
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(user)
            },
            newModal() {
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
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

                    if(result.value) {
                    // send ajax request
                    this.form.delete('/api/user/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                    }).catch(()=>{

                        swal.fire("Failed","There was an error","warning");
                    });
                    }
                })

            },
            loadUsers() {
                if(this.$gate.isAdmin()) {
                axios.get('/api/user').then(({ data})=> (this.users=data));
                }
            },
            createUser() {
                this.$Progress.start();
                this.form.post('/api/user')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'User registered in successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findUser?q=' + query)
                    .then((data) => {
                        this.users = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadUsers();
            Fire.$on('AfterCreate',() => {
                this.loadUsers();
            })
        }
    }
</script>