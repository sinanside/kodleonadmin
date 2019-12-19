<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Bloglar</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">Bloglar</a></li>
                            <li class="breadcrumb-item active">Sayfa</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Blog Listesi</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                        <div class="card-tools px-1">
                            <select v-model="form.language2" @change="loadpostsbylang(form.language2)" class="form-control" id="language2">
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
                                <th>Tanım</th>
                                <th>Dil</th>
                                <th>Durum</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="posts,index in posts.data" :key="posts.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ posts.name }}</td>
                                <td>{{ posts.localization.title }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="posts.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(posts.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(posts.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(posts)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteposts(posts.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="posts" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>


        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active show" href="#headerinfo" data-toggle="tab">Seo Bilgileri</a></li>
                            <li class="nav-item"><a class="nav-link" href="#shortdescription" data-toggle="tab">Sayfa İçeriği</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">

                                <form class="form-horizontal">


                                    <div class="form-group">
                                        <label for="language" class="col-sm-2 control-label">Dil:</label>

                                        <div class="col-sm-12">
                                            <select v-model="form.language" class="form-control" :class="{ 'is-invalid': form.errors.has('language') }">
                                                <option value="0">Dil Seç</option>
                                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="althiz_id"></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">{{ $trans[lang+'.blog']['title1'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="text" v-model="form.name" class="form-control" id="name"  :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_title'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_title" class="form-control" id="meta_title"  :class="{ 'is-invalid': form.errors.has('meta_title') }">
                                            <has-error :form="form" field="meta_title"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_description'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_description" class="form-control" id="meta_description"  :class="{ 'is-invalid': form.errors.has('meta_description') }">
                                            <has-error :form="form" field="meta_description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_keywords'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_keywords" class="form-control" id="meta_keywords" :class="{ 'is-invalid': form.errors.has('meta_keywords') }">
                                            <has-error :form="form" field="meta_keywords"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="active" class="col-sm-2 control-label">{{ $trans[lang+'.blog']['status'] }}:</label>
                                        <div class="col-sm-12">
                                            <select v-model="form.active" id="active" name="active"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                                <option value="1">{{ $trans[lang+'.blog']['active'] }}</option>
                                                <option value="0">{{ $trans[lang+'.blog']['passive'] }}</option>
                                            </select>
                                            <has-error :form="form" field="active"></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Blog Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} :</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description1" class="form-control" id="short_description1"  :class="{ 'is-invalid': form.errors.has('short_description1') }">
                                            <has-error :form="form" field="short_description1"></has-error>
                                        </div>
                                    </div>
                                        </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture1'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone1" id="upload1" :options="imguploadconfig1" @vdropzone-complete="picture1complete"></vue-dropzone>
                                                <input v-model="form.picture1" id="photo1" type="text" name="picture1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo1') }">
                                                <has-error :form="form" field="photo1"></has-error>

                                                <input type="text" v-model="form.picture1_alt" class="form-control" id="picture1_alt"  :class="{ 'is-invalid': form.errors.has('picture1_alt') }">
                                                <has-error :form="form" field="picture1_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture1" :src="'\/img\/sayfalar\/thumbs\/'+form.picture1">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture2'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone2" id="upload2" :options="imguploadconfig2" @vdropzone-complete="picture2complete"></vue-dropzone>
                                                <input v-model="form.picture2" id="photo2" type="text" name="photo2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture2') }">
                                                <has-error :form="form" field="picture2"></has-error>

                                                <input type="text" v-model="form.picture2_alt" class="form-control" id="picture2_alt"  :class="{ 'is-invalid': form.errors.has('picture2_alt') }">
                                                <has-error :form="form" field="picture2_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture2" :src="'\/img\/sayfalar\/thumbs\/'+form.picture2">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Detay:</label>

                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor :editorOptions="editorSettings"
                                                            useCustomImageHandler
                                                            @imageAdded="handleImageAdded"
                                                            id="mainpage_editor1"
                                                            v-model="form.description1">
                                                </vue-editor>

                                                <has-error :form="form" field="description1"></has-error>
                                            </div>
                                        </div>
                                    </div>



                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Blog Listesine Dön </button>   </div>
                                    </div>
                                </form>
                            </div>
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

