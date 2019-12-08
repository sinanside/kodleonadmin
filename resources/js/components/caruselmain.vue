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

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.carousel']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
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
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
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
                                    <span v-show="carousel.active==1" class="badge badge-success">{{ $trans[lang+'.carousel']['active'] }}</span>
                                    <span v-show="carousel.active==0" class="badge badge-danger">{{ $trans[lang+'.carousel']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(carousel.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(carousel.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(carousel)"><i class="fa fa-edit blue"></i></a> /
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



        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header p-2 bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.carousel']['title'] }}</h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- picturetab Tab -->
                            <div class="tab-pane active show" id="picturetab">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['title1'] }}:</strong><br>
                                        <input v-model="form.carousel_title" id="name" type="text" name="carousel_title"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('carousel_title') }">
                                        <has-error :form="form" field="carousel_title"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="carouselimagecomplete"></vue-dropzone>
                                                <input v-model="form.image" id="image" type="text" name="image"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                                <has-error :form="form" field="image"></has-error>
                                                <input v-model="form.image_alt" id="image_alt" type="text" name="image_alt" placeholder="Image alt information"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('image_alt') }">
                                                <has-error :form="form" field="image_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.image" :src="'\/img\/carousel\/thumbs\/'+form.image">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['status'] }}:</strong><br>
                                        <select v-model="form.active" id="type" name="active"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                            <option value="1">Active</option>
                                            <option value="0">Passive</option>
                                        </select>
                                        <has-error :form="form" field="active"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecarousel" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcarousel" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
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

                imguploadconfig: {
                    url: "/api/carousel_image",
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
                listmode: true,
                addmode: false,
                carousel: {},
                form: new Form(
                    {
                        id: '',
                        carousel_title: '',
                        image: '',
                        image_alt: '',
                        image_x: '',
                        image_y: '',
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
                console.log("Photo1:"+response.data);
                this.form.image = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/carousel?page=' + page)
                    .then(response => {
                        this.carousel = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/carouselup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Carousel order updated',
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
                    url: "/api/carouseldown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Carousel order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updatecarousel() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/carousel/'+this.form.id)
                    .then(() => {
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
            editForm(carousel) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone.removeAllFiles();
                this.form.reset();﻿
                this.form.fill(carousel);
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone.removeAllFiles();
                this.form.reset();﻿
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
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