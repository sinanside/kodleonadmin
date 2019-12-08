<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.pages']['pages'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.main']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.pages']['pages'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.pages']['pages'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.socialmedia']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.pages']['name'] }}</th>
                                <th>{{ $trans[lang+'.pages']['slug'] }}</th>
                                <th>{{ $trans[lang+'.pages']['meta_title'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['modify'] }}</th>
                            </tr>

                            <tr v-for="pages,index in pages.data" :key="pages.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ pages.name }}</td>
                                <td>{{ pages.slug }}</td>
                                <td>{{ pages.meta_title }}</td>
                                <td>
                                    <a href="#" @click="uprecords(pages.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(pages.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(pages)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletePages(pages.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="pages" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.pages']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.pages']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updatePages() : createPages()">
                        <div class="modal-body">


                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['name'] }}:</strong><br>
                                <input v-model="form.name" id="name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['meta_title'] }}:</strong><br>
                                <input v-model="form.meta_title" id="meta_title" type="text" name="meta_title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('meta_title') }">
                                <has-error :form="form" field="meta_title"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['meta_description'] }}:</strong><br>
                                <input v-model="form.meta_description" id="meta_description" type="text" name="meta_description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('meta_description') }">
                                <has-error :form="form" field="meta_description"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.pages']['meta_keywords'] }}:</strong><br>
                                <input v-model="form.meta_keywords" id="meta_keywords" type="text" name="meta_keywords"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('meta_keywords') }">
                                <has-error :form="form" field="meta_keywords"></has-error>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">{{ $trans[lang+'.socialmedia']['close'] }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.socialmedia']['update'] }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.socialmedia']['create'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        data() {
            return {
                lang: this.$lang,

                editmode: false,
                pages: {},
                form: new Form(
                    {
                        id: '',
                        name: '',
                        meta_title: '',
                        meta_description: '',
                        meta_keywords: ''
                    })
            }
        },

        components: {
        },
        methods: {

            getResults(page = 1) {
                axios.get('/api/pages?page=' + page)
                    .then(response => {
                        this.pages = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/pagesup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Pages order updated',
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
                    url: "/api/pagesdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Pages order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updatePages() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/pages/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        swal.fire(
                            'Updated!',
                            'Pages has been updated',
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
            createPages() {
                this.$Progress.start();
                this.form.post('/api/pages')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'pages created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(pages) {
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(pages)
            },
            newModal() {
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deletePages(id) {

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
                        this.form.delete('/api/pages/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Pages has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadPages() {
                axios.get('/api/pages').then(({ data})=> (this.pages=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findPages?q=' + query)
                    .then((data) => {
                        this.extras = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadPages();
            Fire.$on('AfterCreate',() => {
                this.loadPages();
            })
        }
    }
</script>