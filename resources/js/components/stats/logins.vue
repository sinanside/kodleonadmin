<template>

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="m-0 text-dark">{{ $trans[lang+'.main']['stats'] }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->


        <div class="row justify-content-center mt-3" v-if="$gate.isUser()">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>{{ $trans[lang+'.main']['newusertitle'] }}</strong></div>

                    <div class="card-body">
                        {{ $trans[lang+'.main']['newusermesssage'] }}
                    </div>

                </div>

            </div>
        </div>

        <div class="row justify-content-center mt-3" v-if="$gate.isAdminOrAuthor()">

            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->

                <!-- /.row -->
                <!-- Main row -->
                <div class="row" v-if="$gate.isAdminOrAuthor()">

                    <section class="col-lg-12 connectedSortable ui-sortable">

                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">
                                    <i class="fas fa-users"></i>
                                    Son Ziyaretçiler
                                </h3>

                            </div><!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Cihaz</th>
                                        <th>Tarayıcı</th>
                                        <th>Ülke/şehir</th>
                                        <th>Kullanıcı</th>
                                        <th>Dil</th>
                                        <th>Sayfa</th>
                                        <th>Son Giriş</th>

                                    </tr>
                                    <tr v-for="dashboard,index in dashboard.data" :key="dashboard.id">


                                        <td>{{ index+1 }}</td>
                                        <td>{{ dashboard.device.kind }}-{{ dashboard.device.platform }} <span v-if="dashboard.device.platform_version">- {{ dashboard.device.platform_version }}</span></td>
                                        <td>{{ dashboard.agent.browser }}</td>
                                        <td  v-if="dashboard.geo_ip">{{ dashboard.geo_ip.country_name }} <span v-if="dashboard.geo_ip.city">- {{ dashboard.geo_ip.city }}</span></td>
                                        <td v-else>{{ dashboard.client_ip }}</td>
                                        <td v-if="dashboard.user">{{ dashboard.user.username }}</td>
                                        <td v-else>Ziyaretçi</td>
                                        <td>{{ dashboard.language.preference }}</td>
                                        <td v-if="dashboard.referer">{{ dashboard.referer.url }}</td>
                                        <td v-else>-</td>
                                        <td>{{ dashboard.updated_at  | moment("add", "3 hours","DD-MM-YYYY, h:mm:ss a") }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <pagination :data="dashboard" @pagination-change-page="getResults"></pagination>
                            </div>
                            <!-- /.card -->


                        </div>
                        <!-- /.card -->


                    </section>


                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->







        </div>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        data() {
            return {
                lang: this.$lang,
                dashboard: {},
                statscountall: '',
                statscountday: '',
                statscountweek: '',
                statscountrecent: '',
            }
        },
        methods: {
            onlineusers() {
                axios.get('/api/dashboard').then(({ data})=> (this.dashboard=data));
            },
            getResults(page = 1) {
                axios.get('/api/dashboard?page=' + page)
                    .then(response => {
                        this.dashboard = response.data;
                    });
            }
        },

        created() {
            this.onlineusers();

            Fire.$on('AfterCreate',() => {
                this.onlineusers();

            })
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
