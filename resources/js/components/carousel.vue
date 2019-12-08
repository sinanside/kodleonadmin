<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.carousel']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.carousel']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.carousel']['title'] }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.carousel']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.carousel']['image'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['title1'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['modify'] }}</th>
                            </tr>

                            <tr v-for="carousel,index in carousel.data" :key="carousel.id">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <img v-if="carousel.image" :src="'/img/carousel/thumbs/' + carousel.image" >
                                    <img v-else :src="'/img/nophoto.png'" >

                                </td>
                                <td>{{ carousel.carousel_title }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="carousel.active">{{ $trans[lang+'.carousel']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.carousel']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(carousel)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletecarousel(carousel.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="carousel" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">Update Carousel Info</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">Add Carousel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updatecarousel() : createcarousel()">
                        <div class="modal-body">

                            <div class="form-group">
                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="carouselimagecomplete"></vue-dropzone>
                                <input v-model="form.image" id="image" type="text" name="image"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                <has-error :form="form" field="image"></has-error>
                                <input v-model="form.image_alt" id="image_alt" type="text" name="image_alt" placeholder="Image alt information"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('image_alt') }">
                                <has-error :form="form" field="image_alt"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>Carousel Title:</strong><br>
                                <input v-model="form.carousel_title" id="name" type="text" name="carousel_title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('carousel_title') }">
                                <has-error :form="form" field="carousel_title"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>Top text:</strong><br>
                                <input v-model="form.top_text" id="top_text" type="text" name="top_text"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_text') }">
                                <has-error :form="form" field="top_text"></has-error>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <strong>Top Url:</strong><br>
                                        <input v-model="form.top_url" id="top_url" type="text" name="top_url"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('top_url') }">
                                        <has-error :form="form" field="top_url"></has-error>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Size:</strong><br>
                                        <input v-model="form.top_fontsize" id="top_fontsize" type="text" name="top_fontsize"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontsize') }">
                                        <has-error :form="form" field="top_fontsize"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>X:</strong><br>
                                        <input v-model="form.top_x" id="top_x" type="text" name="top_x"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('top_x') }">
                                        <has-error :form="form" field="top_x"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Y:</strong><br>
                                        <input v-model="form.top_y" id="top_y" type="text" name="top_y"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('top_y') }">
                                        <has-error :form="form" field="top_y"></has-error>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Middle text:</strong><br>
                                <input v-model="form.middle_text" id="middle_text" type="text" name="middle_text"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_text') }">
                                <has-error :form="form" field="middle_text"></has-error>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <strong>Middle Url:</strong><br>
                                        <input v-model="form.middle_url" id="middle_url" type="text" name="middle_url"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('middle_url') }">
                                        <has-error :form="form" field="middle_url"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Size:</strong><br>
                                        <input v-model="form.middle_fontsize" id="middle_fontsize" type="text" name="middle_fontsize"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize') }">
                                        <has-error :form="form" field="middle_fontsize"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>X:</strong><br>
                                        <input v-model="form.middle_x" id="middle_x" type="text" name="middle_x"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('middle_x') }">
                                        <has-error :form="form" field="middle_x"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Y:</strong><br>
                                        <input v-model="form.middle_y" id="middle_y" type="text" name="middle_y"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('middle_y') }">
                                        <has-error :form="form" field="middle_y"></has-error>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>Bottom text:</strong><br>
                                <input v-model="form.bottom_text" id="bottom_text" type="text" name="bottom_text"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_text') }">
                                <has-error :form="form" field="bottom_text"></has-error>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <strong>Bottom Url:</strong><br>
                                        <input v-model="form.bottom_url" id="bottom_url" type="text" name="bottom_url"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_url') }">
                                        <has-error :form="form" field="bottom_url"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Size:</strong><br>
                                        <input v-model="form.bottom_fontsize" id="bottom_fontsize" type="text" name="bottom_fontsize"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontsize') }">
                                        <has-error :form="form" field="bottom_fontsize"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>X:</strong><br>
                                        <input v-model="form.bottom_x" id="bottom_x" type="text" name="bottom_x"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_x') }">
                                        <has-error :form="form" field="bottom_x"></has-error>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <strong>Y:</strong><br>
                                        <input v-model="form.bottom_y" id="bottom_y" type="text" name="bottom_y"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_y') }">
                                        <has-error :form="form" field="bottom_y"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <select v-model="form.active" id="type" name="active"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                    <option value="1">Active</option>
                                    <option value="0">Passive</option>
                                </select>
                                <has-error :form="form" field="active"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
                    url: "/api/carousel_image",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD CAROUSEL IMAGE",
                    addRemoveLinks: true
                },

                editmode: false,
                carousel: {},
                form: new Form(
                    {
                        id: '',
                        carousel_title: '',
                        image: '',
                        image_alt: '',
                        top_text: '',
                        top_url: '',
                        top_fontsize: '',
                        top_x: '',
                        top_y: '',
                        middle_text: '',
                        middle_url: '',
                        middle_fontsize: '',
                        middle_x: '',
                        middle_y: '',
                        bottom_text: '',
                        bottom_url: '',
                        bottom_fontsize: '',
                        bottom_x: '',
                        bottom_y: '',
                        order: '',
                        active: '1'
            })
         }
    },

        components: {
            vueDropzone
        },
        methods: {
            carouselimagecomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Image:"+response.data);
                this.form.image = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/carousel?page=' + page)
                    .then(response => {
                        this.carousel = response.data;
                    });
            },
            updatecarousel() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/carousel/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'Carousel has been updated',
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
            createcarousel() {
                this.$Progress.start();
                this.form.post('/api/carousel')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Carousel created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(carousel) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(carousel)
            },
            newModal() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deletecarousel(id) {

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
                        this.form.delete('/api/carousel/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Carousel has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadcarousel() {
                axios.get('/api/carousel').then(({ data})=> (this.carousel=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findcarousel?q=' + query)
                    .then((data) => {
                        this.carousel = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadcarousel();
            Fire.$on('AfterCreate',() => {
                this.loadcarousel();
            })
        }
    }
</script>