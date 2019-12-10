<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.shop']['categories'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $trans[lang+'.shop']['categories'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.shop']['topcategory'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.shop']['topcategory'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.shop']['specialcode_tc'] }}</th>
                                <th>{{ $trans[lang+'.shop']['name_tc'] }}</th>
                                <th>{{ $trans[lang+'.shop']['menu'] }}</th>
                                <th>{{ $trans[lang+'.blog']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="topcategories,index in topcategories.data" :key="topcategories.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ topcategories.specialcode_tc }}</td>
                                <td>{{ topcategories.name_tc }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="topcategories.menu">Evet</span>
                                    <span class="badge badge-danger" v-else>Hayır</span>
                                </td>

                                <td>
                                    <span class="badge badge-success" v-if="topcategories.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(topcategories.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(topcategories.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(topcategories)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletetopcategories(topcategories.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="topcategories" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>


        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#summary" data-toggle="tab">{{ $trans[lang+'.pages']['summary'] }}</a></li>
                            <li class="nav-item"><a class="nav-link active show" href="#headerinfo" data-toggle="tab">{{ $trans[lang+'.blog']['header_information'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pictures" data-toggle="tab">{{ $trans[lang+'.blog']['pictures'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#detailed" data-toggle="tab">{{ $trans[lang+'.blog']['detailed_content'] }}</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="summary">
                                <h3 class="text-center">{{ $trans[lang+'.blog']['posts_info'] }}</h3>

                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Model:</strong> App\Topcategory;<br>
                                    <strong>Usage:</strong> Topcategory::where('slug', '=', $slug)->firstOrFail();
                                </div>

                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                    <th scope="col">#</th>
                                    <th scope="col">Key</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Data</th>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td><strong>{{ $trans[lang+'.blog']['title1'] }}</strong></td>
                                        <td>
                                            {{this.form.name_tc}}
                                        </td>
                                        <td>title</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><strong>{{ $trans[lang+'.blog']['slug'] }} (Slug)</strong></td>
                                        <td>
                                            {{this.form.slug}}
                                        </td>
                                        <td>title</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><strong>{{ $trans[lang+'.blog']['meta_description'] }}</strong></td>
                                        <td>
                                            {{this.form.meta_description}}
                                        </td>
                                        <td>meta_description</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td><strong>{{ $trans[lang+'.shop']['menu'] }}</strong></td>
                                        <td>
                                            <span class="badge badge-success" v-if="this.form.menu">Evet</span>
                                            <span class="badge badge-danger" v-else>Hayır</span>
                                        </td>
                                        <td>mainpage</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><strong>{{ $trans[lang+'.blog']['active'] }}</strong></td>
                                        <td>
                                            <span class="badge badge-success" v-if="this.form.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                            <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                        </td>
                                        <td>active</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}1</strong></td>
                                        <td>
                                            <img v-if="form.photo1" :src="'\/img/shop/topcategory/thumbs\/'+form.photo1">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo1</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}1 Alt</strong></td>
                                        <td>
                                            {{this.form.photo1_alt}}
                                        </td>
                                        <td>photo1_alt</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}2</strong></td>
                                        <td>
                                            <img v-if="form.photo2" :src="'\/img\/shop\/topcategory\/thumbs\/'+form.photo2">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo2</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}2 Alt</strong></td>
                                        <td>
                                            {{this.form.photo2_alt}}
                                        </td>
                                        <td>photo2_alt</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}3</strong></td>
                                        <td>
                                            <img v-if="form.picture3" :src="'\/img/shop/topcategory/thumbs\/'+form.picture3">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo3</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}3 Alt</strong></td>
                                        <td>
                                            {{this.form.photo3_alt}}
                                        </td>
                                        <td>photo3_alt</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td><strong>{{ $trans[lang+'.blog']['short_content'] }}:</strong></td>
                                        <td>{{this.form.short_description}}</td>
                                        <td>Kısa Açıklama</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td><strong>{{ $trans[lang+'.blog']['content'] }}:</strong></td>
                                        <td>-</td>
                                        <td>content</td>
                                    </tr>


                                    </tbody></table>


                            </div>
                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['specialcode_tc'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.specialcode_tc" class="form-control" id="title"  :class="{ 'is-invalid': form.errors.has('specialcode_tc') }">
                                            <has-error :form="form" field="specialcode_tc"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name_tc" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['name_tc'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.name_tc" class="form-control" id="name_tc"  :class="{ 'is-invalid': form.errors.has('name_tc') }">
                                            <has-error :form="form" field="name_tc"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name_tc_web" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['name_tc_web'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.name_tc_web" class="form-control" id="name_tc_web"  :class="{ 'is-invalid': form.errors.has('name_tc_web') }">
                                            <has-error :form="form" field="name_tc_web"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="menu" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['menu'] }}:</label>
                                        <div class="col-sm-12">
                                            <select v-model="form.menu" id="menu" name="menu"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('menu') }">
                                                <option value="1">{{ $trans[lang+'.blog']['yes'] }}</option>
                                                <option value="0">{{ $trans[lang+'.blog']['no'] }}</option>
                                            </select>
                                            <has-error :form="form" field="active"></has-error>
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
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.shop']['backtolist'] }} </button>
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
                                                <input v-model="form.photo1" id="photo1" type="text" name="photo1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo1') }">
                                                <has-error :form="form" field="photo1"></has-error>

                                                <input type="text" v-model="form.photo1_alt" class="form-control" id="photo1_alt"  :class="{ 'is-invalid': form.errors.has('photo1_alt') }">
                                                <has-error :form="form" field="photo1_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.photo1" :src="'\/img\/shop\/topcategory\/thumbs\/'+form.photo1">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture2'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone2" id="upload2" :options="imguploadconfig2" @vdropzone-complete="picture2complete"></vue-dropzone>
                                                <input v-model="form.photo2" id="photo2" type="text" name="photo2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo2') }">
                                                <has-error :form="form" field="photo2"></has-error>

                                                <input type="text" v-model="form.photo2_alt" class="form-control" id="photo2_alt"  :class="{ 'is-invalid': form.errors.has('photo2_alt') }">
                                                <has-error :form="form" field="photo2_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.photo2" :src="'\/img\/shop\/topcategory\/thumbs\/'+form.photo2">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture3'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone3" id="upload3" :options="imguploadconfig3" @vdropzone-complete="picture3complete"></vue-dropzone>
                                                <input v-model="form.photo3" id="picture3" type="text" name="photo3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo3') }">
                                                <has-error :form="form" field="photo3"></has-error>

                                                <input type="text" v-model="form.photo3_alt" class="form-control" id="photo3_alt"  :class="{ 'is-invalid': form.errors.has('photo3_alt') }">
                                                <has-error :form="form" field="photo3_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.photo3" :src="'\/img\/shop\/topcategory\/thumbs\/'+form.photo3">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.blog']['backtolist'] }} </button>   </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- headerinfo Tab -->
                            <div class="tab-pane" id="detailed">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <label for="name_tc" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['short_description'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description" class="form-control" id="short_description"  :class="{ 'is-invalid': form.errors.has('short_description') }">
                                            <has-error :form="form" field="short_description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name_tc" class="col-sm-2 control-label">{{ $trans[lang+'.shop']['meta_description'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_description" class="form-control" id="meta_description"  :class="{ 'is-invalid': form.errors.has('meta_description') }">
                                            <has-error :form="form" field="meta_description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.shop']['description'] }}</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor2"
                                                        v-model="form.description">
                                            </vue-editor>
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.blog']['backtolist'] }} </button>
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
                    url: "/api/topcategory_image1",
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
                    url: "/api/topcategory_image2",
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
                    url: "/api/topcategory_image3",
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
                topcategories: {},
                form: new Form(
                    {
                        id: '',
                        specialcode_tc: '',
                        name_tc: '',
                        name_tc_web: '',
                        slug: '',
                        photo1: '',
                        photo2: '',
                        photo3: '',
                        short_description: '',
                        meta_description: '',
                        description: '',
                        queue: '',
                        menu: '0',
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
                    url: "/api/posts_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/shop/topcategory/thumbs/"+result.data.data; // Get url from response
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
                this.form.photo1 = response.data;
            },
            picture2complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo2:"+response.data);
                this.form.photo2 = response.data;
            },
            picture3complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo3:"+response.data);
                this.form.photo3 = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/topcategory?page=' + page)
                    .then(response => {
                        this.topcategories = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/topcategoryup",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'topcategories order updated',
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
                    url: "/api/topcategorydown",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'topcategories order updated',
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

                this.form.put('/api/topcategory/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'topcategories has been updated',
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
                this.form.post('/api/topcategory')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'topcategories created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(topcategories) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.form.reset();﻿
                this.form.fill(topcategories);
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.form.reset();﻿
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deletetopcategories(id) {

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
                        this.form.delete('/api/topcategory/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'topcategories has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadtopcategories() {
                axios.get('/api/topcategory').then(({ data})=> (this.topcategories=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findtopcategories?q=' + query)
                    .then((data) => {
                        this.topcategories = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadtopcategories();

            Fire.$on('AfterCreate',() => {
                this.loadtopcategories();
            })
        }
    }
</script>
