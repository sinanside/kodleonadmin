<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header mt-2" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.pages']['contactpage1'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.contact']['title'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="row mt-2" v-if="$gate.isAdmin()">

            <!-- tab -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">{{ $trans[lang+'.contact']['summary'] }}</a></li>
                            <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">{{ $trans[lang+'.contact']['update'] }}</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="activity">
                                <h3 class="text-center">{{ $trans[lang+'.contact']['showcontactinfo'] }}</h3>

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>
                                            {{this.form.address}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone 1:</strong></td>
                                        <td>
                                            {{this.form.phone1}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone 2:</strong></td>
                                        <td>
                                            {{this.form.phone2}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gsm:</strong></td>
                                        <td>
                                            {{this.form.gsm}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fax:</strong></td>
                                        <td>
                                            {{this.form.fax}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>
                                            {{this.form.email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Map:</strong></td>
                                        <td>
                                            {{this.form.map}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Host:</strong></td>
                                        <td>
                                            {{this.form.host}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 1</strong></td>
                                        <td>
                                            {{this.form.port}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 2</strong></td>
                                        <td>
                                            {{this.form.smtpsecure}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 3</strong></td>
                                        <td>
                                            {{this.form.username}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 4</strong></td>
                                        <td>
                                            {{this.form.password}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 5</strong></td>
                                        <td>
                                            {{this.form.gmail}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 6</strong></td>
                                        <td>
                                            {{this.form.gisim}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $trans[lang+'.pages']['short_description'] }} 7:</strong></td>
                                        <td>
                                            {{this.form.subject}}
                                        </td>
                                    </tr>
                                    </tbody></table>


                            </div>
                            <!-- Setting Tab -->
                            <div class="tab-pane active show" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputAddress" class="col-sm-2 control-label">Address Line 1:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.address" class="form-control" id="inputAddress" placeholder="Address" :class="{ 'is-invalid': form.errors.has('address') }">
                                            <has-error :form="form" field="address"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPhone1" class="col-sm-2 control-label">Phone 1</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.phone1" class="form-control" id="inputPhone1" placeholder="Phone 1"  :class="{ 'is-invalid': form.errors.has('phone1') }">
                                            <has-error :form="form" field="phone1"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPhone2" class="col-sm-2 control-label">Phone 2</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.phone2" class="form-control" id="inputPhone2" placeholder="Phone 2"  :class="{ 'is-invalid': form.errors.has('phone2') }">
                                            <has-error :form="form" field="phone2"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputGsm" class="col-sm-2 control-label">Gsm</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.gsm" class="form-control" id="inputGsm" placeholder="Gsm"  :class="{ 'is-invalid': form.errors.has('gsm') }">
                                            <has-error :form="form" field="gsm"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputFax" class="col-sm-2 control-label">Fax</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.fax" class="form-control" id="inputFax" placeholder="Fax"  :class="{ 'is-invalid': form.errors.has('fax') }">
                                            <has-error :form="form" field="fax"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputMap" class="col-sm-2 control-label">Map</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.map" class="form-control" id="inputMap" placeholder="Map"  :class="{ 'is-invalid': form.errors.has('map') }">
                                            <has-error :form="form" field="map"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputHost" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 1</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.host" class="form-control" id="inputHost"  :class="{ 'is-invalid': form.errors.has('host') }">
                                            <has-error :form="form" field="host"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPort" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 2</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.port" class="form-control" id="inputPort" :class="{ 'is-invalid': form.errors.has('port') }">
                                            <has-error :form="form" field="port"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputSmtpsecure" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 3</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.smtpsecure" class="form-control" id="inputSmtpsecure" :class="{ 'is-invalid': form.errors.has('smtpsecure') }">
                                            <has-error :form="form" field="smtpsecure"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputUsername" class="col-sm-2 control-label">{{ $trans[lang+'.pages']['short_description'] }} 4</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.username" class="form-control" id="inputUsername"  :class="{ 'is-invalid': form.errors.has('username') }">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gmailInput" class="col-sm-12 control-label">{{ $trans[lang+'.pages']['short_description'] }} 5</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.gmail" class="form-control" id="gmailInput" :class="{ 'is-invalid': form.errors.has('gmail') }" >
                                            <has-error :form="form" field="gmail"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gnameInput" class="col-sm-12 control-label">{{ $trans[lang+'.pages']['short_description'] }} 6</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.gisim" class="form-control" id="gnameInput" :class="{ 'is-invalid': form.errors.has('gisim') }" >
                                            <has-error :form="form" field="gisim"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="subjectInput" class="col-sm-12 control-label">{{ $trans[lang+'.pages']['short_description'] }} 7</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.subject" class="form-control" id="subjectInput" :class="{ 'is-invalid': form.errors.has('subject') }" >
                                            <has-error :form="form" field="subject"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button @click.prevent="updateInfo" type="submit" class="btn btn-primary">{{ $trans[lang+'.contact']['update'] }}</button>
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

    export default {
        components: {
        },
        data() {
            return {
                lang: this.$lang,

                form: new Form({
                    id: '',
                    address: '',
                    phone1: '',
                    phone2: '',
                    gsm: '',
                    fax: '',
                    email: '',
                    map: '',
                    host: '',
                    port: '',
                    smtpsecure: '',
                    username: '',
                    password: '',
                    gmail: '',
                    gisim: '',
                    subject: '',
                    active: '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('/api/contactinfo')
                    .then(()=>{
                        toast.fire({
                            type: 'success',
                            title: 'Contact info changed successfully'
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
                axios.get("/api/contactinfo")
                    .then(({data}) => (this.form.fill(data)));
            }

    }
</script>