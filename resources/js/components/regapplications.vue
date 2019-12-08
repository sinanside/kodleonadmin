<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.regs']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.regs']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.regs']['title'] }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="refresh_records">{{ $trans[lang+'.regs']['refresh'] }} <i class="fas fa-sync fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.regs']['name'] }}</th>
                                <th>{{ $trans[lang+'.regs']['phone'] }}</th>
                                <th>Tür</th>
                                <th>Randevu Tarihi</th>
                                <th>{{ $trans[lang+'.regs']['status'] }}</th>
                                <th>Zaman</th>
                                <th>{{ $trans[lang+'.regs']['modify'] }}</th>

                            </tr>

                            <tr v-for="regs,index in regs.data" :key="regs.id" v-bind:class="{ 'table-info': regs.reads==0 }">
                                <td>{{ index+1 }}</td>
                                <td>{{ regs.name }}</td>
                                <td>{{ regs.phone }}</td>
                                <td>{{ regs.type }}</td>
                                <td>{{ regs.regdate }}</td>
                                <td>
                                    <span v-show="regs.status==1" class="badge badge-success">{{ $trans[lang+'.regs']['active'] }}</span>
                                    <span v-show="regs.status==0" class="badge badge-danger">{{ $trans[lang+'.regs']['passive'] }}</span>
                                </td>
                                <td>{{ regs.created_at  | moment("add", "3 hours","DD-MM-YYYY, h:mm:ss a") }}</td>
                                <td>
                                    <a href="#" @click="editModal(regs)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteregs(regs.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="regs" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true" v-if="$gate.isAdmin()">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="editmode" id="addNewModalLabel">{{ $trans[lang+'.regs']['update'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateregs()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ $trans[lang+'.regs']['name'] }}:</label>
                                <div class="col-sm-12">
                                <input v-model="form.name" id="name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ $trans[lang+'.regs']['phone'] }}:</label>
                                <div class="col-sm-12">
                                <input v-model="form.phone" id="top_text" type="text" name="phone"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tür:</label>
                                <div class="col-sm-12">
                                <input v-model="form.type" id="middle_text" type="text" name="type"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <has-error :form="form" field="type"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Randevu Tarihi:</label>
                                <div class="col-sm-12">
                                    <select v-model="form.regdate" class="form-control" :class="{ 'is-invalid': form.errors.has('regdate') }">
                                        <option value="randevu">Randevu</option>
                                        <option value="soru">Soru</option>
                                        <option value="sikayet">Şikayet</option>
                                    </select>
                                    <has-error :form="form" field="regdate"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ $trans[lang+'.regs']['status'] }}:</label>
                                <div class="col-sm-12">
                                <select v-model="form.status" id="type" name="status"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                                    <option value="1">{{ $trans[lang+'.regs']['active'] }}</option>
                                    <option value="0">{{ $trans[lang+'.regs']['passive'] }}</option>
                                </select>
                                <has-error :form="form" field="status"></has-error>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button :disabled="form.busy" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">{{ $trans[lang+'.regs']['update1'] }}</button>
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
                regs: {},
                cities: {},
                form: new Form(
                    {
                        id: '',
                        name: '',
                        phone: '',
                        email: '',
                        city_id: '0',
                        town: '',
                        reads: '',
                        status: '0'
                    })
            }
        },

        components: {
        },
        methods: {

            getResults(page = 1) {
                axios.get('/api/regs?page=' + page)
                    .then(response => {
                        this.regs = response.data;
                    });
            },
            refresh_records() {
                this.loadregs();
                this.updateread();
            },
            updateregs() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/regs/'+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        toast.fire(
                            'Updated!',
                            'Regs has been updated',
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
            editModal(regs) {
                this.editmode = true;
                this.form.reset();﻿
                $('#addNew').modal('show');
                this.form.fill(regs);
                this.loadcities();
            },
            deleteregs(id) {

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
                        this.form.delete('/api/regs/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Regs has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                            this.loadregs();

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadregs() {
                axios.get('/api/regs').then(({ data})=> (this.regs=data));
            },
            updateread() {
                axios.get('/api/regsread');
            },
            loadcities() {
                axios.get('/api/allcities').then(({ data})=> (this.cities=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findregs?q=' + query)
                    .then((data) => {
                        this.regs = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadregs();
            this.updateread();

            Fire.$on('AfterCreate',() => {
                this.loadregs();
            })
        }
    }
</script>
