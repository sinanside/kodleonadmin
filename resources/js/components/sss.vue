<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.sss']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.sss']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.sss']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.sss']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                        <div class="card-tools px-1">
                            <select v-model="form.language2" @change="loadSssbylang(form.language2)" class="form-control" id="language2">
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
                                <th>{{ $trans[lang+'.sss']['question'] }}</th>
                                <th>{{ $trans[lang+'.sss']['answer'] }}</th>
                                <th>Dil</th>
                                <th>{{ $trans[lang+'.sss']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.sss']['modify'] }}</th>
                            </tr>

                            <tr v-for="sss,index in sss.data" :key="sss.id">
                                <td>{{ index+1 }}</td>
                                <td v-html="sss.question">{{ sss.question }}</td>
                                <td  v-html="sss.answer">{{ sss.answer }}</td>
                                <td>{{ sss.localization.title }}</td>
                                <td>
                                    <span v-show="sss.active==1" class="badge badge-success" >{{ $trans[lang+'.sss']['active'] }}</span>
                                    <span v-show="sss.active==0" class="badge badge-danger" >{{ $trans[lang+'.sss']['passive'] }}</span>
                                </td>
                                <td style="width: 90px;">
                                    <a href="#" @click="uprecords(sss.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(sss.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td style="width: 90px;">
                                    <a href="#" @click="editModal(sss)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteSss(sss.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="sss" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.sss']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.sss']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateSss() : createSss()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="language" class="col-sm-2 control-label">Dil:</label>

                                <div class="col-sm-12">
                                    <select v-model="form.language" class="form-control" :class="{ 'is-invalid': form.errors.has('language') }">
                                        <option value="0">Dil Seç</option>
                                        <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                            {{ localization.title }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="localization"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">{{ $trans[lang+'.sss']['question'] }}</label>

                                <div class="col-sm-12">
                                    <input type="" v-model="form.question" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('question') }">
                                    <has-error :form="form" field="question"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="answer" class="col-sm-2 control-label">{{ $trans[lang+'.sss']['answer'] }}</label>

                                <div class="col-sm-12">
                                    <vue-editor :editorOptions="editorSettings"
                                                useCustomImageHandler
                                                @imageAdded="handleImageAdded"
                                                id="sss_editor2"
                                                v-model="form.answer">
                                    </vue-editor>
                                    <has-error :form="form" field="answer"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.sss']['status'] }}:</strong><br>
                                <select v-model="form.active" id="type" name="active"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                    <option value="1">{{ $trans[lang+'.sss']['active'] }}</option>
                                    <option value="0">{{ $trans[lang+'.sss']['passive'] }}</option>
                                </select>
                                <has-error :form="form" field="active"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">{{ $trans[lang+'.sss']['close'] }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.sss']['update'] }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.sss']['create'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { VueEditor, Quill } from "vue2-editor";
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module";
    import axios from "axios";

    Quill.register("modules/imageDrop", ImageDrop);
    Quill.register("modules/imageResize", ImageResize);

    export default {
        components: {
            VueEditor
        },
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

            editmode: false,
            sss: {},
            localizations:{},
             tmplang:'',
                form: new Form(
                {
                    id: '',
                    language:'',
                    language2:'0',
                    question: '',
                    answer: '',
                    active: '1'

                })
            }
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
                    url: "/api/sss_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/sss/thumbs/"+result.data.data; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                        console.log("Picture:"+url);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            // VUE2 EDITOR IMAGE UPLOAD PLUGİN ENDS

            getResults(page = 1) {
                axios.get('/api/sss?page=' + page)
                    .then(response => {
                        this.sss = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/sssup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Sss order updated',
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
                    url: "/api/sssdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Sss order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            updateSss() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/sss/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'Sss has been updated',
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
            createSss() {
                this.$Progress.start();
                this.form.post('/api/sss')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'sss created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(sss) {
                this.editmode = true;
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                $('#addNew').modal('show');
                this.form.fill(sss);
                this.form.language2=this.form.language;
            },
            newModal() {
                this.editmode = false;
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.language2=this.form.language;
                $('#addNew').modal('show');
            },
            deleteSss(id) {

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
                        this.form.delete('/api/sss/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Sss has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadSss() {
                axios.get('/api/sss').then(({ data})=> (this.sss=data));
            },
            loadLocalization() {
                axios.get('/api/localizations').then(({ data})=> (this.localizations=data));
            },
            loadSssbylang(id) {
                axios.get('/api/sssbylang/'+id).then(({ data})=> (this.sss=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findSss?q=' + query)
                    .then((data) => {
                        this.sss = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadSss();
            this.loadLocalization();
            Fire.$on('AfterCreate',() => {
                this.loadSssbylang(this.form.language2);
                this.loadSss();
            })
        }
    }
</script>
