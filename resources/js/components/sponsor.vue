<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.sponsor']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.main']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.sponsor']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.sponsor']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">{{ $trans[lang+'.sponsor']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.sponsor']['name'] }}</th>
                                <th>{{ $trans[lang+'.sponsor']['url'] }}</th>
                                <th>{{ $trans[lang+'.sponsor']['url2'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['status'] }}</th>
                                <th>{{ $trans[lang+'.socialmedia']['modify'] }}</th>
                            </tr>

                            <tr v-for="sponsor,index in sponsor.data" :key="sponsor.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ sponsor.title }}</td>
                                <td>{{ sponsor.url }}</td>
                                <td>{{ sponsor.url2 }}</td>
                                <td>
                                    <span v-show="sponsor.active==1" class="badge badge-success">{{ $trans[lang+'.socialmedia']['active'] }}</span>
                                    <span v-show="sponsor.active==0" class="badge badge-danger" >{{ $trans[lang+'.socialmedia']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="editModal(sponsor)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteSponsor(sponsor.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="sponsor" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.sponsor']['updateinfo'] }}</h5>
                        <h5 class="modal-title" v-show="!editmode" id="addNewModalLabel2">{{ $trans[lang+'.sponsor']['addinfo'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateSponsor() : createSponsor()">
                        <div class="modal-body">

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.sponsor']['name'] }}:</strong><br>
                                <input v-model="form.title" id="name" type="text" name="title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <strong>{{ $trans[lang+'.sponsor']['url'] }}:</strong><br>
                                <input v-model="form.url" id="url" type="text" name="url"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('url') }">
                                <has-error :form="form" field="url"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.sponsor']['url2'] }}:</strong><br>
                                <input v-model="form.url2" id="url2" type="text" name="url2"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('url2') }">
                                <has-error :form="form" field="url2"></has-error>
                            </div>

                            <div class="form-group">
                                <strong>{{ $trans[lang+'.socialmedia']['socialmedia_status'] }}:</strong><br>
                                <select v-model="form.active" id="active" name="active"
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

    export default {
        data() {
            return {
                lang: this.$lang,

                editmode: false,
                sponsor: {},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        url: '',
                        url2: '',
                        active: '1'
                    })
            }
        },

        methods: {

            getResults(page = 1) {
                axios.get('/api/sponsor?page=' + page)
                    .then(response => {
                        this.sponsor = response.data;
                    });
            },
            updateSponsoractive()
            {
                axios.get('/api/updateSponsoractive/');
            },
            updateSponsor() {
                this.$Progress.start();

                this.form.put('/api/sponsor/'+this.form.id)
                    .then(() => {

                        $('#addNew').modal('hide')
                        swal.fire(
                            'Updated!',
                            'Sponsor has been updated',
                            'success'
                        );

                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        swal.fire("Failed","There was an error","warning");

                    });
            },
            createSponsor() {
                this.$Progress.start();
                this.form.post('/api/sponsor')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'sponsor created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editModal(sponsor) {
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(sponsor)
            },
            newModal() {
                this.editmode = false;
                this.form.reset();﻿
                $('#addNew').modal('show');
            },
            deleteSponsor(id) {

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
                        this.form.delete('/api/sponsor/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Sponsor has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadSponsor() {
                axios.get('/api/sponsor').then(({ data})=> (this.sponsor=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findsponsor?q=' + query)
                    .then((data) => {
                        this.sponsor = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadSponsor();
            Fire.$on('AfterCreate',() => {
                this.loadSponsor();
            })
        }
    }
</script>