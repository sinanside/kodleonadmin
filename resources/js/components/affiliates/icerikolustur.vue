<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Şubeler</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">Şubeler</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Şube Listesi</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                        <div class="card-tools px-1">
                            <select v-model="form.language2" @change="loadpostsbylang(form.language2)" class="form-control" id="language2">
                                <option value="0" disabled>Dil Seç</option>
                                <option v-if="localizations.length > 0" v-for="localization in localizations" v-bind:value="localization.id">
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
                                <th>Tanım</th>
                                <th>Dil</th>
                                <th>Durum</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                            </tr>

                            <tr v-for="posts,index in posts.data" :key="posts.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ posts.name }}</td>
                                 <td><img style="width: 25px; height: 25px;" :src="'\/img\/languages\/thumbs\/'+posts.localization.image"></td>
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
                            <li class="nav-item"><a class="nav-link" href="#shortdescription" data-toggle="tab">{{ $trans[lang+'.pages']['short_descriptions'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pictures" data-toggle="tab">{{ $trans[lang+'.blog']['pictures'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#detailed" data-toggle="tab">{{ $trans[lang+'.blog']['detailed_content'] }}</a></li>
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
                                                <option value="0" disabled>Dil Seç</option>
                                                <option v-if="localizations.length > 0" v-for="localization in localizations" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="language"></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">{{ $trans[lang+'.blog']['title1'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="text" v-model="form.name" class="form-control" id="name"  :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="city" class="col-sm-2 control-label">Şehir:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.city" class="form-control" id="city"  :class="{ 'is-invalid': form.errors.has('city') }">
                                            <has-error :form="form" field="city"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="region" class="col-sm-2 control-label">Bölge:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.region" class="form-control" id="region"  :class="{ 'is-invalid': form.errors.has('region') }">
                                            <has-error :form="form" field="region"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Adres:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.address" class="form-control" id="address" :class="{ 'is-invalid': form.errors.has('address') }">
                                            <has-error :form="form" field="address"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tel" class="col-sm-2 control-label">Tel:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.tel" class="form-control" id="tel" :class="{ 'is-invalid': form.errors.has('tel') }">
                                            <has-error :form="form" field="tel"></has-error>
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
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Şube Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">

                                <div class="alert alert-info" role="alert">
                                    <strong>Bilgi:</strong> Sayfanızın belirli yerlerlindeki kısa yazıları buradan değiştirebilirsiniz.
                                </div>

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description1" class="form-control" id="short_description1"  :class="{ 'is-invalid': form.errors.has('short_description1') }">
                                            <has-error :form="form" field="short_description1"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description2" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 2:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description2" class="form-control" id="short_description2"  :class="{ 'is-invalid': form.errors.has('short_description2') }">
                                            <has-error :form="form" field="short_description2"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description1" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 3:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.short_description3" class="form-control" id="short_description3"  :class="{ 'is-invalid': form.errors.has('short_description3') }">
                                            <has-error :form="form" field="short_description3"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Şube Listesine Dön </button>   </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <div class="tab-pane" id="pictures">

                                <div class="alert alert-info" role="alert">
                                    <strong>Bilgi:</strong> Resim yükleme ikonlarından herbiri farklı resim alanını temsil eder. Örneğin resim 1 için yüklediğiniz resim sayfanızda resim 1 in olduğu konuma gelecektir.
                                </div>

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone1" id="upload1" :options="imguploadconfig1" @vdropzone-complete="picture1complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone2" id="upload2" :options="imguploadconfig2" @vdropzone-complete="picture2complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone3" id="upload3" :options="imguploadconfig3" @vdropzone-complete="picture3complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone4" id="upload4" :options="imguploadconfig4" @vdropzone-complete="picture4complete"></vue-dropzone>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone5" id="upload5" :options="imguploadconfig5" @vdropzone-complete="picture5complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone6" id="upload6" :options="imguploadconfig6" @vdropzone-complete="picture6complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone7" id="upload7" :options="imguploadconfig7" @vdropzone-complete="picture7complete"></vue-dropzone>
                                            </div>
                                            <div class="col-3">
                                                <vue-dropzone  ref="myVueDropzone8" id="upload8" :options="imguploadconfig8" @vdropzone-complete="picture8complete"></vue-dropzone>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture1" :src="'\/img\/affiliates\/thumbs\/'+form.picture1">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture1" id="picture1" type="text" name="picture1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture1') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture2" :src="'\/img\/affiliates\/thumbs\/'+form.picture2">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture2" id="picture2" type="text" name="picture2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture2') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture3" :src="'\/img\/affiliates\/thumbs\/'+form.picture3">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture3" id="picture3" type="text" name="picture3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture3') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture4" :src="'\/img\/affiliates\/thumbs\/'+form.picture4">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture4" id="picture4" type="text" name="picture4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture4') }">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture5" :src="'\/img\/affiliates\/thumbs\/'+form.picture5">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture5" id="picture5" type="text" name="picture5"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture5') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture6" :src="'\/img\/affiliates\/thumbs\/'+form.picture6">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture6" id="picture6" type="text" name="picture6"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture6') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture7" :src="'\/img\/affiliates\/thumbs\/'+form.picture7">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture7" id="picture7" type="text" name="picture7"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture7') }">
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture8" :src="'\/img\/affiliates\/thumbs\/'+form.picture8">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture8" id="picture8" type="text" name="picture8"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture8') }">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Şube Listesine Dön </button>   </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- headerinfo Tab -->
                            <div class="tab-pane" id="detailed">

                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ $trans[lang+'.pages']['detailed_content1'] }}:</label>

                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor :editorOptions="editorSettings"
                                                            useCustomImageHandler
                                                            @imageAdded="handleImageAdded"
                                                            id="mainpage_editor1"
                                                            v-model="form.description1">
                                                </vue-editor>

                                                <has-error :form="form" field="description1"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateposts" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createposts" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Şube Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- shortdescriptions Tab -->
                            <!--<div class="tab-pane" id="eslestir">

                                <div class="alert alert-info" role="alert">
                                    Farklı dillerdeki aynı içerikleri eşleştirmek amacıyla kullanılır. Daha önce yaptığınız eşleştirmeler aşağıda görülmektedir. Yeni eşleştirme yapmak için eşleştireceğiniz içeriği seçip eşleştir butonuna basın.
                                </div>

                                <table class="table table-hover">
                                    <tbody><tr>
                                        <th>#</th>
                                        <th>Dil</th>
                                        <th>İçerik</th>
                                        <th>{{ $trans[lang+'.blog']['modify'] }}</th>
                                    </tr>
                                    <template v-if="eslenikler.data.length > 0" v-for="eslenik,index in eslenikler.data">

                                    <tr :key="eslenik.id" v-bind:class="{ 'bg-info': eslenik.name===form.name }">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ eslenik.localization.title}}</td>
                                        <td>{{ eslenik.name }}</td>
                                        <td v-if="eslenik.name!==form.name">
                                            <a href="#" @click="deleteeslenik(eslenik.id)"><i class="fa fa-trash red"></i></a>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                    </template>
                                    </tbody></table>

                                <h3>Yeni eşleştirme yap</h3>

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="language3" class="col-sm-2 control-label">Dil:</label>

                                        <div class="col-sm-12">
                                            <select @change="loadpostsbylang2(form.language3)" v-model="form.language3" class="form-control" id="language3" :class="{ 'is-invalid': form.errors.has('language3') }">
                                                <option value="0" disabled>Dil Seç</option>
                                                <template v-if="localizations.length > 0" v-for="localization in localizations">
                                                <option v-if="localization.id!==form.language" v-bind:value="localization.id">
                                                    {{ localization.title }}
                                                </option>
                                                </template>
                                            </select>
                                            <has-error :form="form" field="language3"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">İçerik:</label>

                                        <div class="col-sm-12">
                                            <select  v-model="form.icerik2" class="form-control" :class="{ 'is-invalid': form.errors.has('icerik2') }">
                                                <option value="0">İçerik Seç</option>
                                                <option v-if="posts2.length > 0" v-for="post2 in posts2" v-bind:value="post2.id">
                                                    {{ post2.name }}
                                                </option>
                                            </select>
                                            <has-error :form="form" field="icerik2"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  @click.prevent="eslestirmeyap" type="button" class="btn btn-dark"><i class="fas fa-check-double"></i> Eşleştir</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Şube Listesine Dön </button>   </div>
                                    </div>
                                </form>
                            </div>-->
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
                    url: "/api/affiliates_image1",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 1",
                    addRemoveLinks: true
                },
                imguploadconfig2: {
                    url: "/api/affiliates_image2",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 2",
                    addRemoveLinks: true
                },
                imguploadconfig3: {
                    url: "/api/affiliates_image3",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 3",
                    addRemoveLinks: true
                },
                imguploadconfig4: {
                    url: "/api/affiliates_image4",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 4",
                    addRemoveLinks: true
                },
                imguploadconfig5: {
                    url: "/api/affiliates_image5",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 5",
                    addRemoveLinks: true
                },
                imguploadconfig6: {
                    url: "/api/affiliates_image6",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 6",
                    addRemoveLinks: false
                },
                imguploadconfig7: {
                    url: "/api/affiliates_image7",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 7",
                    addRemoveLinks: true
                },
                imguploadconfig8: {
                    url: "/api/affiliates_image8",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 8",
                    addRemoveLinks: true
                },

                editmode: false,
                listmode: true,
                addmode: false,
                localizations:{},
                posts: {},
                tmplang:'',
                form: new Form(
                    {
                        id: '',
                        icerik2:'',
                        language:'',
                        language2:'1',
                        language3:'0',
                        name: '',
                        city: '',
                        region: '',
                        address: '',
                        tel: '',
                        short_description1: '',
                        short_description2: '',
                        short_description3: '',
                        picture1: '',
                        picture2: '',
                        picture3: '',
                        picture4: '',
                        picture5: '',
                        picture6: '',
                        picture7: '',
                        picture8: '',
                        description1: '',
                        description2: '',
                        description3: '',
                        description4: '',
                        description5: '',
                        description6: '',
                        description7: '',
                        description8: '',
                        special_code:'',
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
                    url: "/api/affiliates_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/affiliates/"+result.data.data; // Get url from response
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
                this.form.picture1 = response.data;
            },
            picture2complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo2:"+response.data);
                this.form.picture2 = response.data;
            },
            picture3complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo3:"+response.data);
                this.form.picture3 = response.data;
            },
            picture4complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo4:"+response.data);
                this.form.picture4 = response.data;
            },
            picture5complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo5:"+response.data);
                this.form.picture5= response.data;
            },
            picture6complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo6:"+response.data);
                this.form.picture6= response.data;
            },
            picture7complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo7:"+response.data);
                this.form.picture7= response.data;
            },
            picture8complete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo8:"+response.data);
                this.form.picture8= response.data;
            },

            getResults(page = 1) {
                axios.get('/api/affiliates?page=' + page)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/affiliatesup",
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
                    url: "/api/affiliatesdown",
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
                        toast.fire("Hata","Güncelenirken bir hata meydana geldi.","warning");

                    });

            },

            updateposts() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/affiliates/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Güncellendi!',
                            'İçerik güncellendi.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        toast.fire("Hata","Bir hata oluştu.","warning");

                    });
            },
            createposts() {
                this.$Progress.start();
                this.form.post('/api/affiliates')
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
                            title: 'İçerik başarıyla oluşturulmuştur.'
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
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();
                this.$refs.myVueDropzone5.removeAllFiles();
                this.tmplang=this.form.language2;
                this.form.reset();﻿
                this.form.language = this.tmplang;
                this.form.fill(posts);
                this.form.language3 = 0;
                this.form.language2=this.form.language;
            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();
                this.$refs.myVueDropzone5.removeAllFiles();
                this.$refs.myVueDropzone6.removeAllFiles();
                this.$refs.myVueDropzone7.removeAllFiles();
                this.$refs.myVueDropzone8.removeAllFiles();

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
                    title: 'Emin misiniz??',
                    text: "Bu işlemin geri dönüşü yoktur.!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, silmeyi onaylıyorum!'
                }).then((result) => {

                    if(result.value) {
                        // send ajax request
                        this.form.delete('/api/affiliates/'+id).then(()=>{

                            swal.fire(
                                'Silindi!',
                                'içerik silindi.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Hata","Bir hata meydana geldi","warning");
                        });
                    }
                })

            },
            loadposts() {
                axios.get('/api/affiliates').then(({ data})=> (this.posts=data));
            },
            loadLocalization() {
                axios.get('/api/activelocalizations').then(({ data})=> (this.localizations=data));
            },
            loadpostsbylang(id) {
                axios.get('/api/affiliatesbylang/'+id).then(({ data})=> (this.posts=data));
            },
            loadpostsbylang2(id) {
                axios.get('/api/affiliatesbylang2/'+id).then(({ data})=> (this.posts2=data));
            },

        },

        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findaffiliates?q=' + query)
                    .then((data) => {
                        this.posts = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadpostsbylang(this.form.language2);
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
