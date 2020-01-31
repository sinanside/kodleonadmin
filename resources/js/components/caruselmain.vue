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

                        <div class="card-tools px-1">
                            <select v-model="form.language2" @change="loadcarouselbylang(form.language2)" class="form-control" id="language2">
                                <option value="0" disabled>Dil Seç</option>
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
                                <th>{{ $trans[lang+'.carousel']['image'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['title1'] }}</th>
                                <th>Tür</th>
                                <th>Dil</th>
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
                                    <span v-show="carousel.type==1" class="badge badge-info">Liste</span>
                                    <span v-show="carousel.type==0" class="badge badge-warning">Default</span>
                                </td>
                                <td>{{ carousel.localization.title }}</td>

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
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#giristab" data-toggle="tab">{{ $trans[lang+'.blog']['header_information'] }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#shortdescription" data-toggle="tab">Linkler</a></li>

                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- picturetab Tab -->
                            <div class="tab-pane active show" id="giristab">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <strong>Dil:</strong>

                                            <select v-model="form.language" id="language" class="form-control" :class="{ 'is-invalid': form.errors.has('language') }">
                                                <option value="0" disabled>Dil Seç</option>
                                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="language"></has-error>

                                    </div>

                                    <div class="form-group">
                                        <strong>Tür:</strong><br>
                                        <select v-model="form.type" id="type" name="type"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                            <option value="0">Default</option>
                                            <option value="1">Liste</option>
                                        </select>
                                        <has-error :form="form" field="type"></has-error>
                                    </div>

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
                                        <div class="row">
                                            <div class="col-6">
                                                <vue-dropzone  ref="myVueDropzone" id="upload2" :options="videouploadconfig" @vdropzone-complete="carouselvideocomplete"></vue-dropzone>
                                                <input v-model="form.video" id="video" type="text" name="video"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('video') }">
                                                <has-error :form="form" field="video"></has-error>
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

                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">Başlık 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description1" class="form-control" id="short_description1"  :class="{ 'is-invalid': form.errors.has('short_description1') }">
                                            <has-error :form="form" field="short_description1"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description2" class="col-sm-2 control-label">Link 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description2" class="form-control" id="short_description2"  :class="{ 'is-invalid': form.errors.has('short_description2') }">
                                            <has-error :form="form" field="short_description2"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">Başlık 2:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description3" class="form-control" id="short_description3"  :class="{ 'is-invalid': form.errors.has('short_description3') }">
                                            <has-error :form="form" field="short_description3"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">Link 2:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description4" class="form-control" id="short_description4"  :class="{ 'is-invalid': form.errors.has('short_description4') }">
                                            <has-error :form="form" field="short_description4"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description5" class="col-sm-2 control-label">Başlık 3:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description5" class="form-control" id="short_description5"  :class="{ 'is-invalid': form.errors.has('short_description5') }">
                                            <has-error :form="form" field="short_description5"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description6" class="col-sm-2 control-label">Link 3:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description6" class="form-control" id="short_description6"  :class="{ 'is-invalid': form.errors.has('short_description6') }">
                                            <has-error :form="form" field="short_description6"></has-error>
                                        </div>
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
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },

                videouploadconfig: {
                    url: "/api/carousel_video",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD VIDEO",
                    addRemoveLinks: true
                },

                editmode: false,
                listmode: true,
                addmode: false,
                carousel: {},
                localizations:{},
                tmplang:'',

                form: new Form(
                    {
                        id: '',
                        language:'',
                        language2:'1',
                        type:'',
                        carousel_title: '',
                        image: '',
                        image_alt: '',
                        video: '',
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
            carouselvideocomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Video1:"+response.data);
                this.form.video = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/carousel?page=' + page)
                    .then(response => {
                        this.carousel = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/carouselup",
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
                    url: "/api/carouseldown",
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
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.fill(carousel);
                this.form.language2=this.form.language;
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone.removeAllFiles();
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.language2=this.form.language;
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
            },
            loadcarouselbylang(id) {
                axios.get('/api/carouselbylang/'+id).then(({ data})=> (this.carousel=data));
            },
            loadLocalization() {
                axios.get('/api/activelocalizations').then(({ data})=> (this.localizations=data));
            },
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

            //this.loadcarousel();
            this.loadcarouselbylang(this.form.language2);
            this.loadLocalization();

            Fire.$on('AfterCreate',() => {
                //this.loadcarousel();
                this.loadcarouselbylang(this.form.language2);

            })
        }
    }
</script>
