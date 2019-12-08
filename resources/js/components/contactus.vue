<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.contactus']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.contactus']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.contactus']['title'] }}</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.contactus']['name'] }}</th>
                                <th>{{ $trans[lang+'.contactus']['email'] }}</th>
                                <th>{{ $trans[lang+'.contactus']['phone'] }}</th>
                                <th>{{ $trans[lang+'.contactus']['status'] }}</th>
                                <th>{{ $trans[lang+'.contactus']['createdat'] }}</th>
                                <th>{{ $trans[lang+'.contactus']['updatedat'] }}</th>
                                <th>{{ $trans[lang+'.ourteam']['modify'] }}</th>
                            </tr>

                            <tr v-for="contactus,index in contactus.data" :key="contactus.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ contactus.name }}</td>
                                <td>{{ contactus.email }}</td>
                                <td>{{ contactus.phone }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="contactus.responsed">{{ $trans[lang+'.contactus']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.contactus']['passive'] }}</span>
                                </td>
                                <td>{{ contactus.created_at  | moment("add", "3 h", "from", "now") }}</td>
                                <td>{{ contactus.updated_at  | moment("add", "3 h", "from", "now") }}</td>

                                <td>
                                    <a href="#" @click="editForm(contactus)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletecontactus(contactus.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="contactus" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>



        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">


                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.contactus']['tab'] }}</h3>

                    </div>

                    <div class="card-body">
                        <div class="tab-content">

                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">{{ $trans[lang+'.contactus']['name'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.name" class="form-control" readonly id="name"  :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">{{ $trans[lang+'.contactus']['email'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.email" class="form-control"  readonly id="email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 control-label">{{ $trans[lang+'.contactus']['phone'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.phone" class="form-control" readonly id="phone"  :class="{ 'is-invalid': form.errors.has('phone') }">
                                            <has-error :form="form" field="phone"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.contactus']['message'] }}</label>

                                        <div class="col-sm-12" id="test">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor1"
                                                        :disabled="true"
                                                        v-model="form.message">
                                            </vue-editor>
                                            <has-error :form="form" field="message"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label">{{ $trans[lang+'.contactus']['response'] }}</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor2"
                                                        v-model="form.response">
                                            </vue-editor>
                                            <has-error :form="form" field="response"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecontactus" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.contactus']['tab'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.contactus']['backtolist'] }} </button>
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
                    url: "/api/contactus_image",
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
                contactus: {},
                form: new Form(
                    {
                        id: '',
                        name: '',
                        email: '',
                        phone: '',
                        message: '',
                        response: '',
                        responsed: '0'
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
                    url: "/api/contactus_image",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/contactus/thumbs/"+result.data.data; // Get url from response
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

            getResults(page = 1) {
                axios.get('/api/contactus?page=' + page)
                    .then(response => {
                        this.contactus = response.data;
                    });
            },

            updatecontactus() {
                this.$Progress.start();

                //console.log('editing data');
                this.form.responsed=1;
                this.form.put('/api/contactus/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'contactus has been updated',
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
            editForm(contactus) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.form.reset();﻿
                this.form.fill(contactus);
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;

                this.form.reset();﻿
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deletecontactus(id) {

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
                        this.form.delete('/api/contactus/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'contactus has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadcontactus() {
                axios.get('/api/contactus').then(({ data})=> (this.contactus=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findcontactus?q=' + query)
                    .then((data) => {
                        this.contactus = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadcontactus();

            Fire.$on('AfterCreate',() => {
                this.loadcontactus();

                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            })
        }
    }
</script>