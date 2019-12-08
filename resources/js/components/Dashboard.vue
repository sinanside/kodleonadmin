<template>

    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="m-0 text-dark">{{ $trans[lang+'.main']['dashboard'] }}</h1>
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
                    <div class="row">
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ statscountrecent }}</h3>
                                    <p>Aktif Ziyaretçi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-walking"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ statscountday }}</h3>
                                    <p>Günlük Ziyaretçi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ statscountweek }}</h3>

                                    <p>Haftalık Ziyaretçi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-snowboarding"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ statscountall }}</h3>

                                    <p>Toplam Ziyaretçi</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hiking"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row" v-if="$gate.isAdminOrAuthor()">

                        <section class="col-lg-12 connectedSortable ui-sortable">

                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Günlere Göre Girişler</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">

                                <line-chart :chart-data="chartData" :chart-labels="labels"></line-chart>

                                </div>
                            </div>
                        </section>


                        <div class="col-md-6">
                            <!-- Info Boxes Style 2 -->
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Site İsmi</span>
                                    <span class="info-box-number">{{ sitesettings.sitename }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                            <div class="info-box mb-3 bg-info">
                                <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Slogan</span>
                                    <span class="info-box-number">{{ sitesettings.slogan }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->

                        </div>


                        <div class="col-md-6">
                            <!-- /.info-box -->
                            <div class="info-box mb-3 bg-info">
                                <span class="info-box-icon"><i class="fas fa-anchor"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Site Adresi</span>
                                    <span class="info-box-number">{{ sitesettings.website }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-user-secret"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Site Sahibi</span>
                                    <span class="info-box-number">{{ sitesettings.owner }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->


                        </div>





                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->



        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import LineChart from './stats/pageviews.vue'

    export default {
        components: {
            LineChart
        },
            data() {
            return {
                lang: this.$lang,
                statscountall: '',
                statscountday: '',
                statscountweek: '',
                statscountrecent: '',
                chartData: [],
                labels: [],
                sitesettings: {},
                regs: {},
                cities: {},
                chartdatas:[]
            }
        },
        methods: {
            fillData() {
                axios.get('/api/apiPageviews')
                    .then(({data}) => {
                        this.chartdatas = data.data
                    })
                    .then(() => {
                        this.chartdatas.forEach(data => {
                            this.labels.push(data.date);
                            this.chartData.push(data.total);
                        });
                    })
            },

            statscount1() {
                axios.get('/api/statscountall').then(({ data})=> (
                    this.statscountall=data
                    )
                );
            },
            statscount2() {
                axios.get('/api/statscountday').then(({ data})=> (this.statscountday=data));
            },
            statscount3() {
                axios.get('/api/statscountweek').then(({ data})=> (this.statscountweek=data));
            },
            statscount4() {
                axios.get('/api/statscountrecent').then(({ data})=> (this.statscountrecent=data));
            },
            settings() {
                axios.get('/api/settings').then(({ data})=> (this.sitesettings=data));
            },
            loadregs() {
                axios.get('/api/regs2').then(({ data})=> (this.regs=data));
            },
            loadcities() {
                axios.get('/api/allcities').then(({ data})=> (this.cities=data));
            },
            updateread() {
                axios.get('/api/regsread');
            },
            refresh_records() {
                this.loadregs();
                this.updateread();
            },
            getResults2(page = 1) {
                axios.get('/api/regs2?page=' + page)
                    .then(response => {
                        this.regs = response.data;
                    });
            },
        },

        created() {

            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('/api/findregs2?q=' + query)
                    .then((data) => {
                        this.regs = data.data
                    })
                    .catch(() => {
                    })
            });
            //this.fillData();
            this.statscount1();
            this.statscount2();
            this.statscount3();
            this.statscount4();
            this.settings();
            this.loadregs();
            this.updateread();

            Fire.$on('AfterCreate',() => {

            })
        },
        mounted() {
           this.fillData();
        }
    }
</script>
