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
                            <li class="breadcrumb-item active">{{ $trans[lang+'.carousel']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.carousel']['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.carousel']['image'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['title1'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['modify'] }}</th>
                            </tr>

                            <tr v-for="carousel,index in carousel.data" :key="carousel.id">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <img v-if="carousel.image" :src="'/img/carousel/thumbs/' + carousel.image" >
                                    <img v-else :src="'/img/nophoto.png'" >

                                </td>
                                <td>{{ carousel.carousel_title }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="carousel.active">{{ $trans[lang+'.carousel']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.carousel']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(carousel.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(carousel.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(carousel)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deletecarousel(carousel.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="carousel" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>



        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active show" href="#picturetab" data-toggle="tab">{{ $trans[lang+'.carousel']['picturetab'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#toptexttab" data-toggle="tab">{{ $trans[lang+'.carousel']['toptexttab'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#middletexttab" data-toggle="tab">{{ $trans[lang+'.carousel']['middletexttab'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#bottomtexttab" data-toggle="tab">{{ $trans[lang+'.carousel']['bottomtexttab'] }}</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- picturetab Tab -->
                            <div class="tab-pane active show" id="picturetab">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['title1'] }}:</strong><br>
                                        <input v-model="form.carousel_title" id="name" type="text" name="carousel_title"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('carousel_title') }">
                                        <has-error :form="form" field="carousel_title"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                        <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig" @vdropzone-complete="carouselimagecomplete"></vue-dropzone>
                                        <input v-model="form.image" id="image" type="text" name="image"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                        <has-error :form="form" field="image"></has-error>
                                        <input v-model="form.image_alt" id="image_alt" type="text" name="image_alt" placeholder="Image alt information"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('image_alt') }">
                                        <has-error :form="form" field="image_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.image" :src="'\/img\/carousel\/thumbs\/'+form.image">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['image'] }} X:</strong><br>
                                        <input v-model="form.image_x" id="image_x" type="text" name="image_x"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('image_x') }">
                                        <has-error :form="form" field="image_x"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['image'] }} Y:</strong><br>
                                        <input v-model="form.image_y" id="image_y" type="text" name="image_y"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('image_y') }">
                                        <has-error :form="form" field="image_y"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['status'] }}:</strong><br>
                                        <select v-model="form.active" id="type" name="active"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                            <option value="1">Active</option>
                                            <option value="0">Passive</option>
                                        </select>
                                        <has-error :form="form" field="active"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecarousel" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcarousel" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- toptexttab Tab -->
                            <div class="tab-pane" id="toptexttab">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['toptext'] }}:</strong><br>
                                        <input v-model="form.top_text" id="top_text" type="text" name="top_text"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('top_text') }">
                                        <has-error :form="form" field="top_text"></has-error>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['topurl'] }}:</strong><br>
                                                <input v-model="form.top_url" id="top_url" type="text" name="top_url"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_url') }">
                                                <has-error :form="form" field="top_url"></has-error>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>X:</strong><br>
                                                <input v-model="form.top_x" id="top_x" type="text" name="top_x"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_x') }">
                                                <has-error :form="form" field="top_x"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y:</strong><br>
                                                <input v-model="form.top_y" id="top_y" type="text" name="top_y"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_y') }">
                                                <has-error :form="form" field="top_y"></has-error>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 1:</strong><br>
                                                <input v-model="form.top_fontsize1" id="top_fontsize1" type="text" name="top_fontsize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontsize1') }">
                                                <has-error :form="form" field="top_fontsize1"></has-error>
                                            </div>
                                        </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <strong>{{ $trans[lang+'.carousel']['size'] }} 2:</strong><br>
                                                    <input v-model="form.top_fontsize2" id="top_fontsize2" type="text" name="top_fontsize2"
                                                           class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontsize2') }">
                                                    <has-error :form="form" field="top_fontsize2"></has-error>
                                                </div>
                                            </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 3:</strong><br>
                                                <input v-model="form.top_fontsize3" id="top_fontsize3" type="text" name="top_fontsize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontsize3') }">
                                                <has-error :form="form" field="top_fontsize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 4:</strong><br>
                                                <input v-model="form.top_fontsize4" id="top_fontsize4" type="text" name="top_fontsize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontsize4') }">
                                                <has-error :form="form" field="top_fontsize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 1:</strong><br>
                                                <input v-model="form.top_linesize1" id="top_linesize1" type="text" name="top_linesize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_linesize1') }">
                                                <has-error :form="form" field="top_linesize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 2:</strong><br>
                                                <input v-model="form.top_linesize2" id="top_linesize2" type="text" name="top_linesize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_linesize2') }">
                                                <has-error :form="form" field="top_linesize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 3:</strong><br>
                                                <input v-model="form.top_linesize3" id="top_linesize3" type="text" name="top_linesize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_linesize3') }">
                                                <has-error :form="form" field="top_linesize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 4:</strong><br>
                                                <input v-model="form.top_linesize4" id="top_linesize4" type="text" name="top_linesize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_linesize4') }">
                                                <has-error :form="form" field="top_linesize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 1:</strong><br>
                                                <input v-model="form.top_fontweight1" id="top_fontweight1" type="text" name="top_fontweight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontweight1') }">
                                                <has-error :form="form" field="top_fontweight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 2:</strong><br>
                                                <input v-model="form.top_fontweight1" id="top_fontweight2" type="text" name="top_fontweight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontweight1') }">
                                                <has-error :form="form" field="top_fontweight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 3:</strong><br>
                                                <input v-model="form.top_fontweight3" id="top_fontweight3" type="text" name="top_fontweight3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontweight3') }">
                                                <has-error :form="form" field="top_fontweight3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 4:</strong><br>
                                                <input v-model="form.top_fontsize4" id="top_fontweight4" type="text" name="top_fontweight4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('top_fontweight4') }">
                                                <has-error :form="form" field="top_fontweight4"></has-error>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecarousel" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcarousel" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- middletexttab Tab -->
                            <div class="tab-pane" id="middletexttab">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['middletext'] }}:</strong><br>
                                        <input v-model="form.middle_text" id="middle_text" type="text" name="middle_text"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('middle_text') }">
                                        <has-error :form="form" field="middle_text"></has-error>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['middleurl'] }}:</strong><br>
                                                <input v-model="form.middle_url" id="middle_url" type="text" name="middle_url"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_url') }">
                                                <has-error :form="form" field="middle_url"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>X:</strong><br>
                                                <input v-model="form.middle_x" id="middle_x" type="text" name="middle_x"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_x') }">
                                                <has-error :form="form" field="middle_x"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y:</strong><br>
                                                <input v-model="form.middle_y" id="middle_y" type="text" name="middle_y"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_y') }">
                                                <has-error :form="form" field="middle_y"></has-error>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 1:</strong><br>
                                                <input v-model="form.middle_fontsize1" id="middle_fontsize1" type="text" name="middle_fontsize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize1') }">
                                                <has-error :form="form" field="middle_fontsize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 2:</strong><br>
                                                <input v-model="form.middle_fontsize2" id="middle_fontsize2" type="text" name="middle_fontsize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize2') }">
                                                <has-error :form="form" field="middle_fontsize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 3:</strong><br>
                                                <input v-model="form.middle_fontsize3" id="middle_fontsize3" type="text" name="middle_fontsize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize3') }">
                                                <has-error :form="form" field="middle_fontsize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 4:</strong><br>
                                                <input v-model="form.middle_fontsize4" id="middle_fontsize4" type="text" name="middle_fontsize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontsize4') }">
                                                <has-error :form="form" field="middle_fontsize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 1:</strong><br>
                                                <input v-model="form.middle_linesize1" id="middle_linesize1" type="text" name="middle_linesize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_linesize1') }">
                                                <has-error :form="form" field="middle_linesize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 2:</strong><br>
                                                <input v-model="form.middle_linesize2" id="middle_linesize2" type="text" name="middle_linesize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_linesize2') }">
                                                <has-error :form="form" field="middle_linesize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 3:</strong><br>
                                                <input v-model="form.middle_linesize3" id="middle_linesize3" type="text" name="middle_linesize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_linesize3') }">
                                                <has-error :form="form" field="middle_linesize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 4:</strong><br>
                                                <input v-model="form.middle_linesize4" id="middle_linesize4" type="text" name="middle_linesize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_linesize4') }">
                                                <has-error :form="form" field="middle_linesize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 1:</strong><br>
                                                <input v-model="form.middle_fontweight1" id="middle_fontweight1" type="text" name="middle_fontweight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight1') }">
                                                <has-error :form="form" field="middle_fontweight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 2:</strong><br>
                                                <input v-model="form.middle_fontweight2" id="middle_fontweight2" type="text" name="middle_fontweight2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight2') }">
                                                <has-error :form="form" field="middle_fontweight2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 3:</strong><br>
                                                <input v-model="form.middle_fontweight3" id="middle_fontweight3" type="text" name="middle_fontweight3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight3') }">
                                                <has-error :form="form" field="middle_fontweight3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 4:</strong><br>
                                                <input v-model="form.middle_fontweight4" id="middle_fontweight4" type="text" name="middle_fontweight4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('middle_fontweight4') }">
                                                <has-error :form="form" field="middle_fontweight4"></has-error>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecarousel" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcarousel" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- bottomtexttab Tab -->
                            <div class="tab-pane" id="bottomtexttab">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <strong>{{ $trans[lang+'.carousel']['bottomtext'] }}:</strong><br>
                                        <input v-model="form.bottom_text" id="bottom_text" type="text" name="bottom_text"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_text') }">
                                        <has-error :form="form" field="bottom_text"></has-error>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['bottomurl'] }}:</strong><br>
                                                <input v-model="form.bottom_url" id="bottom_url" type="text" name="bottom_url"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_url') }">
                                                <has-error :form="form" field="bottom_url"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>X:</strong><br>
                                                <input v-model="form.bottom_x" id="bottom_x" type="text" name="bottom_x"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_x') }">
                                                <has-error :form="form" field="bottom_x"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>Y:</strong><br>
                                                <input v-model="form.bottom_y" id="bottom_y" type="text" name="bottom_y"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_y') }">
                                                <has-error :form="form" field="bottom_y"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 1:</strong><br>
                                                <input v-model="form.bottom_fontsize1" id="bottom_fontsize1" type="text" name="bottom_fontsize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontsize1') }">
                                                <has-error :form="form" field="bottom_fontsize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 2:</strong><br>
                                                <input v-model="form.bottom_fontsize2" id="bottom_fontsize2" type="text" name="bottom_fontsize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontsize2') }">
                                                <has-error :form="form" field="bottom_fontsize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 3:</strong><br>
                                                <input v-model="form.bottom_fontsize3" id="bottom_fontsize3" type="text" name="bottom_fontsize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontsize3') }">
                                                <has-error :form="form" field="bottom_fontsize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['size'] }} 4:</strong><br>
                                                <input v-model="form.bottom_fontsize4" id="bottom_fontsize4" type="text" name="bottom_fontsize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontsize4') }">
                                                <has-error :form="form" field="middle_fontsize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 1:</strong><br>
                                                <input v-model="form.bottom_linesize1" id="bottom_linesize1" type="text" name="bottom_linesize1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_linesize1') }">
                                                <has-error :form="form" field="bottom_linesize1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 2:</strong><br>
                                                <input v-model="form.bottom_linesize2" id="bottom_linesize2" type="text" name="bottom_linesize2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_linesize2') }">
                                                <has-error :form="form" field="bottom_linesize2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 3:</strong><br>
                                                <input v-model="form.bottom_linesize3" id="bottom_linesize3" type="text" name="bottom_linesize3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_linesize3') }">
                                                <has-error :form="form" field="bottom_linesize3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['linesize'] }} 4:</strong><br>
                                                <input v-model="form.bottom_linesize4" id="bottom_linesize4" type="text" name="bottom_linesize4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_linesize4') }">
                                                <has-error :form="form" field="bottom_linesize4"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 1:</strong><br>
                                                <input v-model="form.bottom_fontweight1" id="bottom_fontweight1" type="text" name="bottom_fontweight1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontweight1') }">
                                                <has-error :form="form" field="bottom_fontweight1"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 2:</strong><br>
                                                <input v-model="form.bottom_fontweight2" id="bottom_fontweight2" type="text" name="bottom_fontweight2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontweight2') }">
                                                <has-error :form="form" field="bottom_fontweight2"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 3:</strong><br>
                                                <input v-model="form.bottom_fontweight3" id="bottom_fontweight3" type="text" name="bottom_fontweight3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontweight3') }">
                                                <has-error :form="form" field="bottom_fontweight3"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <strong>{{ $trans[lang+'.carousel']['weight'] }} 4:</strong><br>
                                                <input v-model="form.bottom_fontweight4" id="bottom_fontweight4" type="text" name="bottom_fontweight4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('bottom_fontweight4') }">
                                                <has-error :form="form" field="bottom_fontweight4"></has-error>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updatecarousel" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createcarousel" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.carousel']['backtolist'] }} </button>
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

                imguploadconfig: {
                    url: "/api/carousel_image",
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
                carousel: {},
                form: new Form(
                    {
                        id: '',
                        carousel_title: '',
                        image: '',
                        image_alt: '',
                        image_x: '',
                        image_y: '',
                        top_text: '',
                        top_url: '',
                        top_fontsize1: '',
                        top_fontsize2: '',
                        top_fontsize3: '',
                        top_fontsize4: '',
                        top_linesize1: '',
                        top_linesize2: '',
                        top_linesize3: '',
                        top_linesize4: '',
                        top_fontweight1: '',
                        top_fontweight2: '',
                        top_fontweight3: '',
                        top_fontweight4: '',
                        top_x: '',
                        top_y: '',
                        middle_text: '',
                        middle_url: '',
                        middle_fontsize1: '',
                        middle_fontsize2: '',
                        middle_fontsize3: '',
                        middle_fontsize4: '',
                        middle_linesize1: '',
                        middle_linesize2: '',
                        middle_linesize3: '',
                        middle_linesize4: '',
                        middle_fontweight1: '',
                        middle_fontweight2: '',
                        middle_fontweight3: '',
                        middle_fontweight4: '',
                        middle_x: '',
                        middle_y: '',
                        bottom_text: '',
                        bottom_url: '',
                        bottom_fontsize1: '',
                        bottom_fontsize2: '',
                        bottom_fontsize3: '',
                        bottom_fontsize4: '',
                        bottom_linesize1: '',
                        bottom_linesize2: '',
                        bottom_linesize3: '',
                        bottom_linesize4: '',
                        bottom_fontweight1: '',
                        bottom_fontweight2: '',
                        bottom_fontweight3: '',
                        bottom_fontweight4: '',
                        bottom_x: '',
                        bottom_y: '',
                        order: '',
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
                    url: "/api/carousel_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/carousel/thumbs/"+result.data.data; // Get url from response
                        Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                        console.log("Picture:"+url);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },

            // VUE2 EDITOR IMAGE UPLOAD PLUGİN ENDS

            carouselimagecomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo1:"+response.data);
                this.form.image = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/carousel?page=' + page)
                    .then(response => {
                        this.carousel = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/carouselup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Carousel order updated',
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
                    url: "/api/carouseldown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Carousel order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },


            updatecarousel() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/carousel/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Carousel has been updated',
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
            createcarousel() {
                this.$Progress.start();
                this.form.post('/api/carousel')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Carousel created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(carousel) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone.removeAllFiles();
                this.form.reset();﻿
                this.form.fill(carousel);
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone.removeAllFiles();
                this.form.reset();﻿
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deletecarousel(id) {

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
                        this.form.delete('/api/carousel/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'Carousel has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadcarousel() {
                axios.get('/api/carousel').then(({ data})=> (this.carousel=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findcarousel?q=' + query)
                    .then((data) => {
                        this.carousel = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadcarousel();

            Fire.$on('AfterCreate',() => {
                this.loadcarousel();
            })
        }
    }
</script>