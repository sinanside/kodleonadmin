<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header mt-2" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.pages']['pages'] }} - <small>{{ pagetitle }}</small></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $trans[lang+'.pages']['pages'] }}</a></li>
                            <li class="breadcrumb-item active">{{ pagetitle }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active show" href="#headerinfo" data-toggle="tab">{{ $trans[lang+'.pages']['header_information'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#shortdescription" data-toggle="tab">{{ $trans[lang+'.pages']['short_descriptions'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pictures" data-toggle="tab">{{ $trans[lang+'.pages']['pictures'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#detailed" data-toggle="tab">{{ $trans[lang+'.pages']['detailed_content'] }}</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['name'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.name" class="form-control" id="name"  :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Dil:</label>
                                        <div class="col-sm-12">
                                        <select v-model="form.language" id="type" name="language"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('language') }">
                                                <option value="1">Türkçe</option>
                                                <option value="2">İngilizce</option>
                                            </select>
                                            <has-error :form="form" field="language"></has-error>
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
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-primary">{{ $trans[lang+'.pages']['update'] }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">

                                <form class="form-horizontal">
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
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 3:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description3" class="form-control" id="short_description3"  :class="{ 'is-invalid': form.errors.has('short_description3') }">
                                            <has-error :form="form" field="short_description3"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 4:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description4" class="form-control" id="short_description4"  :class="{ 'is-invalid': form.errors.has('short_description4') }">
                                            <has-error :form="form" field="short_description4"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description5" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 5:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description5" class="form-control" id="short_description5"  :class="{ 'is-invalid': form.errors.has('short_description5') }">
                                            <has-error :form="form" field="short_description5"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description6" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 6:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description6" class="form-control" id="short_description6"  :class="{ 'is-invalid': form.errors.has('short_description6') }">
                                            <has-error :form="form" field="short_description6"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description7" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 7:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description7" class="form-control" id="short_description7"  :class="{ 'is-invalid': form.errors.has('short_description7') }">
                                            <has-error :form="form" field="short_description7"></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="short_description7" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 8:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description8" class="form-control" id="short_description8"  :class="{ 'is-invalid': form.errors.has('short_description8') }">
                                            <has-error :form="form" field="short_description8"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description7" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 9:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description9" class="form-control" id="short_description9"  :class="{ 'is-invalid': form.errors.has('short_description9') }">
                                            <has-error :form="form" field="short_description9"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description7" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 10:</label>


                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description10" class="form-control" id="short_description10"  :class="{ 'is-invalid': form.errors.has('short_description10') }">
                                            <has-error :form="form" field="short_description10"></has-error>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-primary">{{ $trans[lang+'.pages']['update'] }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="pictures">

                                <form class="form-horizontal">
                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture1'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone1" id="upload1" :options="imguploadconfig1" @vdropzone-complete="picture1complete"></vue-dropzone>
                                                <input v-model="form.picture1" id="picture1" type="text" name="picture1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture1') }">
                                                <has-error :form="form" field="picture1"></has-error>

                                                <input type="text" v-model="form.picture1_alt" class="form-control" id="picture1_alt"  :class="{ 'is-invalid': form.errors.has('picture1_alt') }">
                                                <has-error :form="form" field="picture1_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture1" :src="'\/img\/'+page+'\/thumbs\/'+form.picture1">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture2'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone2" id="upload2" :options="imguploadconfig2" @vdropzone-complete="picture2complete"></vue-dropzone>
                                                <input v-model="form.picture2" id="picture2" type="text" name="picture2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture2') }">
                                                <has-error :form="form" field="picture2"></has-error>

                                                <input type="text" v-model="form.picture2_alt" class="form-control" id="picture2_alt"  :class="{ 'is-invalid': form.errors.has('picture2_alt') }">
                                                <has-error :form="form" field="picture2_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture2" :src="'\/img\/'+page+'\/thumbs\/'+form.picture2">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture3'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone3" id="upload3" :options="imguploadconfig3" @vdropzone-complete="picture3complete"></vue-dropzone>
                                                <input v-model="form.picture3" id="picture3" type="text" name="picture3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture3') }">
                                                <has-error :form="form" field="picture3"></has-error>

                                                <input type="text" v-model="form.picture3_alt" class="form-control" id="picture3_alt"  :class="{ 'is-invalid': form.errors.has('picture3_alt') }">
                                                <has-error :form="form" field="picture3_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture3" :src="'\/img\/'+page+'\/thumbs\/'+form.picture3">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture4'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone4" id="upload4" :options="imguploadconfig4" @vdropzone-complete="picture4complete"></vue-dropzone>
                                                <input v-model="form.picture4" id="picture4" type="text" name="picture4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture4') }">
                                                <has-error :form="form" field="picture4"></has-error>

                                                <input type="text" v-model="form.picture4_alt" class="form-control" id="picture4_alt"   :class="{ 'is-invalid': form.errors.has('picture4_alt') }">
                                                <has-error :form="form" field="picture4_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture4" :src="'\/img\/'+page+'\/thumbs\/'+form.picture4">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture5'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone5" id="upload5" :options="imguploadconfig5" @vdropzone-complete="picture5complete"></vue-dropzone>
                                                <input v-model="form.picture5" id="picture5" type="text" name="picture5"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture5') }">
                                                <has-error :form="form" field="picture5"></has-error>

                                                <input type="text" v-model="form.picture5_alt" class="form-control" id="picture5_alt"  :class="{ 'is-invalid': form.errors.has('picture5_alt') }">
                                                <has-error :form="form" field="picture5_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture5" :src="'\/img\/'+page+'\/thumbs\/'+form.picture5">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-primary">{{ $trans[lang+'.pages']['update'] }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- headerinfo Tab -->
                            <div class="tab-pane" id="detailed">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content1'] }}:</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor1"
                                                        v-model="form.description1">
                                            </vue-editor>
                                            <has-error :form="form" field="description1"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content2'] }}:</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor2"
                                                        v-model="form.description2">
                                            </vue-editor>
                                            <has-error :form="form" field="description2"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content3'] }}:</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor3"
                                                        v-model="form.description3">
                                            </vue-editor>

                                            <has-error :form="form" field="description3"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content4'] }}:</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor4"
                                                        v-model="form.description4">
                                            </vue-editor>
                                            <has-error :form="form" field="description4"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content5'] }}:</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor5"
                                                        v-model="form.description5">
                                            </vue-editor>
                                            <has-error :form="form" field="description5"></has-error>
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-primary">{{ $trans[lang+'.pages']['update'] }}</button>
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
    import vueDropzone from 'vue2-dropzone';
    import { VueEditor, Quill } from "vue2-editor";
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module-withfix";
    import axios from "axios";

    Quill.register("modules/imageDrop", ImageDrop);
    Quill.register("modules/imageResize", ImageResize);

    export default {
        components: {
            VueEditor,vueDropzone
        },
        data() {
            return {
                lang: this.$lang,

                page:"dhisacekimi",
                pagetitle:"DHI Saç Ekimi",

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
                    url: "/api/dhisacekimi_image1",
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
                    url: "/api/dhisacekimi_image2",
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
                    url: "/api/dhisacekimi_image3",
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
                    url: "/api/dhisacekimi_image4",
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
                    url: "/api/dhisacekimi_image5",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },

                form: new Form({
                    id: '',
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
                    language: '',

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
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
                    url: "/api/"+this.page+"_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/"+this.page+"/thumbs/"+result.data.data; // Get url from response
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
                console.log("picture1:"+response.data);
                this.form.picture1 = response.data;
            },
            picture2complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("picture2:"+response.data);
                this.form.picture2 = response.data;
            },
            picture3complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("picture3:"+response.data);
                this.form.picture3 = response.data;
            },
            picture4complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("picture4:"+response.data);
                this.form.picture4 = response.data;
            },
            picture5complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("picture5:"+response.data);
                this.form.picture5 = response.data;
            },
            updateInfo(){
                this.$Progress.start();

                this.form.put("/api/"+this.page)
                    .then(()=>{
                        toast.fire({
                            type: 'success',
                            title: 'Page info changed successfully'
                        });
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            }
        },
        created() {
            axios.get("/api/"+this.page)
                .then(({data}) => (this.form.fill(data)));

        }

    }
</script>

