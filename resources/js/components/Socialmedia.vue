<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.socialmedia']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.socialmedia']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.socialmedia']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.socialmedia']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.socialmedia']['icon'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['name'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['url'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['modify'] }}</th>
                            </tr>

                            <tr v-for="socialmedia,index in socialmedia.data" :key="socialmedia.id">
                                <td>{{ index+1 }}</td>
                                <!--<td>
                                    <img v-if="socialmedia.icon" :src="'/img/social/thumbs/' + socialmedia.icon" >
                                    <img v-else :src="'/img/nophoto.png'" >

                                </td>-->
                                <td>{{ socialmedia.icon }}</td>
                                <td>{{ socialmedia.name }}</td>
                                <td>{{ socialmedia.url }}</td>
                                <td>
                                    <span v-show="socialmedia.active==1" class="badge badge-success">{{ $trans[lang+'.socialmedia']['active'] }}</span>
                                    <span v-show="socialmedia.active==0" class="badge badge-danger">{{ $trans[lang+'.socialmedia']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(socialmedia.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(socialmedia.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(socialmedia)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteSocialmedia(socialmedia.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="socialmedia" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.socialmedia']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.socialmedia']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateSocialmedia() : createSocialmedia()">
                        <div class="modal-body">

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['uploadicon'] }}:</strong><br>
                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="iconcomplete"></vue-dropzone>
                                <input v-model="form.icon" id="icon" type="text" name="icon"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('icon') }">
                                <has-error :form="form" field="icon"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>İkon2:</strong><br>
                                <input v-model="form.icon2" id="icon2" type="text" name="icon2"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('icon2') }">
                                <has-error :form="form" field="icon2"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['socialmedia_name'] }}:</strong><br>
                                <input v-model="form.name" id="name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['socialmedia_url'] }}:</strong><br>
                                <input v-model="form.url" id="url" type="text" name="url"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('url') }">
                                <has-error :form="form" field="url"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['socialmedia_status'] }}:</strong><br>
                                <select v-model="form.active" id="type" name="active"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                    <option value="1">{{ $trans[lang+'.socialmedia']['active'] }}</option>
                                    <option value="0">{{ $trans[lang+'.socialmedia']['passive'] }}</option>
                                </select>
                                <has-error :form="form" field="active"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">{{ $trans[lang+'.socialmedia']['close'] }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.socialmedia']['update'] }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.socialmedia']['create'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";

    export default {
        data() {
            return {
                lang: this.$lang,

                imguploadconfig: {
                    url: "/api/socialmedia_image",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },

                editmode: false,
                socialmedia: {},
                form: new Form(
                    {
                        id: '',
                        icon: '',
                        icon2:'',
                        name: '',
                        url: '',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone
        },
        methods: {
            iconcomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("İcon:"+response.data);
                this.form.icon = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/socialmedia?page=' + page)
                    .then(response => {
                        this.socialmedia = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/socialmediaup",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Socialmedia order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },
            downrecords(id) {
                axios({
                    url: "/api/socialmediadown",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Socialmedia order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updateSocialmedia() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/socialmedia/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'Socialmedia has been updated',
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
            createSocialmedia() {
                this.$Progress.start();
                this.form.post('/api/socialmedia')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'socialmedia created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(socialmedia) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(socialmedia)
            },
            newModal() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deleteSocialmedia(id) {

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
                        this.form.delete('/api/socialmedia/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Socialmedia has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadSocialmedia() {
                axios.get('/api/socialmedia').then(({ data})=> (this.socialmedia=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findSocialmedia?q=' + query)
                    .then((data) => {
                        this.socialmedia = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadSocialmedia();
            Fire.$on('AfterCreate',() => {
                this.loadSocialmedia();
            })
        }
    }
</script>
