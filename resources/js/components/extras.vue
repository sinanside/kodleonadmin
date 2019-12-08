<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.main']['extras'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.main']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item "><a href="/mainpage">{{ $trans[lang+'.main']['home'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.extras']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.extras']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.socialmedia']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.extras']['picture'] }}</th>
                                <th>{{ $trans[lang+'.extras']['title1'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['modify'] }}</th>
                            </tr>

                            <tr v-for="extras,index in extras.data" :key="extras.id">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <img v-if="extras.picture" :src="'/img/mainpage/thumbs/' + extras.picture" >
                                    <img v-else :src="'/img/nophoto.png'" >
                                </td>
                                <td>{{ extras.title }}</td>
                                <td>
                                    <span v-show="extras.active==1" class="badge badge-success">{{ $trans[lang+'.socialmedia']['active'] }}</span>
                                    <span v-show="extras.active==0" class="badge badge-danger">{{ $trans[lang+'.socialmedia']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(extras.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(extras.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(extras)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteExtras(extras.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="extras" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.extras']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.extras']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateExtras() : createExtras()">
                        <div class="modal-body">

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.extras']['uploadpicture'] }}:</strong><br>
                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="picturecomplete"></vue-dropzone>
                                <input v-model="form.picture" id="picture" type="text" name="picture"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture') }">
                                <has-error :form="form" field="icon"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.extras']['title1'] }}:</strong><br>
                                <input v-model="form.title" id="name" type="text" name="title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.extras']['icon'] }}:</strong><br>
                                <input v-model="form.icon" id="icon" type="text" name="icon"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('icon') }">
                                <has-error :form="form" field="icon"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['short_description'] }}1:</strong><br>
                                <input v-model="form.short_content1" id="short_content1" type="text" name="icon"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('short_content1') }">
                                <has-error :form="form" field="short_content1"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['short_description'] }}2:</strong><br>
                                <input v-model="form.short_content2" id="short_content2" type="text" name="short_content2"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('short_content2') }">
                                <has-error :form="form" field="short_content2"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['short_description'] }}3:</strong><br>
                                <input v-model="form.short_content3" id="short_content3" type="text" name="short_content3"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('short_content3') }">
                                <has-error :form="form" field="short_content3"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.extras']['description'] }}:</strong><br>
                                <input v-model="form.description" id="description" type="text" name="description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
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
                    url: "/api/extras_image",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },

                editmode: false,
                extras: {},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        picture: '',
                        icon: '',
                        short_content1: '',
                        short_content2: '',
                        short_content3: '',
                        description: '',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone
        },
        methods: {
            picturecomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Resim:"+response.data);
                this.form.picture = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/extras?page=' + page)
                    .then(response => {
                        this.extras = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/extrasup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Extras order updated',
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
                    url: "/api/extrasdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Extras order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updateExtras() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/extras/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        swal.fire(
                            'Updated!',
                            'Extras has been updated',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        swal.fire("Failed","There was an error","warning");

                    });
            },
            createExtras() {
                this.$Progress.start();
                this.form.post('/api/extras')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'extras created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(extras) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(extras)
            },
            newModal() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deleteExtras(id) {

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
                        this.form.delete('/api/extras/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Extras has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadExtras() {
                axios.get('/api/extras').then(({ data})=> (this.extras=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findextras?q=' + query)
                    .then((data) => {
                        this.extras = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadExtras();
            Fire.$on('AfterCreate',() => {
                this.loadExtras();
            })
        }
    }
</script>