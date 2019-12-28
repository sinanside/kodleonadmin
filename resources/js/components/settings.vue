<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="row mt-3" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <h1 class="m-0 text-dark">Ayarlar</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row" v-if="$gate.isAdmin()">

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Özet</a></li>
                            <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Güncelle</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">Ayarları Göster</h3>

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="25%">Key</th>
                                        <th width="75%">Value</th>
                                    </tr>
                                    <tbody>
                                    <tr>
                                        <td><strong>Logo:</strong></td>
                                        <td>
                                            <img v-if="form.logo" :src="'\/img\/logo\/'+form.logo">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Logo Alt:</strong></td>
                                        <td>
                                            {{this.form.logo_alt}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Site İsmi:</strong></td>
                                        <td>
                                            {{this.form.sitename}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Slogan:</strong></td>
                                        <td>
                                            {{this.form.slogan}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Meta Title:</strong></td>
                                        <td>
                                            {{this.form.main_title}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Meta Description:</strong></td>
                                        <td>
                                            {{this.form.main_description}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Meta Keywords:</strong></td>
                                        <td>
                                            {{this.form.main_keywords}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Site Adresi:</strong></td>
                                        <td>
                                            {{this.form.website}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Site Sahibi:</strong></td>
                                        <td>
                                            {{this.form.owner}}
                                        </td>
                                    </tr>

                                    </tbody></table>


                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Logo Yükle:</strong><br>
                                                <vue-dropzone  ref="myVueDropzone1" id="upload" :options="imguploadconfig" @vdropzone-complete="logocomplete"></vue-dropzone>
                                                <input v-model="form.logo" id="logo" type="text" name="logo"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('logo') }">
                                                <has-error :form="form" field="logo"></has-error>

                                                <input type="text" v-model="form.logo_alt" class="form-control" id="logo_alt" placeholder="Logo alt information"  :class="{ 'is-invalid': form.errors.has('logo_alt') }">
                                                <has-error :form="form" field="logo_alt"></has-error>
                                            </div>
                                            <div class="col-6">
                                                <strong>Preview:</strong><br>
                                                <img v-if="form.logo" :src="'\/img\/logo\/'+form.logo">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sitename" class="col-sm-2 control-label">Site İsmi</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.sitename" class="form-control" id="sitename"   :class="{ 'is-invalid': form.errors.has('sitename') }">
                                            <has-error :form="form" field="sitename"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slogan" class="col-sm-2 control-label">Slogan</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.slogan" class="form-control" id="slogan" :class="{ 'is-invalid': form.errors.has('slogan') }">
                                            <has-error :form="form" field="slogan"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="main_title" class="col-sm-2 control-label">Meta Title</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.main_title" class="form-control" id="main_title"  :class="{ 'is-invalid': form.errors.has('main_title') }">
                                            <has-error :form="form" field="main_title"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="main_description" class="col-sm-2 control-label">Meta Description</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.main_description" class="form-control" id="main_description"  :class="{ 'is-invalid': form.errors.has('main_description') }">
                                            <has-error :form="form" field="main_description"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="main_keywords" class="col-sm-2 control-label">Meta Keywords</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.main_keywords" class="form-control" id="main_keywords"  :class="{ 'is-invalid': form.errors.has('main_keywords') }">
                                            <has-error :form="form" field="main_keywords"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="website" class="col-sm-2 control-label">Site Adresi</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.website" class="form-control" id="website" :class="{ 'is-invalid': form.errors.has('website') }">
                                            <has-error :form="form" field="website"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="owner" class="col-sm-2 control-label">Sahibi</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.owner" class="form-control" id="owner"  :class="{ 'is-invalid': form.errors.has('owner') }">
                                            <has-error :form="form" field="owner"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Güncelle</button>
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

    export default {
        components: {
            vueDropzone
        },
        data() {
            return {
                imguploadconfig: {
                    url: "/api/settings_image",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD LOGO",
                    addRemoveLinks: true
                },
                form: new Form({
                    id: '',
                    logo: '',
                    logo_alt: '',
                    sitename: '',
                    slogan: '',
                    main_title: '',
                    main_description: '',
                    main_keywords: '',
                    website: '',
                    owner: '',
                    active: '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            logocomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("logo:"+response.data);
                this.form.logo = response.data;
            },
                updateInfo(){
                this.$Progress.start();
                this.form.put('/api/settings')
                    .then(()=>{
                        toast.fire({
                            type: 'success',
                            title: 'Settings changed successfully'
                        });
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            }
        },
        created() {
            axios.get("/api/settings")
                .then(({data}) => (this.form.fill(data)));
        }

    }
</script>
