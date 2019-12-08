<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.carousel']['title'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.carousel']['carouselalt'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.carousel']['carouselalt'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.carousel']['carousel_title'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['title1'] }}</th>
                                <th>{{ $trans[lang+'.blog']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="caruselalt,index in caruselalt.data" :key="caruselalt.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ caruselalt.carousel.carousel_title }}</td>
                                <td>{{ caruselalt.title }}</td>
                                <td>
                                    <span v-show="caruselalt.active==1" class="badge badge-success">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span v-show="caruselalt.active==0" class="badge badge-danger">{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(caruselalt.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(caruselalt.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(caruselalt)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletecaruselalt(caruselalt.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="caruselalt" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>


        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div v-if="carousels.length == 0" class="col-md-12 alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $trans[lang+'.blog']['alert'] }}</h5>
                {{ $trans[lang+'.carousel']['carousel_warning'] }}
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item">{{ $trans[lang+'.carousel']['carouselalt'] }}</li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">

                                <form class="form-horizontal">

                                    <div class="row">
                                        <div class="col-12">
                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['title'] }}:</strong><br>

                                            <select v-model="form.carousel_id" class="form-control" :class="{ 'is-invalid': form.errors.has('carousel_id') }">
                                                <option value="0">{{ $trans[lang+'.carousel']['select_carousel'] }}</option>
                                                <option v-if="carousels.length > 0" v-for="carousel in carousels" v-bind:value="carousel.id">
                                                    {{ carousel.carousel_title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="carousel_id"></has-error>

                                    </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.blog']['title1'] }}:</strong><br>
                                        <input type="" v-model="form.title" class="form-control" id="title"  :class="{ 'is-invalid': form.errors.has('title') }">
                                            <has-error :form="form" field="title"></has-error>
                                    </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['color'] }}:</strong><br>
                                                <input type="" v-model="form.color" class="form-control" id="color"  :class="{ 'is-invalid': form.errors.has('color') }">
                                                <has-error :form="form" field="color"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['delay'] }}:</strong><br>
                                                <input type="" v-model="form.delay" class="form-control" id="delay"  :class="{ 'is-invalid': form.errors.has('delay') }">
                                                <has-error :form="form" field="delay"></has-error>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <strong>X 1:</strong><br>
                                            <input v-model="form.x1" id="x1" type="text" name="x1"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('x1') }">
                                            <has-error :form="form" field="x1"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <strong>X 2:</strong><br>
                                            <input v-model="form.x2" id="x2" type="text" name="x2"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('x2') }">
                                            <has-error :form="form" field="x2"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <strong>X 3:</strong><br>
                                            <input v-model="form.x3" id="x3" type="text" name="x3"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('x3') }">
                                            <has-error :form="form" field="x3"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <strong>X 4:</strong><br>
                                            <input v-model="form.x4" id="x4" type="text" name="x4"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('x4') }">
                                            <has-error :form="form" field="x4"></has-error>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y 1:</strong><br>
                                                <input v-model="form.y1" id="y1" type="text" name="y1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('y1') }">
                                                <has-error :form="form" field="y1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y 2:</strong><br>
                                                <input v-model="form.y2" id="y2" type="text" name="y2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('y2') }">
                                                <has-error :form="form" field="y2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y 3:</strong><br>
                                                <input v-model="form.y3" id="y3" type="text" name="y3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('y3') }">
                                                <has-error :form="form" field="y3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y 4:</strong><br>
                                                <input v-model="form.y4" id="y4" type="text" name="y4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('y4') }">
                                                <has-error :form="form" field="y4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 1:</strong><br>
                                                <input v-model="form.fontsize1" id="middle_fontsize1" type="text" name="middle_fontsize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize1') }">
                                                <has-error :form="form" field="middle_fontsize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 2:</strong><br>
                                                <input v-model="form.fontsize2" id="middle_fontsize2" type="text" name="middle_fontsize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize2') }">
                                                <has-error :form="form" field="middle_fontsize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 3:</strong><br>
                                                <input v-model="form.fontsize3" id="middle_fontsize3" type="text" name="middle_fontsize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize3') }">
                                                <has-error :form="form" field="middle_fontsize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 4:</strong><br>
                                                <input v-model="form.fontsize4" id="middle_fontsize4" type="text" name="middle_fontsize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize4') }">
                                                <has-error :form="form" field="middle_fontsize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 1:</strong><br>
                                                <input v-model="form.lineheight1" id="lineheight1" type="text" name="lineheight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('lineheight1') }">
                                                <has-error :form="form" field="lineheight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 2:</strong><br>
                                                <input v-model="form.lineheight2" id="lineheight2" type="text" name="lineheight2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('lineheight2') }">
                                                <has-error :form="form" field="lineheight2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 3:</strong><br>
                                                <input v-model="form.lineheight3" id="lineheight3" type="text" name="lineheight3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('lineheight3') }">
                                                <has-error :form="form" field="lineheight3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 4:</strong><br>
                                                <input v-model="form.lineheight4" id="lineheight4" type="text" name="lineheight4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('lineheight4') }">
                                                <has-error :form="form" field="lineheight4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 1:</strong><br>
                                                <input v-model="form.fontweight1" id="middle_fontweight1" type="text" name="middle_fontweight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight1') }">
                                                <has-error :form="form" field="middle_fontweight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 2:</strong><br>
                                                <input v-model="form.fontweight2" id="middle_fontweight2" type="text" name="middle_fontweight2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight2') }">
                                                <has-error :form="form" field="middle_fontweight2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 3:</strong><br>
                                                <input v-model="form.fontweight3" id="middle_fontweight3" type="text" name="middle_fontweight3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight3') }">
                                                <has-error :form="form" field="middle_fontweight3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 4:</strong><br>
                                                <input v-model="form.fontweight4" id="middle_fontweight4" type="text" name="middle_fontweight4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight4') }">
                                                <has-error :form="form" field="middle_fontweight4"></has-error>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-3">

                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['visibility'] }} 1:</strong><br>
                                                <select v-model="form.visibility1" id="visibility1" name="visibility1"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('visibility1') }">
                                                    <option value="on">{{ $trans[lang+'.blog']['active'] }}</option>
                                                    <option value="off">{{ $trans[lang+'.blog']['passive'] }}</option>
                                                </select>
                                                <has-error :form="form" field="visibility1"></has-error>
                                            </div>
                                        </div>

                                        <div class="col-3">

                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['visibility'] }} 2:</strong><br>
                                                <select v-model="form.visibility2" id="visibility2" name="visibility1"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('visibility2') }">
                                                    <option value="on">{{ $trans[lang+'.blog']['active'] }}</option>
                                                    <option value="off">{{ $trans[lang+'.blog']['passive'] }}</option>
                                                </select>
                                                <has-error :form="form" field="visibility2"></has-error>
                                            </div>
                                        </div>

                                        <div class="col-3">

                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['visibility'] }} 1:</strong><br>
                                                <select v-model="form.visibility3" id="visibility3" name="visibility3"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('visibility3') }">
                                                    <option value="on">{{ $trans[lang+'.blog']['active'] }}</option>
                                                    <option value="off">{{ $trans[lang+'.blog']['passive'] }}</option>
                                                </select>
                                                <has-error :form="form" field="visibility3"></has-error>
                                            </div>
                                        </div>

                                        <div class="col-3">

                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['visibility'] }} 4:</strong><br>
                                                <select v-model="form.visibility4" id="visibility4" name="visibility4"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('visibility4') }">
                                                    <option value="on">{{ $trans[lang+'.blog']['active'] }}</option>
                                                    <option value="off">{{ $trans[lang+'.blog']['passive'] }}</option>
                                                </select>
                                                <has-error :form="form" field="visibility4"></has-error>
                                            </div>
                                        </div>

                                    </div>




                                    <div class="row">
                                        <div class="col-12">

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.blog']['status'] }}:</strong><br>
                                            <select v-model="form.active" id="active" name="active"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                                <option value="1">{{ $trans[lang+'.blog']['active'] }}</option>
                                                <option value="0">{{ $trans[lang+'.blog']['passive'] }}</option>
                                            </select>
                                            <has-error :form="form" field="active"></has-error>
                                    </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecaruselalt" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcaruselalt" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist2'] }} </button>
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
                carousels: {},
                caruselalt: {},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        slug: '',
                        carousel_id: '0',
                        color: '',
                        delay: '',
                        x1: '',
                        x2: '',
                        x3: '',
                        x4: '',
                        y1: '',
                        y2: '',
                        y3: '',
                        y4: '',
                        fontsize1: '',
                        fontsize2: '',
                        fontsize3: '',
                        fontsize4: '',
                        lineheight1: '',
                        lineheight2: '',
                        lineheight3: '',
                        lineheight4: '',
                        fontweight1: '',
                        fontweight2: '',
                        fontweight3: '',
                        fontweight4: '',
                        visibility1: 'on',
                        visibility2: 'on',
                        visibility3: 'on',
                        visibility4: 'on',
                        queue: '',
                        active: '1'
                    })
            }
        },

        components: {

        },
        methods: {

            getResults(page = 1) {
                axios.get('/api/carouselalt?page=' + page)
                    .then(response => {
                        this.caruselalt = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/carouselaltup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'caruselalt order updated',
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
                    url: "/api/carouselaltdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'caruselalt order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            updatecaruselalt() {
                this.$Progress.start();

                this.form.put('/api/carouselalt/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'caruselalt has been updated',
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
            createcaruselalt() {
                this.$Progress.start();
                this.form.post('/api/carouselalt')
                    .then(({ data }) => {
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'caruselalt created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(caruselalt) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.form.reset();﻿
                this.form.fill(caruselalt);
                this.loadcarousels();
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.form.reset();﻿
                this.loadcarousels();
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deletecaruselalt(id) {

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
                        this.form.delete('/api/carouselalt/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'caruselalt has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadcaruselalt() {
                axios.get('/api/carouselalt').then(({ data})=> (this.caruselalt=data));
            },
            loadcarousels() {
                axios.get('/api/allcarousels').then(({ data})=> (this.carousels=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findcarouselalt?q=' + query)
                    .then((data) => {
                        this.caruselalt = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadcaruselalt();

            Fire.$on('AfterCreate',() => {
                this.loadcaruselalt();
            })
        }
    }
</script>