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
                                <h3>12</h3>
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
                                <h3>35</h3>
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
                                <h3>210</h3>

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
                                <h3>890</h3>

                                <p>Aylık Ziyaretçi</p>
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
                <div class="row">


                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-12 connectedSortable ui-sortable">

                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">
                                    <i class="fas fa-users"></i>
                                    Son Ziyaretçiler
                                </h3>

                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Kullanıcı</th>
                                        <th>Cihaz</th>
                                        <th>Tarayıcı</th>
                                        <th>Bölge</th>
                                        <th>Dil</th>
                                        <th>Son Giriş</th>

                                    </tr>
                                    <tr v-for="usersonline,index in usersonline.data" :key="usersonline.id">


                                        <td>{{ index+1 }}</td>
                                        <td>{{ usersonline.username }}</td>
                                        <td>{{ usersonline.device }}</td>
                                        <td>{{ usersonline.agent }}</td>
                                        <td>{{ usersonline.country }}</td>
                                        <td>{{ usersonline.language }}</td>
                                        <td>{{ usersonline.updated }}</td>
                                    </tr>
                                </table>



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
    export default {
        data() {
            return {
                lang: this.$lang,
                usersonline: {}
            }
        },
        methods: {
            onlineusers() {
                //axios.get('/api/stats_counts').then(data => this.usersonline = data);
                axios.get('/api/stats_counts').then(({ data})=> (this.usersonline=data));

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
