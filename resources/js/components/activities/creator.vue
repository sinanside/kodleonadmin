<template>
    <div class="container-fluid">
        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Aktiviteler</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">{{
                                    $trans[lang + ".pages"]["dashboard"]
                                    }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">İçerikler</a>
                            </li>
                            <li class="breadcrumb-item active">İçerik</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">İçerik Listesi</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">
                                {{ $trans[lang + ".blog"]["addnew"] }}
                                <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </div>
                        <div class="card-tools px-1">
                            <select
                                v-model="form.language2"
                                @change="loadpostsbylang(form.language2)"
                                class="form-control"
                                id="language2"
                            >
                                <option value="0" disabled>Dil Seç</option>
                                <option
                                    v-if="localizations.data.length > 0"
                                    v-for="localization in localizations.data"
                                    v-bind:value="localization.id"
                                >
                                    {{ localization.title }}
                                </option>
                            </select>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>Resim</th>
                                <th>Aktivite</th>
                                <th>Tür</th>
                                <th>Durum</th>
                                <th>
                                    {{
                                    $trans[lang + ".carousel"]["order"]
                                    }}
                                </th>
                                <th>
                                    {{ $trans[lang + ".blog"]["modify"] }}
                                </th>
                            </tr>

                            <tr
                                v-for="(posts, index) in posts.data"
                                :key="posts.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <img v-if="posts.picture_link" :src="'/img/activities/thumbs/' + posts.picture_link" >
                                    <img v-else :src="'/img/nophoto.png'" >

                                </td>
                                <!--<td>{{ posts.localization.title }}</td>
                                <td>
                                     <span
                                         class="badge badge-primary"
                                         v-show="posts.tur == 1"
                                     >Sayfa</span
                                     >
                                    <span
                                        class="badge badge-warning"
                                        v-show="posts.tur == 0"
                                    >İçerik</span
                                    >
                                </td>-->
                                <td v-if="posts.activity">{{ posts.activity.title }}</td>
                                <td v-else>-</td>
                                <td>{{ posts.tur }}</td>
                                <td>
                                        <span
                                            class="badge badge-success"
                                            v-show="posts.active == 1"
                                        >{{
                                                $trans[lang + ".blog"]["active"]
                                            }}</span
                                        >
                                    <span
                                        class="badge badge-danger"
                                        v-show="posts.active == 0"
                                    >{{
                                                $trans[lang + ".blog"][
                                                    "passive"
                                                ]
                                            }}</span
                                    >
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(posts.id)"
                                    ><i
                                        class="fa fa-arrow-up orange"
                                    ></i
                                    ></a>
                                    /
                                    <a
                                        href="#"
                                        @click="downrecords(posts.id)"
                                    ><i
                                        class="fa fa-arrow-down cyan"
                                    ></i
                                    ></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(posts)"
                                    ><i class="fa fa-edit blue"></i
                                    ></a>
                                    /
                                    <a
                                        href="#"
                                        @click="deleteposts(posts.id)"
                                    ><i class="fa fa-trash red"></i
                                    ></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination
                            :data="posts"
                            @pagination-change-page="getResults"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>

        <div v-show="addmode" class="row mt-2" v-if="$gate.isAdmin()">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2 bg-success">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a
                                    class="nav-link active show"
                                    href="#headerinfo"
                                    data-toggle="tab"
                                >{{
                                    $trans[lang + ".blog"][
                                    "header_information"
                                    ]
                                    }}</a
                                >
                            </li>


                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- headerinfo Tab -->
                            <div class="tab-pane active show" id="headerinfo">
                                <form class="form-horizontal">

                                    <div class="form-group">
                                        <label for="tur" class="col-sm-2 control-label">Tür:</label>

                                        <div class="col-sm-12">
                                            <select v-model="form.tur" id="tur" class="form-control" :class="{ 'is-invalid': form.errors.has('tur') }">
                                                <option value="0" disabled>Seçiniz</option>
                                                <option value="youtube">Youtube</option>
                                                <option value="video">Video</option>
                                                <option value="resim">Resim</option>
                                            </select>
                                            <has-error :form="form" field="tur"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="language"
                                            class="col-sm-2 control-label"
                                        >Dil:</label
                                        >

                                        <div class="col-sm-12">
                                            <select
                                                @change="
                                                    loadactivitiesbylang(
                                                        form.language
                                                    )
                                                "
                                                v-model="form.language"
                                                class="form-control"
                                                id="language"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'language'
                                                    )
                                                }"
                                            >
                                                <option value="0" disabled
                                                >Dil Seç</option
                                                >
                                                <option
                                                    v-if="
                                                        localizations.data
                                                            .length > 0
                                                    "
                                                    v-for="localization in localizations.data"
                                                    v-bind:value="
                                                        localization.id
                                                    "
                                                >
                                                    {{ localization.title }}
                                                </option>
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="language"
                                            ></has-error>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                        >Aktivite:</label
                                        >

                                        <div class="col-sm-12">
                                            <select
                                                v-model="form.activity_id"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'hiz_id'
                                                    )
                                                }"
                                            >
                                                <option value="0"
                                                >Seçiniz</option
                                                >
                                                <option
                                                    v-if="activities.length > 0"
                                                    v-for="activity in activities"
                                                    v-bind:value="activity.id"
                                                >
                                                    {{ activity.title }}
                                                </option>
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="activity_id"
                                            ></has-error>
                                        </div>
                                    </div>



                                           <div class="form-group">
                                        <label
                                            for="name"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".blog"][
                                            "title1"
                                            ]
                                            }}:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type="text"
                                                v-model="form.name"
                                                class="form-control"
                                                id="name"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'name'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="name"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div v-show="form.tur=='youtube'" class="form-group">
                                        <label
                                            for="youtube_link"
                                            class="col-sm-3 control-label"
                                        >Youtube Bağlantısı:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="form.youtube_link"
                                                class="form-control"
                                                id="youtube_link"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'youtube_link'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="youtube_link"
                                            ></has-error>
                                        </div>
                                    </div>


                                    <div  v-show="form.tur=='video'" class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label
                                                    class="control-label"
                                                >Video Dosyası:</label>
                                                <vue-dropzone  ref="myVueDropzone" id="upload2" :options="videouploadconfig" @vdropzone-complete="activityvideocomplete"></vue-dropzone>
                                                <input v-model="form.video_link" id="video_link" type="text" name="video_link"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('video_link') }">
                                                <has-error :form="form" field="video_link"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-6">
                                                <label
                                                    class="control-label"
                                                >Resim Dosyası:</label
                                                >
                                                <vue-dropzone  ref="myVueDropzone" id="upload" :options="imguploadconfig1" @vdropzone-complete="activityimagecomplete"></vue-dropzone>
                                                <input v-model="form.picture_link" id="image" type="text" name="image"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture_link') }">
                                                <has-error :form="form" field="picture_link"></has-error>

                                            </div>
                                            <div class="col-6">
                                                <strong>{{ $trans[lang+'.pages']['preview'] }}:</strong><br>
                                                <img v-if="form.picture_link" :src="'\/img\/activities\/thumbs\/'+form.picture_link">
                                                <img v-else :src="'\/img\/nophoto.png'">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="short_description1"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}1:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="form.short_description1"
                                                class="form-control"
                                                id="short_description1"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description1'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description1"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="short_description2"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}2:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="form.short_description2"
                                                class="form-control"
                                                id="short_description2"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description2'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description2"
                                            ></has-error>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label
                                            for="active"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".blog"][
                                            "status"
                                            ]
                                            }}:</label
                                        >
                                        <div class="col-sm-12">
                                            <select
                                                v-model="form.active"
                                                id="active"
                                                name="active"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'active'
                                                    )
                                                }"
                                            >
                                                <option value="1">{{
                                                    $trans[lang + ".blog"][
                                                    "active"
                                                    ]
                                                    }}</option>
                                                <option value="0">{{
                                                    $trans[lang + ".blog"][
                                                    "passive"
                                                    ]
                                                    }}</option>
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="active"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button
                                                v-if="editmode"
                                                @click.prevent="updateposts"
                                                type="button"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-edit"></i>
                                                {{
                                                $trans[lang + ".blog"][
                                                "update"
                                                ]
                                                }}
                                            </button>
                                            <button
                                                v-else
                                                @click.prevent="createposts"
                                                type="button"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-plus"></i>
                                                {{
                                                $trans[lang + ".blog"][
                                                "create"
                                                ]
                                                }}
                                            </button>
                                            <button
                                                @click.prevent="backtolist"
                                                type="button"
                                                class="btn btn-warning"
                                            >
                                                <i class="fas fa-undo"></i>
                                                İçerik Listesine Dön
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
        </div>
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";
    import axios from "axios";

    export default {
        data() {
            return {
                lang: this.$lang,

                imguploadconfig1: {
                    url: "/api/activitycreators_image",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector(
                            "[name=csrf-token]"
                        ).content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    thumbnailWidth: 60,
                    thumbnailHeight: 60,
                    dictDefaultMessage:
                        "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 1",
                    addRemoveLinks: true
                },
                videouploadconfig: {
                    url: "/api/carousel_video",
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                    maxFilesize: 10, // MB
                    maxFiles: 1,
                    chunking: false,
                    dictDefaultMessage: "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD VIDEO",
                    addRemoveLinks: true
                },
                editmode: false,
                listmode: true,
                addmode: false,
                activities: {},
                localizations: {},
                posts: {},
                tmplang: "",
                tmptur: "",
                tmpactivity: "",
                form: new Form({
                    id: "",
                    tur: "1",
                    activity_id: "",
                    language: "1",
                    language2: "1",
                    language3: "0",
                    name: "",
                    short_description1: "",
                    short_description2: "",
                    youtube_link: "",
                    video_link: "",
                    picture_link: "",
                    active: "1"
                })
            };
        },

        components: {
            vueDropzone
        },
        methods: {

            activityimagecomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Photo1:"+response.data);
                this.form.picture_link = response.data;
            },
            activityvideocomplete(file) {

                let response = JSON.parse(file.xhr.response);
                console.log("Video1:"+response.data);
                this.form.video_link = response.data;
            },

            getResults(page = 1) {
                axios
                    .get(
                        "/api/activitycreatorsbylang/" +
                        this.form.language2 +
                        "/?page=" +
                        page
                    )
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/activitycreatorsup",
                    method: "POST",
                    data: {
                        id: id
                    }
                })
                    .then(() => {
                        toast.fire("Updated!", "Post order updated", "success");
                        Fire.$emit("AfterCreate");
                    })
                    .catch(() => {
                        toast.fire("Failed", "There was an error", "warning");
                    });
            },
            downrecords(id) {
                axios({
                    url: "/api/activitycreatorsdown",
                    method: "POST",
                    data: {
                        id: id
                    }
                })
                    .then(() => {
                        toast.fire("Updated!", "Order updated", "success");
                        Fire.$emit("AfterCreate");
                    })
                    .catch(() => {
                        toast.fire("Failed", "There was an error", "warning");
                    });
            },

            updateposts() {
                this.$Progress.start();

                //console.log('editing data');
                this.form
                    .put("/api/activitycreators/" + this.form.id)
                    .then(() => {
                        toast.fire(
                            "Updated!",
                            "Record has been updated",
                            "success"
                        );
                        this.$Progress.finish();
                        Fire.$emit("AfterCreate");
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        toast.fire("Failed", "There was an error", "warning");
                    });
            },
            createposts() {
                this.$Progress.start();
                this.form
                    .post("/api/activitycreators")
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.tmplang = this.form.language;
                        this.form.reset();
                        this.form.language2 = this.tmplang;
                        Fire.$emit("AfterCreate");
                        $("#addNew").modal("hide");
                        toast.fire({
                            type: "success",
                            title: "Record created successfully"
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    });
            },
            editForm(posts) {
                this.listmode = false;
                this.addmode = true;
                this.editmode = true;
                this.$refs.myVueDropzone.removeAllFiles();
                //this.$refs.myVueDropzone2.removeAllFiles();
                this.tmplang = this.form.language2;
                this.tmptur = this.form.tur2;
                this.form.reset();
                this.form.language = this.tmplang;
                this.form.tur = this.tmptur;
                this.form.fill(posts);
                //this.loadhizmettursbylang(this.form.language);
                this.form.language2 = this.form.language;
                this.form.tur2 = this.form.tur;
            },
            newForm() {
                this.listmode = false;
                this.addmode = true;
                this.editmode = false;
                this.$refs.myVueDropzone.removeAllFiles();
                //this.$refs.myVueDropzone2.removeAllFiles();

                this.tmplang = this.form.language2;
                this.tmptur = 0;
                this.tmpactivity=0;
                this.form.reset();
                this.form.language = this.tmplang;
                this.form.language2 = this.form.language;
                this.form.tur = this.tmptur;
                this.form.activity_id =this.tmpactivity;
            },
            backtolist() {
                this.listmode = true;
                this.addmode = false;
                this.editmode = false;
            },
            deleteposts(id) {
                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.value) {
                        // send ajax request
                        this.form
                            .delete("/api/activitycreators/" + id)
                            .then(() => {
                                swal.fire(
                                    "Deleted!",
                                    "activity has been deleted.",
                                    "success"
                                );
                                Fire.$emit("AfterCreate");
                            })
                            .catch(() => {
                                swal.fire(
                                    "Failed",
                                    "There was an error",
                                    "warning"
                                );
                            });
                    }
                });
            },
            loadpostsbylang(id) {
                axios
                    .get("/api/activitycreatorsbylang/" + id)
                    .then(({ data }) => (this.posts = data));
            },
            loadactivitiesbylang(id) {
                axios
                    .get("/api/activitiesbylang2/" + id)
                    .then(({ data }) => (this.activities = data));
            },

            loadLocalization() {
                axios
                    .get("/api/activelocalizations")
                    .then(({ data }) => (this.localizations = data));
            }
        },

        created() {
            Fire.$on("searching", () => {
                let query = this.$parent.search;
                axios
                    .get("/api/findactivitycreators?q=" + query)
                    .then(data => {
                        this.posts = data.data;
                    })
                    .catch(() => {});
            });

            this.loadpostsbylang(this.form.language2);
            //this.loadHizmettur();
            this.loadactivitiesbylang(this.form.language2);
            this.loadLocalization();

            Fire.$on("AfterCreate", () => {
                this.loadpostsbylang(this.form.language2);
                this.listmode = true;
                this.addmode = false;
                this.editmode = false;
            });
        }
    };
</script>
