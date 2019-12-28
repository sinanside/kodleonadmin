<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Blog Yorumları</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">Blog Yorumları</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Yorum Listesi</h3>

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
                                <th>Makale</th>
                                <th>İsim</th>
                                <th>Dil</th>
                                <th>Durum</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="posts,index in posts.data" :key="posts.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ posts.makale.name }}</td>
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
                                            <select v-model="form.language" id="language" class="form-control" :class="{ 'is-invalid': form.errors.has('language') }">
                                                <option value="0">Dil Seç</option>
                                                <option v-if="localizations.data.length > 0" v-for="localization in localizations.data" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="language"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Makale:</label>

                                        <div class="col-sm-12">
                                            <select  v-model="form.blg_id" class="form-control" :class="{ 'is-invalid': form.errors.has('blg_id') }">
                                                <option value="0">Makale Seç</option>
                                                <option v-if="posts2.length > 0" v-for="post2 in posts2" v-bind:value="post2.id">
                                                    {{ post2.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="blg_id"></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">İsim:</label>

                                        <div class="col-sm-12">
                                            <input type="text" v-model="form.name" class="form-control" id="name"  :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="comment" class="col-sm-2 control-label">Yorum:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.comment" class="form-control" id="comment"  :class="{ 'is-invalid': form.errors.has('comment') }">
                                            <has-error :form="form" field="comment"></has-error>
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
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Yorum Listesine Dön </button>
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
    import axios from "axios";

    export default {
        data() {
            return {
                lang: this.$lang,

                editmode: false,
                listmode: true,
                addmode: false,
                localizations:{},
                posts: {},
                posts2:{},
                tmplang:'',
                form: new Form(
                    {
                        id: '',
                        blg_id:'',
                        language:'',
                        language2:'0',
                        name: '',
                        comment: '',
                        picture1: '',
                        active: '1'
                    })
            }
        },

        methods: {

            getResults(page = 1) {
                axios.get('/api/blogcomments?page=' + page)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/blogcommentsup",
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
                    url: "/api/blogcommentsdown",
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

                this.form.put('/api/blogcomments/'+this.form.id)
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
                this.form.post('/api/blogcomments')
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
                        this.form.delete('/api/blogcomments/'+id).then(()=>{

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
                axios.get('/api/blogcomments').then(({ data})=> (this.posts=data));
            },
            loadLocalization() {
                axios.get('/api/localizations').then(({ data})=> (this.localizations=data));
            },
            loadposts2() {
                axios.get('/api/allicerikler4').then(({ data})=> (this.posts2=data));
            },
            loadpostsbylang(id) {
                axios.get('/api/blogcommentsbylang/'+id).then(({ data})=> (this.posts=data));
            },
        },

        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findBlogcomments?q=' + query)
                    .then((data) => {
                        this.posts = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadposts();
            this.loadposts2();
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
