<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.products']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.main']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.products']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.products']['title2'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.socialmedia']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.products']['photo'] }}</th>
                                <th>{{ $trans[lang+'.products']['title1'] }}</th>
                                <th>{{ $trans[lang+'.products']['slug'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['modify'] }}</th>
                            </tr>

                            <tr v-for="products,index in products.data" :key="products.id">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <img v-if="products.photo" :src="'/img/products/thumbs/' + products.photo" >
                                    <img v-else :src="'/img/nophoto.png'" >
                                </td>
                                <td>{{ products.title }}</td>
                                <td>{{ products.slug }}</td>
                                <td>
                                    <span v-show="products.active==1" class="badge badge-success">{{ $trans[lang+'.socialmedia']['active'] }}</span>
                                    <span v-show="products.active==0" class="badge badge-danger">{{ $trans[lang+'.socialmedia']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(products.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(products.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(products)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteproducts(products.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.products']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.products']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateproducts() : createproducts()">
                        <div class="modal-body">

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.extras']['uploadpicture'] }}:</strong><br>
                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="picturecomplete"></vue-dropzone>
                                <input v-model="form.photo" id="photo" type="text" name="picture"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
                                <input type="text" v-model="form.photo_alt" class="form-control" id="photo_alt"  :class="{ 'is-invalid': form.errors.has('photo_alt') }">
                                <has-error :form="form" field="photo_alt"></has-error>
                                <has-error :form="form" field="photo"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.products']['title1'] }}:</strong><br>
                                <input v-model="form.title" id="name" type="text" name="title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.products']['short_description'] }}:</strong><br>
                                <input v-model="form.short_description" id="short_description" type="text" name="short_description"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('short_description') }">
                                <has-error :form="form" field="short_description"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.products']['old_price'] }}:</strong><br>
                                <input v-model="form.old_price" id="old_price" type="text" name="old_price"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('old_price') }">
                                <has-error :form="form" field="old_price"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.products']['new_price'] }}:</strong><br>
                                <input v-model="form.new_price" id="new_price" type="text" name="new_price"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('new_price') }">
                                <has-error :form="form" field="new_price"></has-error>
                            </div>


                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['socialmedia_status'] }}:</strong><br>
                                <select v-model="form.active" id="type" name="active"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                    <option value="1">{{ $trans[lang+'.socialmedia']['active'] }}</option>
                                    <option value="0">{{ $trans[lang+'.socialmedia']['passive'] }}</option>
                                </select>
                                <has-error :form="form" field="active"></has-error>
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
    import vueDropzone from "vue2-dropzone";

    export default {
        data() {
            return {
                lang: this.$lang,

                imguploadconfig: {
                    url: "/api/products_image",
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
                products: {},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        short_description: '',
                        photo: '',
                        photo_alt: '',
                        old_price: '',
                        new_price: '',
                        active: '1'
                    })
            }
        },

        components: {
            vueDropzone
        },
        methods: {
            picturecomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Resim:"+response.data);
                this.form.photo = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/products?page=' + page)
                    .then(response => {
                        this.extras = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/productsup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'products order updated',
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
                    url: "/api/productsdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'products order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updateproducts() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/products/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        swal.fire(
                            'Updated!',
                            'products has been updated',
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
            createproducts() {
                this.$Progress.start();
                this.form.post('/api/products')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'products created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(products) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(products)
            },
            newModal() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deleteproducts(id) {

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
                        this.form.delete('/api/products/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'products has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadproducts() {
                axios.get('/api/products').then(({ data})=> (this.products=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findproducts?q=' + query)
                    .then((data) => {
                        this.products = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadproducts();
            Fire.$on('AfterCreate',() => {
                this.loadproducts();
            })
        }
    }
</script>