<template>
    <div class="container-fluid">
        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Alt Hizmetler</h1>
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
                                <a href="#">Hizmetler</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Alt Hizmetler
                            </li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

        <div class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Alt Hizmetler</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newModal">
                                {{ $trans[lang + ".blog"]["addnew"] }}
                                <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </div>

                        <div class="card-tools px-1">
                            <select
                                v-model="form2.language2"
                                @change="
                                    loadalthizmettursbylang2(
                                        form2.language2
                                    )
                                "
                                class="form-control"
                                id="language2"
                            >
                                <option value="0" disabled>Dil Seç</option>
                                <option
                                    v-if="localizations.length > 0"
                                    v-for="localization in localizations"
                                    v-bind:value="localization.id"
                                >
                                    {{ localization.title }}
                                </option>
                            </select>
                        </div>
                        <div class="card-tools px-1">
                            <select
                                v-model="form2.hizmettur2"
                                @change="
                                    loadalthizmettursbylang(
                                        form2.language2,
                                        form2.hizmettur2
                                    )
                                "
                                class="form-control"
                                id="hizmettur2"
                            >
                                <option value="0" disabled>Hizmet Seç</option>
                                <option
                                    v-if="hizmetturs2.length > 0"
                                    v-for="hizmettur in hizmetturs2"
                                    v-bind:value="hizmettur.hiz_id"
                                >
                                    {{ hizmettur.hizmettur.title }}
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
                                    <th>Hizmet</th>
                                    <th>
                                        {{ $trans[lang + ".blog"]["title1"] }}
                                    </th>
                                    <th>
                                        {{ $trans[lang + ".blog"]["slug"] }}
                                    </th>
                                    <th>Dil</th>
                                    <th>Anasayfa</th>
                                    <th>
                                        {{ $trans[lang + ".blog"]["status"] }}
                                    </th>
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
                                    v-for="(althizmetturs,
                                    index) in althizmetturs.data"
                                    :key="althizmetturs.id"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td v-if="althizmetturs.hizmettur">{{ althizmetturs.hizmettur.title }}</td>
                                    <td v-else>-</td>
                                    <td>{{ althizmetturs.title }}</td>
                                    <td>{{ althizmetturs.slug }}</td>
                                    <td v-if="althizmetturs.localization">
                                        {{ althizmetturs.localization.title }}
                                    </td>
                                    <td v-else>-</td>
                                    <td>
                                        <span
                                            class="badge badge-success"
                                            v-if="althizmetturs.mainpage == 1"
                                            >Evet</span
                                        >
                                        <span
                                            class="badge badge-danger"
                                            v-if="althizmetturs.mainpage == 0"
                                            >Hayır</span
                                        >
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-success"
                                            v-show="althizmetturs.active == 1"
                                            >{{
                                                $trans[lang + ".blog"]["active"]
                                            }}</span
                                        >
                                        <span
                                            class="badge badge-danger"
                                            v-show="althizmetturs.active == 0"
                                            >{{
                                                $trans[lang + ".blog"][
                                                    "passive"
                                                ]
                                            }}</span
                                        >
                                    </td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="uprecords(althizmetturs.id)"
                                            ><i
                                                class="fa fa-arrow-up orange"
                                            ></i
                                        ></a>
                                        /
                                        <a
                                            href="#"
                                            @click="
                                                downrecords(althizmetturs.id)
                                            "
                                            ><i
                                                class="fa fa-arrow-down cyan"
                                            ></i
                                        ></a>
                                    </td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="editModal(althizmetturs)"
                                            ><i class="fa fa-edit blue"></i
                                        ></a>
                                        /
                                        <a
                                            href="#"
                                            @click="
                                                deleteAlthizmettur(
                                                    althizmetturs.id
                                                )
                                            "
                                            ><i class="fa fa-trash red"></i
                                        ></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-success">
                        <pagination
                            :data="althizmetturs"
                            @pagination-change-page="getResults"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNewModalLabel"
            aria-hidden="true"
            v-if="$gate.isAdmin()"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            v-show="editmode"
                            id="addNewModalLabel"
                        >
                            Alt Hizmet Güncelle
                        </h5>
                        <h5
                            class="modal-title"
                            v-show="!editmode"
                            id="addNewModalLabel2"
                        >
                            Yeni Alt Hizmet
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="
                            editmode
                                ? updateAlthizmettur()
                                : createAlthizmettur()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <strong>Dil</strong><br />

                                <select
                                    v-model="form.language"
                                    @change="
                                        loadhizmettursbylang(form.language)
                                    "
                                    class="form-control"
                                    id="language"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'language'
                                        )
                                    }"
                                >
                                    <option value="0" disabled>Dil Seç</option>
                                    <option
                                        v-if="localizations.length > 0"
                                        v-for="localization in localizations"
                                        v-bind:value="localization.id"
                                    >
                                        {{ localization.title }}
                                    </option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="language"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <strong>Hizmet:</strong><br />
                                <select
                                    v-model="form.hiz_id"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('hiz_id')
                                    }"
                                >
                                    <option value="0" disabled>Hizmet Seçiniz</option>
                                    <option
                                        v-if="hizmetturs.length > 0"
                                        v-for="hizmettur in hizmetturs"
                                        v-bind:value="hizmettur.id"
                                    >
                                        {{ hizmettur.title }}
                                    </option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="hiz_id"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <strong
                                    >{{
                                        $trans[lang + ".blog"]["title1"]
                                    }}:</strong
                                ><br />
                                <input
                                    v-model="form.title"
                                    id="title"
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('title')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="title"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <strong
                                    >{{
                                        $trans[lang + ".blog"][
                                            "short_description"
                                        ]
                                    }}:</strong
                                ><br />
                                <input
                                    v-model="form.short_description"
                                    id="short_description"
                                    type="text"
                                    name="short_description"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'short_description'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="short_description"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <vue-dropzone
                                            ref="myVueDropzone"
                                            id="upload"
                                            :options="imguploadconfig"
                                            @vdropzone-complete="photocomplete"
                                        ></vue-dropzone>
                                        <input
                                            v-model="form.photo"
                                            id="photo"
                                            type="text"
                                            name="photo"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'photo'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="photo"
                                        ></has-error>
                                        <input
                                            type="text"
                                            v-model="form.photo_alt"
                                            class="form-control"
                                            id="photo_alt"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'photo_alt'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="photo_alt"
                                        ></has-error>
                                    </div>
                                    <div class="col-6">
                                        <strong
                                            >{{
                                                $trans[lang + ".pages"][
                                                    "preview"
                                                ]
                                            }}:</strong
                                        ><br />
                                        <img
                                            v-if="form.photo"
                                            :src="
                                                '\/img\/hizmetler\/thumbs\/' +
                                                    form.photo
                                            "
                                        />
                                        <img
                                            v-else
                                            :src="'\/img\/nophoto.png'"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <strong>Anasayfa</strong><br />
                                        <select
                                            v-model="form.mainpage"
                                            id="mainpage"
                                            name="mainpage"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'mainpage'
                                                )
                                            }"
                                        >
                                            <option value="0">Hayır</option>
                                            <option value="1">Evet</option>
                                        </select>
                                        <has-error
                                            :form="form"
                                            field="mainpage"
                                        ></has-error>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <strong
                                            >{{
                                                $trans[lang + ".blog"][
                                                    "status"
                                                ]
                                            }}:</strong
                                        ><br />
                                        <select
                                            v-model="form.active"
                                            id="type"
                                            name="active"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'active'
                                                )
                                            }"
                                        >
                                            <option value="1">{{
                                                $trans[lang + ".blog"]["active"]
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                :disabled="form.busy"
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                {{ $trans[lang + ".blog"]["close"] }}
                            </button>
                            <button
                                v-show="editmode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                {{ $trans[lang + ".blog"]["update"] }}
                            </button>
                            <button
                                v-show="!editmode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                {{ $trans[lang + ".blog"]["create"] }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

            imguploadconfig: {
                url: "/api/Althizmettur_image",
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector(
                        "[name=csrf-token]"
                    ).content
                },
                maxFilesize: 10, // MB
                maxFiles: 1,
                chunking: false,
                dictDefaultMessage:
                    "<i class='fas fa-upload'></i>&nbsp;&nbsp;UPLOAD IMAGE",
                addRemoveLinks: true
            },

            editmode: false,
            hizmetturs: {},
            hizmetturs2: {},
            althizmetturs: {},
            localizations: {},
            tmplang: "",
            tmphizmettur: "",
            form: new Form({
                id: "",
                hiz_id: "",
                title: "",
                slug: "",
                short_description: "",
                photo: "",
                photo_alt: "",
                language: "",
                language2: "1",
                hizmettur2: "0",
                mainpage: "0",
                active: "1"
            }),
            form2: new Form({
                language2: "1",
                hizmettur2: "0"
            })
        };
    },

    components: {
        vueDropzone
    },
    methods: {
        photocomplete(file) {
            let response = JSON.parse(file.xhr.response);
            console.log("Photo:" + response.data);
            this.form.photo = response.data;
        },

        uprecords(id) {
            axios({
                url: "/api/althizmetturup",
                method: "POST",
                data: {
                    id: id
                }
            })
                .then(() => {
                    toast.fire(
                        "Updated!",
                        "Alt Hizmettur order updated",
                        "success"
                    );
                    Fire.$emit("AfterCreate");
                })
                .catch(() => {
                    toast.fire("Failed", "There was an error", "warning");
                });
        },
        downrecords(id) {
            axios({
                url: "/api/althizmetturdown",
                method: "post",
                data: {
                    id: id
                }
            })
                .then(() => {
                    toast.fire(
                        "Updated!",
                        "Althizmettur order updated",
                        "success"
                    );
                    Fire.$emit("AfterCreate");
                })
                .catch(() => {
                    toast.fire("Başarısız", "Bir hata meydana geldi.", "warning");
                });
        },

        getResults(page = 1) {
            axios
                .get(
                    "/api/althizmettursbylang/" +
                        this.form2.language2 + "/" +
                        this.form2.hizmettur2 +
                        "/?page=" +
                        page
                )
                .then(response => {
                    this.althizmetturs = response.data;
                });
        },
        updateAlthizmettur() {
            this.$Progress.start();

            //console.log('editing data');

            this.form
                .put("/api/althizmetturs/" + this.form.id)
                .then(() => {
                    $("#addNew").modal("hide");
                    toast.fire(
                        "Updated!",
                        "Althizmet başarıyla güncellendi.",
                        "success"
                    );
                    this.$Progress.finish();
                    Fire.$emit("AfterCreate");
                })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire("Başarısız", "Bir hata meydana geldi.", "warning");
                });
        },
        createAlthizmettur() {
            this.$Progress.start();
            this.form
                .post("/api/althizmetturs")
                .then(({ data }) => {
                    // form başarılıysa buraya girecek.
                    //console.log(data);
                    this.form.reset();
                    Fire.$emit("AfterCreate");
                    $("#addNew").modal("hide");
                    toast.fire({
                        type: "success",
                        title: "Althizmet başarıyla oluşturuldu."
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    // formda hata varsa buraya girecek.
                    this.$Progress.fail();
                });
        },
        editModal(althizmetturs) {
            this.$refs.myVueDropzone.removeAllFiles();
            this.editmode = true;
            this.tmplang = this.form2.language2;
            this.form.reset();
            $("#addNew").modal("show");
            this.form.language = this.tmplang;
            this.form.fill(althizmetturs);
            this.form2.language2 = this.form.language;
        },
        newModal() {
            this.$refs.myVueDropzone.removeAllFiles();
            this.editmode = false;
            this.tmplang = this.form2.language2;
            this.tmphizmettur = this.form2.hizmettur2;
            this.form.reset();
            this.form.language = this.tmplang;
            $("#addNew").modal("show");
            this.form2.language2 = this.form.language;
            this.form2.hizmettur2 = this.tmphizmettur;
            this.form.hiz_id = this.tmphizmettur;

        },
        deleteAlthizmettur(id) {
            swal.fire({
                title: "Emin misiniz?",
                text: "Alt hizmeti silmeden önce alt hizmete bağlı herhangi bir içerik olmadığından emin olunuz!!!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Evet, silebilirsin!"
            }).then(result => {
                if (result.value) {
                    // send ajax request
                    this.form
                        .delete("/api/althizmetturs/" + id)
                        .then(() => {
                            swal.fire(
                                "Silindi!",
                                "Hizmet türü başarıyla silindi.<br> Not: Eğer bağlı içerik varsa silme işlemi gerçekleşmez.",
                                "success"
                            );
                            Fire.$emit("AfterCreate");
                        })
                        .catch(() => {
                            swal.fire(
                                "Başarısız",
                                "Silme işleminde bir hata meydana geldi.<br> Bu hatanın sebeplerinden biri silmeye çalıştığınız nesneye bağlı bir içerik olmasıdır!!!",
                                "warning"
                            );
                        });
                }
            });
        },
        loadAlthizmettur() {
            axios
                .get("/api/althizmetturs")
                .then(({ data }) => (this.althizmetturs = data));
        },
        loadHizmettur2(id) {
            axios
                .get("/api/Allhizmettur2/" + id)
                .then(({ data }) => (this.hizmetturs2 = data));
        },
        loadhizmettursbylang(id) {
            axios
                .get("/api/hizmettursbylang2/" + id)
                .then(({ data }) => (this.hizmetturs = data));
        },
        loadhizmettursbylangfortop(id) {
            axios
                .get("/api/hizmettursbylang2/" + id)
                .then(({ data }) => (this.hizmetturs2 = data));
        },
        loadalthizmettursbylang(id, hid) {
            axios
                .get("/api/althizmettursbylang/" + id + "/" + hid)
                .then(({ data }) => (this.althizmetturs = data));
            this.loadHizmettur2(this.form2.language2);
        },
        loadalthizmettursbylang2(id) {
            this.form2.hizmettur2=0;
            axios
                .get("/api/althizmettursbylang2/" + id)
                .then(({ data }) => (this.althizmetturs = data));
            this.loadHizmettur2(this.form2.language2);
        },
        loadLocalization() {
            axios
                .get("/api/activelocalizations")
                .then(({ data }) => (this.localizations = data.data));
        }
    },
    created() {
        Fire.$on("searching", () => {
            let query = this.$parent.search;
            axios
                .get(
                    "/api/findAlthizmettur/" +
                        this.form2.language2 +
                        "/?q=" +
                        query
                )
                .then(data => {
                    this.althizmetturs = data.data;
                })
                .catch(() => {});
        });

        this.loadalthizmettursbylang(this.form2.language2, this.form2.hizmettur2);
        this.loadhizmettursbylang(this.form2.language2);
        this.loadHizmettur2(this.form2.language2);
        this.loadLocalization();
        Fire.$on("AfterCreate", () => {
            this.loadalthizmettursbylang(
                this.form2.language2,
                this.form2.hizmettur2
            );
            this.loadhizmettursbylang(this.form2.language2);
        });
    }
};
</script>
