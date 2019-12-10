<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Hizmetler</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">Hizmetler</a></li>
                            <li class="breadcrumb-item active">Hizmet Listesi</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Hizmetler</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                        <div class="card-tools px-1">
                            <select v-model="form.language2" @change="loadhizmettursbylang(form.language2)" class="form-control" id="language2">
                                <option value="0">Dil Seç</option>
                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                    {{ localization.title }}
                                </option>
                            </select>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.blog']['title1'] }}</th>
                                <th>{{ $trans[lang+'.blog']['slug'] }}</th>
                                <th>Dil</th>
                                <th>{{ $trans[lang+'.blog']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="hizmetturs, index in hizmetturs.data" :key="hizmetturs.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ hizmetturs.title }}</td>
                                <td>{{ hizmetturs.slug }}</td>
                                <td>{{ hizmetturs.localization.title }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="hizmetturs.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(hizmetturs.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(hizmetturs.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(hizmetturs)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteHizmettur(hizmetturs.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-success">
                        <pagination :data="hizmetturs" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">Hizmet Güncelle</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">Yeni Hizmet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateHizmettur() : createHizmettur()">
                        <div class="modal-body">

                            <div class="form-group">
                                <strong>Dil</strong><br>

                                    <select v-model="form.language" class="form-control" id="language" :class="{ 'is-invalid': form.errors.has('language') }">
                                        <option value="0">Dil Seç</option>
                                        <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                            {{ localization.title }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="language"></has-error>

                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.blog']['title1'] }}:</strong><br>
                                <input v-model="form.title" id="title" type="text" name="title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.blog']['short_description'] }}:</strong><br>
                                <input v-model="form.short_description" id="short_description" type="text" name="short_description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('short_description') }">
                                <has-error :form="form" field="short_description"></has-error>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="photocomplete"></vue-dropzone>
                                        <input v-model="form.photo" id="photo" type="text" name="photo"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
                                        <has-error :form="form" field="photo"></has-error>
                                        <input type="text" v-model="form.photo_alt" class="form-control" id="photo_alt"  :class="{ 'is-invalid': form.errors.has('photo_alt') }">
                                        <has-error :form="form" field="photo_alt"></has-error>
                                    </div>
                                    <div class="col-6">
                                        <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                        <img v-if="form.photo" :src="'\/img\/hizmetler\/thumbs\/'+form.photo">
                                        <img v-else :src="'\/img\/nophoto.png'">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.blog']['status'] }}:</strong><br>
                                        <select v-model="form.active" id="type" name="active"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                            <option value="1">{{ $trans[lang+'.blog']['active'] }}</option>
                                            <option value="0">{{ $trans[lang+'.blog']['passive'] }}</option>
                                        </select>
                                        <has-error :form="form" field="active"></has-error>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">{{ $trans[lang+'.blog']['close'] }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.blog']['update'] }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.blog']['create'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";
    import axios from "axios";

    export default {
        data() {
            return {
                lang: this.$lang,

                imguploadconfig: {
                    url: "/api/hizmettur_image",
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
                hizmetturs: {},
                localizations:{},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        slug: '',
                        short_description: '',
                        photo: '',
                        photo_alt: '',
                        language:'',
                        language2:'0',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone
        },
        methods: {

            photocomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo:"+response.data);
                this.form.photo = response.data;
            },

            uprecords(id) {
                axios({
                    url: "/api/hizmetturup",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Hizmettur order updated',
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
                    url: "/api/hizmetturdown",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Post order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            getResults(page = 1) {
                axios.get('/api/hizmetturs?page=' + page)
                    .then(response => {
                        this.hizmetturs = response.data;
                    });
            },
            updateHizmettur() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/hizmetturs/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'Hizmettur has been updated',
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
            createHizmettur() {
                this.$Progress.start();
                this.form.post('/api/hizmetturs')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Hizmettur created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(hizmetturs) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(hizmetturs)
            },
            newModal() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = false;
                this.form.reset();﻿
                this.form.language = 0;
                $('#addNew').modal('show');
            },
            deleteHizmettur(id) {

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
                        this.form.delete('/api/hizmetturs/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Hizmettur has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadHizmettur() {
                axios.get('/api/hizmetturs').then(({ data})=> (this.hizmetturs=data));
            },
            loadhizmettursbylang(id) {
                axios.get('/api/hizmettursbylang/'+id).then(({ data})=> (this.hizmetturs=data));
            },
            loadLocalization() {
                axios.get('/api/localizations').then(({ data})=> (this.localizations=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findHizmettur?q=' + query)
                    .then((data) => {
                        this.hizmetturs = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadHizmettur();
            this.loadLocalization();
            Fire.$on('AfterCreate',() => {
                this.loadHizmettur();
            })
        }
    }
</script>
