<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Galeri</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">Galeri</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Galeri Listesi</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                        <div class="card-tools px-1">


                            <select v-model="form.language2" @change="loadpostsbylang(form.language2)" class="form-control" id="language2">
                                <option value="0" disabled>Dil Seç</option>
                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                    {{ localization.title }}
                                </option>
                            </select>
                        </div>

                        <div class="card-tools px-2">
                            <select
                                v-model="form.althiz2"
                                @change="
                                    loadpostsbylang(
                                        form.language2,
                                        form.althiz2
                                    )
                                "
                                class="form-control"
                                id="althizmettur2"
                            >
                                <option value="0" disabled>Althizmet Seç</option>
                                <option
                                    v-if="althizmetturs2.length > 0"
                                    v-for="althizmettur2 in althizmetturs2"
                                    v-bind:value="althizmettur2.id"
                                >
                                    {{ althizmettur2.title }}
                                </option>
                            </select>

                        </div>



                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>Resim</th>
                                <th>Hizmet</th>
                                <th>Alt Hizmet</th>
                                <th>Tanım</th>
                                <th>Dil</th>
                                <th>Durum</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="posts,index in posts.data" :key="posts.id">
                                <td>{{ index+1 }}</td>
                                <td><img v-if="posts.picture1" :src="'\/img\/gallery\/thumbs\/'+posts.picture1">
                                    <img v-else :src="'\/img\/nophoto.png'"></td>
                                <td>{{ posts.hizmettur.title }}</td>
                                <td  v-if="posts.althizmettur">{{ posts.althizmettur.title }}</td>
                                <td v-else>-</td>
                                <td>{{ posts.name }}</td>
                                <td>{{ posts.localization.title }}</td>
                                <td>
                                    <span class="badge badge-success" v-show="posts.active==1">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-show="posts.active==0">{{ $trans[lang+'.blog']['passive'] }}</span>
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
                            <li class="nav-item"><a class="nav-link active show" href="#headerinfo" data-toggle="tab">{{ $trans[lang+'.blog']['header_information'] }}</a></li>
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
                                            <select @change="loadhizmettursbylang(form.language)" v-model="form.language" class="form-control" id="language" :class="{ 'is-invalid': form.errors.has('language') }">
                                                <option value="0" disabled>Dil Seç</option>
                                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="language"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Hizmet:</label>

                                        <div class="col-sm-12">
                                            <select @change="loadAlthizmettur(form.hiz_id)" v-model="form.hiz_id" class="form-control" :class="{ 'is-invalid': form.errors.has('hiz_id') }">
                                                <option value="0">Hizmet Seç</option>
                                                <option v-if="hizmetturs.length > 0" v-for="hizmettur in hizmetturs" v-bind:value="hizmettur.id">
                                                    {{ hizmettur.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="hiz_id"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="althiz_id" class="col-sm-2 control-label">Alt Hizmet:</label>

                                        <div class="col-sm-12">
                                            <select v-model="form.althiz_id" class="form-control" id="althiz_id" :class="{ 'is-invalid': form.errors.has('althiz_id') }">
                                                <option value="0">Alt Hizmet Seç</option>
                                                <option v-if="althizmetturs.length > 0" v-for="althizmettur in althizmetturs" v-bind:value="althizmettur.id">
                                                    {{ althizmettur.title }}
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
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description1" class="form-control" id="short_description1"  :class="{ 'is-invalid': form.errors.has('short_description1') }">
                                            <has-error :form="form" field="short_description1"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="short_description2" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 2:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description2" class="form-control" id="short_description2"  :class="{ 'is-invalid': form.errors.has('short_description2') }">
                                            <has-error :form="form" field="short_description2"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">Detay :</label>

                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="hizmet_editor1"
                                                    v-model="form.description1"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description1"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Resim Yükle:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone1" id="upload1" :options="imguploadconfig1" @vdropzone-complete="picture1complete"></vue-dropzone>
                                                <input v-model="form.picture1" id="picture1" type="text" name="picture1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture1') }">
                                                <has-error :form="form" field="picture1"></has-error>

                                                <input type="text" v-model="form.picture1_alt" class="form-control" id="picture1_alt"  :class="{ 'is-invalid': form.errors.has('picture1_alt') }">
                                                <has-error :form="form" field="picture1_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture1" :src="'\/img\/gallery\/thumbs\/'+form.picture1">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
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
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Galeri Listesine Dön </button>
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
    import { VueEditor, Quill } from "vue2-editor";
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module";
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
                    url: "/api/resimler_image1",
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
                listmode: true,
                addmode: false,
                hizmetturs:{},
                althizmetturs:{},
                althizmetturs2:{},
                localizations:{},
                posts: {},
                tmplang:'',
                tmpalthizmet:'',
                form: new Form(
                    {
                        id: '',
                        hiz_id:'',
                        althiz_id:'',
                        althiz2:'0',
                        language:'',
                        language2:'1',
                        name: '',
                        short_description1: '',
                        short_description2: '',
                        description1: '',
                        picture1: '',
                        picture1_alt: '',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone
        },
        methods: {

            handleImageAdded: function(
                file,
                Editor,
                cursorLocation,
                resetUploader
            ) {
                // An example of using FormData
                // NOTE: Your key could be different such as:
                // formData.append('file', file)

                var formData = new FormData();
                formData.append("file", file);

                axios({
                    url: "/api/icerikler_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/hizmetler/" + result.data.data; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                        console.log("Picture:" + url);
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

            getResults(page = 1) {
                axios.get('/api/resimlerbylang/'+this.form.language2+'/'+this.form.althiz2+'?page=' + page)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/resimlerup",
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
                    url: "/api/resimlerdown",
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

                    this.form.put('/api/resimler/'+this.form.id)
                        .then(() => {
                            toast.fire(
                                'Güncellendi!',
                                'Kayıt başarıyla güncellendi.',
                                'success'
                            )
                            this.$Progress.finish();
                            Fire.$emit('AfterCreate');
                        })
                        .catch(() => {
                            this.$Progress.fail();
                            toast.fire("Başarısız","Bir hata meydana geldi.","warning");

                        });

            },
            createposts() {
                this.$Progress.start();
                this.form.post('/api/resimler')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.tmplang=this.form.language;
                        this.tmpalthizmet=this.form.althiz2;
                        this.form.reset();﻿
                        this.form.language2 = this.tmplang;
                        this.form.althiz2=this.tmpalthizmet;
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
                this.tmplang=this.form.language2;
                this.tmpalthizmet=this.form.althiz2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.althiz2=this.tmpalthizmet;
                this.form.fill(posts);
                this.loadhizmettursbylang(this.form.language);
                this.loadAlthizmettur(this.form.hiz_id);
                this.form.language2=this.form.language;
                this.form.althiz2=this.tmpalthizmet;


            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.tmplang=this.form.language2;
                this.tmpalthizmet=this.form.althiz2;
                this.form.reset();﻿
                this.form.hiz_id = 0;
                this.form.althiz_id = this.form.althiz2;
                this.form.language = this.tmplang;
                this.form.language2=this.form.language;
                this.form.althiz2=this.tmpalthizmet;


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
                        this.form.delete('/api/resimler/'+id).then(()=>{

                            swal.fire(
                                'Silindi!',
                                'Galeri içeriği başarıyla silindi.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadposts(id) {
                axios.get('/api/resimlerbyalthizmet/'+id).then(({ data})=> (this.posts=data));
            },
            loadpostsbylang(id,id2) {
                axios.get('/api/resimlerbylang/'+id+'/'+id2).then(({ data})=> (this.posts=data));
                axios.get('/api/hizmettursbylang2/'+id).then(({ data})=> (this.hizmetturs=data));
            },
            loadhizmettursbylang(id) {
                axios.get('/api/hizmettursbylang2/'+id).then(({ data})=> (this.hizmetturs=data));
            },
            loadHizmettur() {
                axios.get('/api/hizmettursbylang2/1').then(({ data})=> (this.hizmetturs=data));
            },
            loadAlthizmettur(id) {
                axios.get('/api/Allalthizmettur/'+id).then(({ data})=> (this.althizmetturs=data));
            },
            loadAlthizmettur2(id) {
                axios.get('/api/Allalthizmettur2').then(({ data})=> (this.althizmetturs2=data));
            },
            loadLocalization() {
                axios.get('/api/activelocalizations').then(({ data})=> (this.localizations=data));
            }
        },

        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findResimler?q=' + query)
                    .then((data) => {
                        this.posts = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadposts(this.form.althiz2);
            this.loadHizmettur();
            this.loadLocalization();
            this.loadAlthizmettur2();

            Fire.$on('AfterCreate',() => {
                this.loadpostsbylang(this.form.language2,this.form.althiz2);
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            })
        }
    }
</script>
