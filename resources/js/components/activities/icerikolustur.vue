<template>
    <div class="container-fluid">

        <div class="row mt-6" v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <div class="content-header" v-if="$gate.isAdmin()">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $trans[lang+'.main']['activities'] }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">{{ $trans[lang+'.pages']['dashboard'] }}</a></li>
                            <li class="breadcrumb-item active">{{ $trans[lang+'.main']['activities'] }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div v-show="listmode" class="row mt-2 " v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">{{ $trans[lang+'.main']['activities'] }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary" @click="newForm">{{ $trans[lang+'.blog']['addnew'] }} <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                        <div class="card-tools">
                            <select
                                v-model="form2.language2"
                                @change="loadactivitiesbylang(form2.language2,form2.tur2)"
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


                        <div class="card-tools px-1">
                            <select
                                v-model="form2.tur2"
                                @change="
                                    loadactivitiesbylang(
                                        form2.language2,
                                        form2.tur2
                                    )
                                "
                                class="form-control"
                                id="tur2"
                            >
                                <option value="0" disabled>Tür Seç</option>
                                <option value="1">
                                    Performans
                                </option>
                                <option value="2">
                                    Konser
                                </option>
                                <option value="3">
                                    Mavi akademi
                                </option>
                                <option value="5">
                                    Single
                                </option>
                            </select>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>#</th>
                                <th>{{ $trans[lang+'.ourteam']['title1'] }}</th>
                                <th>Tür</th>
                                <th>Zaman</th>
                                <th>{{ $trans[lang+'.ourteam']['status'] }}</th>
                                <th>{{ $trans[lang+'.carousel']['order'] }}</th>
                                <th>{{ $trans[lang+'.ourteam']['modify'] }}</th>
                            </tr>

                            <tr v-for="activities,index in activities.data" :key="activities.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ activities.title }}</td>
                                <td v-if="activities.tur==1">Performans</td>
                                <td v-else-if="activities.tur==2">Konser</td>
                                <td v-else-if="activities.tur==3">Mavi Akademi</td>
                                <td v-else-if="activities.tur==5">Single</td>
                                <td v-else>-</td>
                                <td>{{ activities.start_date }}</td>
                                <td>
                                    <span class="badge badge-success" v-if="activities.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                    <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                </td>
                                <td>
                                    <a href="#" @click="uprecords(activities.id)"><i class="fa fa-arrow-up orange"></i></a> /
                                    <a href="#" @click="downrecords(activities.id)"><i class="fa fa-arrow-down cyan"></i></a>
                                </td>
                                <td>
                                    <a href="#" @click="editForm(activities)"><i class="fa fa-edit blue"></i></a> /
                                    <a href="#" @click="deleteactivities(activities.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="activities" @pagination-change-page="getResults"></pagination>
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
                            <li class="nav-item"><a class="nav-link" href="#links" data-toggle="tab">Linkler</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pictures" data-toggle="tab">{{ $trans[lang+'.blog']['pictures'] }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#detailed" data-toggle="tab">{{ $trans[lang+'.blog']['detailed_content'] }}</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane" id="summary">
                                <h3 class="text-center">{{ $trans[lang+'.blog']['activities_info'] }}</h3>

                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>Model:</strong> App\Activities<br>
                                    <strong>Usage:</strong> Activities::where('slug', '=', $slug)->firstOrFail();
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
                                        <td><strong>{{ $trans[lang+'.blog']['status'] }}</strong></td>
                                        <td>
                                            <span class="badge badge-success" v-if="this.form.active">{{ $trans[lang+'.blog']['active'] }}</span>
                                            <span class="badge badge-danger" v-else>{{ $trans[lang+'.blog']['passive'] }}</span>
                                        </td>
                                        <td>active</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}1</strong></td>
                                        <td>
                                            <img v-if="form.photo1" :src="'\/img/activities/thumbs\/'+form.photo1">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo1</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}1 Alt</strong></td>
                                        <td>
                                            {{this.form.photo1_alt}}
                                        </td>
                                        <td>photo1_alt</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}2</strong></td>
                                        <td>
                                            <img v-if="form.photo2" :src="'\/img\/activities\/thumbs\/'+form.photo2">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo2</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}2 Alt</strong></td>
                                        <td>
                                            {{this.form.photo2_alt}}
                                        </td>
                                        <td>photo2_alt</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}3</strong></td>
                                        <td>
                                            <img v-if="form.picture3" :src="'\/img/activities/thumbs\/'+form.picture3">
                                            <img v-else :src="'\/img\/nophoto.png'">
                                        </td>
                                        <td>photo3</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td><strong>{{ $trans[lang+'.pages']['picture'] }}3 Alt</strong></td>
                                        <td>
                                            {{this.form.photo3_alt}}
                                        </td>
                                        <td>photo3_alt</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td><strong>{{ $trans[lang+'.blog']['short_content'] }}:</strong></td>
                                        <td>-</td>
                                        <td>short_content</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
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
                                        <label
                                            for="language"
                                            class="col-sm-2 control-label"
                                        >Dil:</label
                                        >

                                        <div class="col-sm-12">
                                            <select
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
                                        <label
                                            for="tur"
                                            class="col-sm-2 control-label"
                                        >Tür:</label
                                        >

                                        <div class="col-sm-12">
                                            <select
                                                v-model="form.tur"
                                                class="form-control"
                                                id="tur"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'tur'
                                                    )
                                                }"
                                            >
                                                <option value="0" disabled
                                                >Tür Seç</option
                                                >
                                                <option value="1">
                                                    Performans
                                                </option>
                                                <option value="2">
                                                    Konser
                                                </option>
                                                <option value="3">
                                                    Mavi akademi
                                                </option>
                                                <option value="5">
                                                    Single
                                                </option>
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="tur"
                                            ></has-error>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">{{ $trans[lang+'.blog']['title1'] }}:</label>

                                        <div class="col-sm-12">
                                            <input type="" v-model="form.title" class="form-control" id="title"  :class="{ 'is-invalid': form.errors.has('title') }">
                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Başlangıç Tarihi:</label>

                                        <div class="col-sm-12">
                                            <date-picker v-model="form.start_date" :config="options"></date-picker>                                            <has-error :form="form" field="title"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Bitiş Tarihi:</label>

                                        <div class="col-sm-12">
                                            <date-picker v-model="form.end_date" :config="options"></date-picker>                                            <has-error :form="form" field="title"></has-error>
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
                                            <button  v-if="editmode"  @click.prevent="updateactivities" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createactivities" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Faaliyetler Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- shortdescriptions Tab -->
                            <div class="tab-pane" id="shortdescription">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label
                                            for="short_description1"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            1:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description1
                                                "
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
                                            }}
                                            2:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description2
                                                "
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
                                            for="short_description1"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            3:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description3
                                                "
                                                class="form-control"
                                                id="short_description3"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description3'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description3"
                                            ></has-error>
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
                                            }}
                                            4:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description4
                                                "
                                                class="form-control"
                                                id="short_description4"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description4'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description4"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="short_description5"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            5:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description5
                                                "
                                                class="form-control"
                                                id="short_description5"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description5'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description5"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="short_description6"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            6:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description6
                                                "
                                                class="form-control"
                                                id="short_description6"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description6'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description6"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="short_description7"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            7:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description7
                                                "
                                                class="form-control"
                                                id="short_description7"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description7'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description7"
                                            ></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label
                                            for="short_description8"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            8:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description8
                                                "
                                                class="form-control"
                                                id="short_description8"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description8'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description8"
                                            ></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label
                                            for="short_description9"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            9:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description9
                                                "
                                                class="form-control"
                                                id="short_description9"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description9'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description9"
                                            ></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label
                                            for="short_description10"
                                            class="col-sm-2 control-label"
                                        >{{
                                            $trans[lang + ".pages"][
                                            "short_description"
                                            ]
                                            }}
                                            10:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.short_description10
                                                "
                                                class="form-control"
                                                id="short_description10"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'short_description10'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="short_description10"
                                            ></has-error>
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateactivities" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createactivities" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Faaliyetler Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>





                            <!-- links Tab -->
                            <div class="tab-pane" id="links">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label
                                            for="link1_text"
                                            class="col-sm-2 control-label"
                                        >Link 1 Text:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link1_text
                                                "
                                                class="form-control"
                                                id="link1_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link1_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link1_text"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="link1_href"
                                            class="col-sm-2 control-label"
                                        >Link 1 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link1_href
                                                "
                                                class="form-control"
                                                id="link1_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link1_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link1_href"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="link2_text"
                                            class="col-sm-2 control-label"
                                        >Link 2 Text:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link2_text
                                                "
                                                class="form-control"
                                                id="link2_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link2_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link2_text"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="link2_href"
                                            class="col-sm-2 control-label"
                                        >Link 2 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link2_href
                                                "
                                                class="form-control"
                                                id="link2_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link2_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link2_href"
                                            ></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="link3_text"
                                            class="col-sm-2 control-label"
                                        >Link 3 Text:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link3_text
                                                "
                                                class="form-control"
                                                id="link3_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link3_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link3_text"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link3_href"
                                            class="col-sm-2 control-label"
                                        >Link 3 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link3_href
                                                "
                                                class="form-control"
                                                id="link3_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link3_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link3_href"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link4_text"
                                            class="col-sm-2 control-label"
                                        >Link Text 4:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link4_text
                                                "
                                                class="form-control"
                                                id="link4_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link4_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link4_text"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link4_href"
                                            class="col-sm-2 control-label"
                                        >Link 4 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link4_href
                                                "
                                                class="form-control"
                                                id="link4_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link4_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link4_href"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link5_text"
                                            class="col-sm-2 control-label"
                                        >Link 5 Text:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link5_text
                                                "
                                                class="form-control"
                                                id="link5_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link5_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link5_text"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link5_href"
                                            class="col-sm-2 control-label"
                                        >Link 5 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link5_href
                                                "
                                                class="form-control"
                                                id="link5_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link5_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link5_href"
                                            ></has-error>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label
                                            for="link6_text"
                                            class="col-sm-2 control-label"
                                        >Link 6 Text:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link6_text
                                                "
                                                class="form-control"
                                                id="link6_text"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link5_text'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link6_text"
                                            ></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="link6_href"
                                            class="col-sm-2 control-label"
                                        >Link 6 Href:</label
                                        >

                                        <div class="col-sm-12">
                                            <input
                                                type=""
                                                v-model="
                                                    form.link6_href
                                                "
                                                class="form-control"
                                                id="link6_href"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'link6_href'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="link6_href"
                                            ></has-error>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateactivities" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createactivities" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Faaliyetler Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>


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
                                                <img class="img-thumbnail" v-if="form.picture1" :src="'\/img\/activities\/thumbs\/'+form.picture1">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture1" id="picture1" type="text" name="picture1"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture1') }">
                                                <input type="text" v-model="form.picture1_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture1_alt"  :class="{ 'is-invalid': form.errors.has('picture1_alt') }">
                                                <has-error :form="form" field="picture1_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture2" :src="'\/img\/activities\/thumbs\/'+form.picture2">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture2" id="picture2" type="text" name="picture2"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture2') }">
                                                <input type="text" v-model="form.picture2_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture2_alt"  :class="{ 'is-invalid': form.errors.has('picture1_alt') }">
                                                <has-error :form="form" field="picture2_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture3" :src="'\/img\/activities\/thumbs\/'+form.picture3">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture3" id="picture3" type="text" name="picture3"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture3') }">
                                                <input type="text" v-model="form.picture3_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture3_alt"  :class="{ 'is-invalid': form.errors.has('picture3_alt') }">
                                                <has-error :form="form" field="picture3_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture4" :src="'\/img\/activities\/thumbs\/'+form.picture4">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture4" id="picture4" type="text" name="picture4"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture4') }">
                                                <input type="text" v-model="form.picture4_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture4_alt"  :class="{ 'is-invalid': form.errors.has('picture4_alt') }">
                                                <has-error :form="form" field="picture4_alt"></has-error>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture5" :src="'\/img\/activities\/thumbs\/'+form.picture5">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture5" id="picture5" type="text" name="picture5"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture5') }">
                                                <input type="text" v-model="form.picture5_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture5_alt"  :class="{ 'is-invalid': form.errors.has('picture5_alt') }">
                                                <has-error :form="form" field="picture5_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture6" :src="'\/img\/activities\/thumbs\/'+form.picture6">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture6" id="picture6" type="text" name="picture6"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture6') }">
                                                <input type="text" v-model="form.picture6_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture6_alt"  :class="{ 'is-invalid': form.errors.has('picture6_alt') }">
                                                <has-error :form="form" field="picture6_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture7" :src="'\/img\/activities\/thumbs\/'+form.picture7">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture7" id="picture7" type="text" name="picture7"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture7') }">
                                                <input type="text" v-model="form.picture7_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture7_alt"  :class="{ 'is-invalid': form.errors.has('picture7_alt') }">
                                                <has-error :form="form" field="picture7_alt"></has-error>
                                            </div>
                                            <div class="col-3 text-center">
                                                <img class="img-thumbnail" v-if="form.picture8" :src="'\/img\/activities\/thumbs\/'+form.picture8">
                                                <img class="img-thumbnail" v-else :src="'\/img\/nophoto200.png'">
                                                <input v-model="form.picture8" id="picture8" type="text" name="picture8"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('picture8') }">
                                                <input type="text" v-model="form.picture8_alt" placeholder="Resim Alt Bilgisi" class="form-control" id="picture8_alt"  :class="{ 'is-invalid': form.errors.has('picture8_alt') }">
                                                <has-error :form="form" field="picture8_alt"></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateactivities" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createactivities" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Faaliyetler Listesine Dön </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->


                            <!-- headerinfo Tab -->
                            <div class="tab-pane" id="detailed">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor1"
                                                    v-model="form.description1"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description1"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor2"
                                                    v-model="form.description2"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description2"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor3"
                                                    v-model="form.description3"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description3"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor4"
                                                    v-model="form.description4"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description4"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor5"
                                                    v-model="form.description5"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description5"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor6"
                                                    v-model="form.description6"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description6"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor7"
                                                    v-model="form.description7"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description7"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <vue-editor
                                                    :editorOptions="
                                                        editorSettings
                                                    "
                                                    useCustomImageHandler
                                                    @imageAdded="
                                                        handleImageAdded
                                                    "
                                                    id="activities_editor8"
                                                    v-model="form.description8"
                                                >
                                                </vue-editor>

                                                <has-error
                                                    :form="form"
                                                    field="description8"
                                                ></has-error>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button  v-if="editmode"  @click.prevent="updateactivities" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> {{ $trans[lang+'.blog']['update'] }}</button>
                                            <button  v-else  @click.prevent="createactivities" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> {{ $trans[lang+'.blog']['create'] }}</button>
                                            <button  @click.prevent="backtolist" type="button" class="btn btn-warning"><i class="fas fa-undo"></i> Faaliyetler Listesine Dön </button>
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
    import moment from 'moment'

    Quill.register("modules/imageDrop", ImageDrop);
    Quill.register("modules/imageResize", ImageResize);

    export default {
        data() {
            return {
                lang: this.$lang,
                date: new Date(),

                options: {
                    format: 'YYYY-MM-DD HH:mm',
                    useCurrent: true,
                    minDate: moment(),
                    showClose:true
                },

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
                url: "/api/activities_image1",
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
            imguploadconfig2: {
                url: "/api/activities_image2",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 2",
                    addRemoveLinks: true
            },
            imguploadconfig3: {
                url: "/api/activities_image3",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 3",
                    addRemoveLinks: true
            },
            imguploadconfig4: {
                url: "/api/activities_image4",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 4",
                    addRemoveLinks: true
            },
            imguploadconfig5: {
                url: "/api/activities_image5",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 5",
                    addRemoveLinks: true
            },
            imguploadconfig6: {
                url: "/api/activities_image6",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 6",
                    addRemoveLinks: false
            },
            imguploadconfig7: {
                url: "/api/activities_image7",
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
                "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 7",
                    addRemoveLinks: true
            },
                imguploadconfig8: {
                    url: "/api/activities_image8",
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
                        "<i class='fas fa-upload'></i>&nbsp;&nbsp;RESİM 8",
                    addRemoveLinks: true
                },

                editmode: false,
                listmode: true,
                addmode: false,
                activities: {},
                localizations: {},
                form: new Form(
                    {
                        id: '',
                        tur: '1',
                        title: '',
                        start_date:'',
                        end_date:'',
                        slug: '',
                        type: '1',
                        meta_title: '',
                        meta_description: '',
                        meta_keywords: '',
                        short_description1: "",
                        short_description2: "",
                        short_description3: "",
                        short_description4: "",
                        short_description5: "",
                        short_description6: "",
                        short_description7: "",
                        short_description8: "",
                        short_description9: "",
                        short_description10: "",
                        link1_text: "",
                        link1_href: "",
                        link2_text: "",
                        link2_href: "",
                        link3_text: "",
                        link3_href: "",
                        link4_text: "",
                        link4_href: "",
                        link5_text: "",
                        link5_href: "",
                        link6_text: "",
                        link6_href: "",
                        photo1: '',
                        picture1: "",
                        picture1_alt: "",
                        picture2: "",
                        picture2_alt: "",
                        picture3: "",
                        picture3_alt: "",
                        picture4: "",
                        picture4_alt: "",
                        picture5: "",
                        picture5_alt: "",
                        picture6: "",
                        picture6_alt: "",
                        picture7: "",
                        picture7_alt: "",
                        picture8: "",
                        picture8_alt: "",
                        description1: "",
                        description2: "",
                        description3: "",
                        description4: "",
                        description5: "",
                        description6: "",
                        description7: "",
                        description8: "",
                        special_code: "",
                        queue: '',
                        language: "",
                        language2: "1",
                        language3: "0",
                        active: '1'
                    }),
                form2: new Form({
                    language2: "1",
                    tur2: "1"
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
                    url: "/api/activities_image_editor",
                    method: "POST",
                    data: formData
                })
                    .then(result => {
                        let url = "/img/activities/thumbs/"+result.data.data; // Get url from response
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
                console.log("Photo1:" + response.data);
                this.form.picture1 = response.data;
            },
            picture2complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo2:" + response.data);
                this.form.picture2 = response.data;
            },
            picture3complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo3:" + response.data);
                this.form.picture3 = response.data;
            },
            picture4complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo4:" + response.data);
                this.form.picture4 = response.data;
            },
            picture5complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo5:" + response.data);
                this.form.picture5 = response.data;
            },
            picture6complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo6:" + response.data);
                this.form.picture6 = response.data;
            },
            picture7complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo7:" + response.data);
                this.form.picture7 = response.data;
            },
            picture8complete(file) {
                let response = JSON.parse(file.xhr.response);
                console.log("Photo8:" + response.data);
                this.form.picture8 = response.data;
            },

            getResults(page = 1) {
                axios.get('/api/activities?page=' + page)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            uprecords(id) {
                axios({
                    url: "/api/activitiesup/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'activities order updated',
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
                    url: "/api/activitiesdown/",
                    method: "POST",
                    data: {
                        id:id
                    }
                })
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'activities order updated',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                        toast.fire("Failed","There was an error","warning");

                    });

            },

            updateactivities() {
                this.$Progress.start();

                //console.log('editing data');

                this.form.put('/api/activities/'+this.form.id)
                    .then(() => {
                        toast.fire(
                            'Updated!',
                            'activities has been updated',
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
            createactivities() {
                this.$Progress.start();
                this.form.post('/api/activities')
                    .then(({ data }) => {
                        // form başarılıysa buraya girecek.
                        //console.log(data);
                        this.form.reset();﻿
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'activities created successfully'
                        });
                        this.$Progress.finish();

                    })
                    .catch(()=> {
                        // formda hata varsa buraya girecek.
                        this.$Progress.fail();
                    })

            },
            editForm(activities) {
                this.listmode= false;
                this.addmode= true;
                this.editmode = true;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();
                this.tmplang = this.form2.language2;
                this.form.reset();
                this.form.language = this.tmplang;
                this.form.fill(activities);
                this.form2.language2 = this.form.language;

            },
            newForm() {
                this.listmode= false;
                this.addmode= true;
                this.editmode = false;
                this.$refs.myVueDropzone1.removeAllFiles();
                this.$refs.myVueDropzone2.removeAllFiles();
                this.$refs.myVueDropzone3.removeAllFiles();
                this.$refs.myVueDropzone4.removeAllFiles();

                this.tmplang = this.form2.language2;
                this.tmptur = this.form.tur2;
                this.form.reset();
                this.form.language = this.tmplang;
                this.form2.language2 = this.form.language;
            },
            backtolist() {
                this.listmode= true;
                this.addmode= false;
                this.editmode = false;
            },
            deleteactivities(id) {

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
                        this.form.delete('/api/activities/'+id).then(()=>{

                            swal.fire(
                                'Deleted!',
                                'activities has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(()=>{

                            swal.fire("Failed","There was an error","warning");
                        });
                    }
                })

            },
            loadactivities() {
                axios.get('/api/activities').then(({ data})=> (this.activities=data));
            },
            loadactivitiesbylang(id,tur) {
                axios.get('/api/activitiesbylang/'+id + "/" + tur).then(({ data})=> (this.activities=data));
            },
            loadLocalization() {
                axios
                    .get("/api/activelocalizations")
                    .then(({ data }) => (this.localizations = data));
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios
                    .get(
                        "/api/findactivities/" +
                        this.form2.language2 + "/" +
                        this.form2.tur2 +
                        "/?q=" +
                        query
                    )
                    .then((data) => {
                        this.activities = data.data
                    })
                    .catch(() => {
                    })
            })

            this.loadactivitiesbylang(this.form2.language2, this.form2.tur2);
            this.loadLocalization();

            Fire.$on('AfterCreate',() => {
                this.loadactivitiesbylang(this.form2.language2, this.form2.tur2);
                this.listmode = true;
                this.addmode = false;
                this.editmode = false;
            })
        }
    }
</script>