</template>

<script>
    import vueDropzone from "vue2-dropzone";
    import { VueEditor, Quill } from "vue2-editor";
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module-withfix";
    import axios from "axios";

    Quill.register("modules/imageDrop", ImageDrop);
    Quill.register("modules/imageResize", ImageResize);

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

                imguploadconfig1: {
                    url: "/api/icerikler4_image1",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },
                imguploadconfig2: {
                    url: "/api/icerikler4_image2",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },
                imguploadconfig3: {
                    url: "/api/icerikler4_image3",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },
                imguploadconfig4: {
                    url: "/api/icerikler4_image4",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },
                imguploadconfig5: {
                    url: "/api/icerikler4_image5",
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
                localizations:{},
                posts: {},
                tmplang:'',
                form: new Form(
                    {
                        id: '',
                        language:'',
                        language2:'1',
                        name: '',
                        meta_title: '',
                        meta_description: '',
                        meta_keywords: '',
                        short_description1: '',
                        short_description2: '',
                        short_description3: '',
                        short_description4: '',
                        short_description5: '',
                        short_description6: '',
                        short_description7: '',
                        short_description8: '',
                        short_description9: '',
                        short_description10: '',
                        picture1: '',
                        picture1_alt: '',
                        picture2: '',
                        picture2_alt: '',
                        picture3: '',
                        picture3_alt: '',
                        picture4: '',
                        picture4_alt: '',
                        picture5: '',
                        picture5_alt: '',
                        picture6: '',
                        picture6_alt: '',
                        picture7: '',
                        picture7_alt: '',
                        picture8: '',
                        picture8_alt: '',
                        description1: '',
                        description2: '',
                        description3: '',
                        description4: '',
                        description5: '',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone,VueEditor
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
                    url: "/api/icerikler4_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/sayfalar/thumbs/"+result.data.data; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                        console.log("Picture:"+url);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            // VUE2 EDITOR IMAGE UPLOAD PLUGİN ENDS

            picture1complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo1:"+response.data);
                this.form.picture1 = response.data;
            },
            picture2complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo2:"+response.data);
                this.form.picture2 = response.data;
            },
            picture3complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo3:"+response.data);
                this.form.picture3 = response.data;
            },
            picture4complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo4:"+response.data);
                this.form.picture4 = response.data;
            },
            picture5complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo5:"+response.data);
                this.form.picture5= response.data;
            },

            getResults(page = 1) {
                axios.get('/api/icerikler4?page=' + page)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/icerikler4up",
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
            downrecords(id) {
                axios({
                    url: "/api/icerikler4down",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            updateposts() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/icerikler4/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Record has been updated',
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
            createposts() {
                this.$Progress.start();
                this.form.post('/api/icerikler4')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.tmplang=this.form.language;
                        this.form.reset();﻿
                        this.form.language2 = this.tmplang;
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Record created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(posts) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.fill(posts);
                this.form.language2=this.form.language;
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
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
            deleteposts(id) {

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
                        this.form.delete('/api/icerikler4/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'posts has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadposts() {
                axios.get('/api/icerikler4').then(({ data})=> (this.posts=data));
            },
            loadLocalization() {
                axios.get('/api/localizations').then(({ data})=> (this.localizations=data));
            },
            loadpostsbylang(id) {
                axios.get('/api/icerikler4bylang/'+id).then(({ data})=> (this.posts=data));
            },
        },

        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findIcerikler4?q=' + query)
                    .then((data) => {
                        this.posts = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadpostsbylang(this.form.language2);
            this.loadLocalization();

            Fire.$on('AfterCreate',() => {
                this.loadpostsbylang(this.form.language2);
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            })
        }
    }
</script>
