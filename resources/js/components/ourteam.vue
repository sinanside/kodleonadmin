<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.pages']['pages'] }} - <small>{{ $trans[lang+'.main']['ourteam'] }}</small></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $trans[lang+'.pages']['pages'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.main']['ourteam'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.main']['ourteam'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.ourteam']['job'] }}</th>
                                <th>{{ $trans[lang+'.ourteam']['title1'] }}</th>
                                <th>{{ $trans[lang+'.ourteam']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.ourteam']['modify'] }}</th>
                            </tr>

                            <tr v-for="ourteam,index in ourteam.data" :key="ourteam.id">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <span class="badge badge-primary" v-if="ourteam.type==1">{{ $trans[lang+'.ourteam']['type1'] }}</span>
                                    <span class="badge badge-dark" v-else-if="ourteam.type==2">{{ $trans[lang+'.ourteam']['type2'] }}</span>
                                    <span class="badge badge-warning" v-else>-</span>

                                </td>
                                <td>{{ ourteam.title }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="ourteam.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(ourteam.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(ourteam.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(ourteam)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteourteam(ourteam.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="ourteam" @pagination-change-page="getResults"></pagination>
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
                            <li class="nav-item"><a class="nav-link" href="#shortdescription" data-toggle="tab">{{ $trans[lang+'.pages']['short_descriptions'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pictures" data-toggle="tab">{{ $trans[lang+'.blog']['pictures'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#detailed" data-toggle="tab">{{ $trans[lang+'.blog']['detailed_content'] }}</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="summary">
                                <h3 class="text-center">{{ $trans[lang+'.blog']['ourteam_info'] }}</h3>

                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Model:</strong> App\Ourteam<br>
                                    <strong>Usage:</strong> Ourteam::where('slug', '=', $slug)->firstOrFail();
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
                                            {{this.form.title}}
                                        </td>
                                        <td>title</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><strong>{{ $trans[lang+'.blog']['slug'] }} (Slug)</strong></td>
                                        <td>
                                            {{this.form.slug}}
                                        </td>
                                        <td>slug</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><strong>{{ $trans[lang+'.blog']['meta_title'] }}</strong></td>
                                        <td>
                                            {{this.form.meta_title}}
                                        </td>
                                        <td>meta_title</td>
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
                                        <td>5</td>
                                        <td><strong>{{ $trans[lang+'.blog']['meta_keywords'] }}</strong></td>
                                        <td>
                                            {{this.form.meta_keywords}}
                                        </td>
                                        <td>meta_keywords</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td><strong>{{ $trans[lang+'.ourteam']['job'] }}</strong></td>
                                        <td>
                                            <span class="badge badge-primary" v-if="form.type==1">{{ $trans[lang+'.ourteam']['type1'] }}</span>
                                            <span class="badge badge-dark" v-else-if="form.type==2">{{ $trans[lang+'.ourteam']['type2'] }}</span>
                                            <span class="badge badge-warning" v-else>-</span>
                                        </td>
                                        <td>mainpage</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><strong>{{ $trans[lang+'.blog']['status'] }}</strong></td>
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
                                            <img v-if="form.photo1" :src="'\/img/ourteam/thumbs\/'+form.photo1">
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
                                            <img v-if="form.photo2" :src="'\/img\/ourteam\/thumbs\/'+form.photo2">
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
                                            <img v-if="form.picture3" :src="'\/img/ourteam/thumbs\/'+form.picture3">
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
                                        <td>-</td>
                                        <td>short_content</td>
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
                                        <label for="title" class="col-sm-2 control-label">{{ $trans[lang+'.blog']['title1'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.title" class="form-control" id="title"  :class="{ 'is-invalid': form.errors.has('title') }">
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_title'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_title" class="form-control" id="meta_title"  :class="{ 'is-invalid': form.errors.has('meta_title') }">
                                            <has-error :form="form" field="meta_title"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_description'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_description" class="form-control" id="meta_description"  :class="{ 'is-invalid': form.errors.has('meta_description') }">
                                            <has-error :form="form" field="meta_description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['meta_keywords'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.meta_keywords" class="form-control" id="meta_keywords" :class="{ 'is-invalid': form.errors.has('meta_keywords') }">
                                            <has-error :form="form" field="meta_keywords"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="type" class="col-sm-2 control-label">{{ $trans[lang+'.ourteam']['job'] }}:</label>
                                        <div class="col-sm-12">
                                            <select v-model="form.type" id="type" name="type"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                                <option value="1">{{ $trans[lang+'.ourteam']['type1'] }}</option>
                                                <option value="2">{{ $trans[lang+'.ourteam']['type2'] }}</option>
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
                                            <button  v-if="editmode"  @click.prevent="updateourteam" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createourteam" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.ourteam']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.description1" class="form-control" id="description1"  :class="{ 'is-invalid': form.errors.has('description1') }">
                                            <has-error :form="form" field="description1"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description2" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 2:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.description2" class="form-control" id="description2"  :class="{ 'is-invalid': form.errors.has('description2') }">
                                            <has-error :form="form" field="description2"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description3" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 3:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.description3" class="form-control" id="description3"  :class="{ 'is-invalid': form.errors.has('description3') }">
                                            <has-error :form="form" field="description3"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description4" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 4:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.description4" class="form-control" id="description4"  :class="{ 'is-invalid': form.errors.has('description4') }">
                                            <has-error :form="form" field="description4"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-12">
                                        <button @click.prevent="updateourteam" type="submit" class="btn btn-primary">{{ $trans[lang+'.pages']['update'] }}</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- pictures Tab -->
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
                                                <img v-if="form.photo1" :src="'\/img\/ourteam\/thumbs\/'+form.photo1">
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
                                                <img v-if="form.photo2" :src="'\/img\/ourteam\/thumbs\/'+form.photo2">
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
                                                <img v-if="form.photo3" :src="'\/img\/ourteam\/thumbs\/'+form.photo3">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['upload_picture4'] }}:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone4" id="upload4" :options="imguploadconfig4" @vdropzone-complete="picture4complete"></vue-dropzone>
                                                <input v-model="form.photo4" id="picture4" type="text" name="photo4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('photo4') }">
                                                <has-error :form="form" field="photo4"></has-error>

                                                <input type="text" v-model="form.photo4_alt" class="form-control" id="photo4_alt"  :class="{ 'is-invalid': form.errors.has('photo4_alt') }">
                                                <has-error :form="form" field="photo4_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.photo4" :src="'\/img\/ourteam\/thumbs\/'+form.photo4">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateourteam" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createourteam" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.ourteam']['backtolist'] }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- headerinfo Tab -->
                            <div class="tab-pane" id="detailed">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.blog']['short_content'] }}</label>

                                        <div class="col-sm-12" id="test">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor1"
                                                        v-model="form.short_content">
                                            </vue-editor>
                                            <has-error :form="form" field="short_content"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-2 control-label">{{ $trans[lang+'.blog']['content'] }}</label>

                                        <div class="col-sm-12">
                                            <vue-editor :editorOptions="editorSettings"
                                                        useCustomImageHandler
                                                        @imageAdded="handleImageAdded"
                                                        id="editor2"
                                                        v-model="form.content">
                                            </vue-editor>
                                            <has-error :form="form" field="content"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateourteam" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createourteam" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> {{ $trans[lang+'.ourteam']['backtolist'] }} </button>
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
                    url: "/api/ourteam_image1",
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
                    url: "/api/ourteam_image2",
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
                    url: "/api/ourteam_image3",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 5, // MB
                    maxFiles: 1,
                    chunking: true,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                    addRemoveLinks: true
                },
                imguploadconfig4: {
                    url: "/api/ourteam_image4",
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
                ourteam: {},
                form: new Form(
                    {
                        id: '',
                        title: '',
                        slug: '',
                        type: '1',
                        meta_title: '',
                        meta_description: '',
                        meta_keywords: '',
                        description1: '',
                        description2: '',
                        description3: '',
                        description4: '',
                        short_content: '',
                        content: '',
                        photo1: '',
                        photo1_alt: '',
                        photo2: '',
                        photo2_alt: '',
                        photo3: '',
                        photo3_alt: '',
                        photo4: '',
                        photo4_alt: '',
                        queue: '',
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
                    url: "/api/ourteam_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/ourteam/thumbs/"+result.data.data; // Get url from response
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
            picture4complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo4:"+response.data);
                this.form.photo4 = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/ourteam?page=' + page)
                    .then(response => {
                        this.ourteam = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/ourteamup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Ourteam order updated',
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
                    url: "/api/ourteamdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'Ourteam order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            updateourteam() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/ourteam/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'ourteam has been updated',
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
            createourteam() {
                this.$Progress.start();
                this.form.post('/api/ourteam')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'ourteam created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(ourteam) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();
                this.form.reset();﻿
                this.form.fill(ourteam);
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();

                this.form.reset();﻿
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deleteourteam(id) {

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
                        this.form.delete('/api/ourteam/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'ourteam has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadourteam() {
                axios.get('/api/ourteam').then(({ data})=> (this.ourteam=data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findourteam?q=' + query)
                    .then((data) => {
                        this.ourteam = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadourteam();

            Fire.$on('AfterCreate',() => {
                this.loadourteam();
            })
        }
    }
</script>
