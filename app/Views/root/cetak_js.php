<script>
    const get_table = (db) => {
        post("cetak/db", {
            db
        }).then((res) => {
            if (res.status == '200') {
                let html = '';
                html += '<div class="card-body">';
                html += '<h5 class="btn_main_inactive" style="border-radius: 3px;"><i class="fa-solid fa-server"></i> TABLES</h5>';

                html += '<div class="row g-2">'; //row
                for (let i = 0; i < res.data.length; i++) {
                    html += '<div class="col-6 col-md-2">';
                    html += '<div class="form-check form-check-inline form-switch">';
                    html += '<input class="form-check-input get_table" type="radio" value="' + res.data[i] + '" name="table" role="switch" ' + (res.data[i] == res.data2 ? 'checked' : '') + '>';
                    html += '<label class="form-check-label">' + upper_first(str_replace("_", " ", res.data[i])) + '</label>';
                    html += '</div>';
                    html += '</div>';
                }
                html += '</div>'; //row end

                html += '</div>';

                $('.body_tables').html(html);

                get_columns(res.data2, db)
            } else {
                gagal(res.message);
            }
        })
    }
    let arr_cols = [];
    let col_id = 'id';
    const get_columns = (table, db) => {
        if (db == undefined) {
            db = $('input[name="database"]:checked').val();
        }
        post("cetak/col", {
            table,
            db
        }).then((res) => {
            if (res.status == '200') {
                let html = '';
                html += '<div class="card-body">';

                html += '<div class="btn_main_inactive mb-2 py-0 d-flex gap-2" style="border-radius: 3px;font-size:12px;">';
                html += '<h5 style="font-size:12px;padding-top:6px;padding-bottom:-7px;"><i class="fa-solid fa-server"></i> COLUMNS</h5>';
                if (table == 'recruitment' || table == 'karyawan') {
                    html += '<div class="form-check form-check-inline" style="padding-top:4px;">';
                    html += '<input class="form-check-input nama_gelar" type="checkbox">';
                    html += '<label class="form-check-label">Nama dan Gelar</label>';
                    html += '</div>';
                }

                html += '</div>';
                html += '<div class="row g-2">'; //row
                for (let i = 0; i < res.data.length; i++) {
                    if (res.data[i] !== 'created_at' && res.data[i] !== 'updated_at' && res.data[i] !== 'petugas' && res.data[i] !== 'deleted' && res.data[i] !== 'id') {
                        html += '<div class="col-6 col-md-2">';
                        html += '<div class="form-check form-check-inline form-switch">';
                        html += '<input class="form-check-input col_' + (res.data[i] == 'no_id' ? 'no_id' : (res.data[i] == 'no' ? 'no' : '')) + ' get_col" type="checkbox" name="column" value="' + res.data[i] + '" role="switch" ' + (res.data[i] == res.data2 ? 'checked' : '') + '>';
                        html += '<label class="form-check-label">' + upper_first(str_replace("_", " ", res.data[i])) + '</label>';
                        html += '</div>';
                        html += '</div>';

                    }
                }
                html += '</div>'; //end row

                html += '</div>';

                $('.body_columns').html(html);

                get_filter(table);
            } else {
                gagal(res.message);
            }
        })
    }

    const template = (data, table) => {
        let html = '';
        if (data.length > 0) {
            html += '<div class="card-body">';
            html += '<h5 class="btn_main_inactive" style="border-radius: 3px;"><i class="fa-solid fa-server"></i> FILTERS</h5>';
            html += '<div class="row g-2">'
            for (let i = 0; i < data.length; i++) {
                html += '<div class="col-md-4">';

                html += '<div class="card">';
                html += '<div class="card-header py-1" style="font-weight:bold;">';
                html += upper_first(str_replace("_", " ", data[i].filter));
                html += '</div>';
                html += '<div class="card-body">';
                if (data[i].filter == 'alamat') {
                    for (let d = 0; d < data[i].detail.length; d++) {
                        html += '<div class="mb-1">';
                        html += '<input type="text" class="form-control form-control-sm ' + data[i].detail[d].order + ' filter filter_' + data[i].filter + '_' + data[i].detail[d].order + '" data-filter="' + data[i].filter + '" value="" data-order="' + data[i].detail[d].order + '" placeholder="' + upper_first(str_replace("_", " ", data[i].detail[d].order)) + '">';

                        html += '<ul class="p-1 dropdown-menu body_filter_' + data[i].detail[d].order + '" style="font-size:small;">';

                        html += '<li class="text-center text-dark" style="border-bottom:1px solid black;"><a class="dropdown-item cancel_filter" data-filter="' + data[i].filter + '" data-order="' + data[i].detail[d].order + '" href="#"><i class="fa-solid fa-xmark"></i> Cancel</a></li>'
                        if (data[i].detail[d].data.length == 0) {
                            html += '<li class="text-danger" style="font-style:italic;"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!</li>';
                        } else {
                            for (let dt = 0; dt < data[i].detail[d].data.length; dt++) {
                                let name = data[i].detail[d].data[dt].name;
                                html += '<li><a class="dropdown-item insert_filter value_filter_' + data[i].detail[d].order + '" data-filter="' + data[i].filter + '" data-order="' + data[i].detail[d].order + '" href="#">' + name + '</a></li>';
                            };
                        }
                        html += '</ul>';
                        html += '</div>';
                    }
                } else if (data[i].filter == 'sub' || data[i].filter == 'status' || data[i].filter == 'gender' || data[i].filter == 'kategori' || data[i].filter == 'jenis' || data[i].filter == 'pondok' || data[i].filter == 'ekstra' || data[i].filter == 'ikut_bpjs_kes' || data[i].filter == 'ikut_bpjs_ket') {
                    html += '<div class="row g-2">'; //row
                    for (let d = 0; d < data[i].detail.length; d++) {
                        html += '<div class="col-6 col-md-' + (data[i].filter == 'sub' && table == 'sk' ? '12' : (data[i].filter == 'kategori' && table == 'pilangsari' ? '6' : '3')) + '">';
                        html += '<div class="form-check form-check-inline form-switch">';
                        html += '<input class="form-check-input filter_detail_' + data[i].filter + '" value="' + (data[i].filter == 'sub' ? (table == 'sk' ? data[i].detail[d].sub : data[i].detail[d].singkatan) : (data[i].filter == 'status' ? data[i].detail[d].value : (data[i].filter == 'kategori' ? data[i].detail[d].kategori : (data[i].filter == 'ekstra' ? data[i].detail[d].ekstra : data[i].detail[d])))) + '" type="checkbox" name="' + data[i].filter + '" role="switch">';
                        html += '<label class="form-check-label">' + (data[i].filter == 'sub' ? (table == 'sk' ? data[i].detail[d].sub : data[i].detail[d].singkatan) : (data[i].filter == 'status' ? data[i].detail[d].value : (data[i].filter == 'kategori' ? data[i].detail[d].kategori : (data[i].filter == 'ekstra' ? data[i].detail[d].ekstra : data[i].detail[d])))) + '</label>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>';
                } else {
                    html += '<div class="row g-2">'; //row
                    for (let d = 0; d < data[i].detail.length; d++) {
                        html += '<div class="col-6 col-md-3">';
                        html += '<div class="form-check form-check-inline form-switch">';
                        html += '<input class="form-check-input filter_detail filter_detail_' + data[i].filter + '" type="radio" name="' + data[i].filter + '" value="' + data[i].detail[d] + '" role="switch">';
                        html += '<label class="form-check-label">' + upper_first(data[i].detail[d]) + '</label>';
                        html += '</div>';
                        html += '</div>';
                        if (data[i].detail[d] == 'filter') {
                            html += '<div style="display:none;" class="input-group input-group-sm body_filter_detail_' + data[i].filter + '">';
                            html += '<span class="input-group-text">Dari</span>';
                            html += '<input type="number" class="form-control dari_' + data[i].filter + '" placeholder="Dari">';
                            html += '<span class="input-group-text">Sampai</span>';
                            html += '<input type="number" class="form-control sampai_' + data[i].filter + '" placeholder="Sampai">';
                            html += '</div>';

                        }
                    }
                    html += '</div>';

                }
                html += '</div>';
                html += '</div>';

                html += '</div>';
            }

            html += '</div>';
            html += '</div>';

        }

        $('.body_filter').html(html);
    }
    let attr_filter = [];
    const get_filter = (table) => {

        if (table == undefined) {
            table = $('input[name="table"]:checked').val();

        }

        post("cetak/filter", {
            table
        }).then((res) => {
            if (res.status == '200') {
                col_id = res.data2;
                template(res.data, table);
                attr_filter = res.data;
            } else {
                gagal(res.message);
            }
        })
    }


    const body_data = (cols, data, col, tabel, is_sertifikat, column_id) => {
        arr_cols = cols;
        col_id = column_id;
        let html = '';
        html += '<div class="btn_main sticky-top" style="border-radius: 0px;">';
        html += '<div class="d-flex justify-content-between">';
        html += '<h6 style="font-size: small;margin-top:8px;"><i class="fa-solid fa-print"></i> Cetak Data</h6>';
        html += '<a style="margin-top:5px;" type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark"></i></a>';
        html += '</div>';

        html += '<div class="d-flex justify-content-between">';
        html += '<div class="d-flex gap-2" style="font-size: small;">';

        // __________________________
        html += '<div class="d-flex gap-2 body_filter_cetak d-none" style="font-size: small;">';
        html += '<a href="" style="padding-top:5px;" class="btn_bright_sm check_all"><i class="fa-solid fa-list-check"></i> Check All</a>';
        html += '<a href="" style="padding-top:5px;" class="btn_bright_sm download" data-order="excel"><i class="fa-solid fa-file-excel"></i> Excel</a>';
        html += '<a href="" style="padding-top:5px;" class="btn_bright_sm download" data-order="pdf"><i class="fa-regular fa-file-pdf"></i> Pdf</a>';
        if (is_sertifikat == 'yes') {
            html += '<a style="padding-top:5px;" href="" class="btn_bright_sm download" data-order="sertifikat"><i class="fa-solid fa-award"></i> ' + tabel + '</a>';
        }
        html += '<a style="padding-top:5px;" href="" class="btn_bright_sm text-danger remove_lists"><i class="fa-solid fa-circle-xmark"></i> Del</a>';
        html += '</div>';
        // __________________________

        html += '<div class="d-flex gap-2">';
        html += '<div class="cari_cetak px-2" style="width:120px;border:1px solid #94c1ca; border-radius:4px;" contenteditable>Cari data ...</div>';
        html += ' <a href="" style="color:#effbfd; text-decoration:none;" class="show_all"><i class="fa-regular fa-eye"></i></a>';
        html += ' <a href="" style="color:#effbfd; text-decoration:none;" class="reset"><i class="fa-solid fa-rotate-left"></i></a>';
        html += ' <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" href="" style="color:#effbfd; text-decoration:none;"><i class="fa-solid fa-table-cells-large"></i></a>';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input ttd" type="checkbox">';
        html += '<label class="form-check-label">Ttd</label>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div style="font-style: italic;font-size:12px;padding-top:3px;">';
        html += '<span class="jml_data">' + data.length + '</span> from ' + data.length;
        html += '</div>';


        html += '</div>';
        html += '</div>';

        html += '<div style="height: auto;overflow:auto;">';
        html += '<div class="collapse" id="collapseExample">';

        html += '<div class="card card-body">';
        // row
        html += '<div class="row g-2">';

        html += '<div class="col-md-12">';
        html += '<div class="input-group input-group-sm">';
        html += '<input type="text" style="font-size:12px;" placeholder="Judul" class="form-control judul" value="">';
        html += '</div>';
        html += '</div>';


        html += '<div class="col-md-4">';
        html += '<div class="input-group input-group-sm">';
        html += '<input type="text" style="font-size:12px;" placeholder="Lower Kiri" class="form-control lower_kiri" value="">';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-md-4">';
        html += '<div class="input-group input-group-sm">';
        html += '<input type="text" style="font-size:12px;" placeholder="Lower Tengah" class="form-control lower_tengah" value="">';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-md-4">';
        html += '<div class="input-group input-group-sm">';
        html += '<input type="text" style="font-size:12px;" placeholder="Lower Kanan" class="form-control lower_kanan" value="">';
        html += '</div>';
        html += '</div>';



        html += '</div>'; // end row




        html += '<div class="input-group input-group-sm my-2" style="max-width:250px;">';
        html += '<input type="number" style="font-size:12px;" placeholder="Jumlah Kolom" class="form-control jml_kolom" value="">';
        html += '<button class="btn btn-outline-secondary btn_jml_kolom" type="button">Button</button>';
        html += '</div>';

        html += '<div class="custome_header mb-2">';

        html += '</div>';

        html += '<div class="row g-1 body_custome_header">';

        html += '</div>';

        html += '<div class="d-grid mt-3">';
        html += '<button type="button" class="btn-sm btn_main custome_cetak"><i class="fa-solid fa-square-arrow-up-right"></i> Execute</button>';
        html += '</div>';

        html += '</div>'; //end card

        html += '</div>';

        html += '<div class="accordion accordion-flush px-2" id="accordionFlushExample">';

        // item start
        for (let i = 0; i < data.length; i++) {
            let color = (i % 2 == 0 ? 'bg_light' : 'bg_bright');
            html += '<div class="accordion-item list_data list_data_' + i + '" data-value="' + data[i][col] + '">';
            html += '<h6 class="accordion-header" id="flush-headingOne">';
            html += '<div style="font-size: small;padding:3px;" class="collapsed d-flex ' + color + '">';
            html += '<div class="form-check flex-fill" style="max-width: 20px;padding-top:4px;">';
            html += '<input class="form-check-input check_cetak" name="checklist" type="checkbox" value="' + i + '">';
            html += '</div>';
            html += '<div class="flex-fill" type="button" style="padding-top: 5px;" data-bs-toggle="collapse" data-bs-target="#flush-collapse' + i + '" aria-expanded="false" aria-controls="flush-collapse' + i + '">';
            html += data[i][col];
            html += '</div>';
            html += '<div class="flex-fill btn_bright_sm pt-1" style="max-width: 70px;font-size:14px; text-align:center;">';
            html += '<a class="main_color download" data-i="' + i + '" data-id="' + data[i][col_id] + '" href="" data-order="single_pdf"><i class="fa-regular fa-file-pdf"></i></a>';
            if (is_sertifikat == 'yes') {
                html += ' <a href="" class="main_color download" data-id="' + data[i][col_id] + '" data-order="single_sertifikat"><i class="fa-solid fa-award"></i></a>';
            }
            html += ' <a class="danger_color remove_list" data-i="' + i + '" href=""><i class="fa-solid fa-circle-xmark"></i></a>';
            html += '</div>';
            html += '</div>';
            html += '</h6>';
            html += '<div id="flush-collapse' + i + '" style="border:1px solid #57bfd3" class="accordion-collapse collapse bg-white" aria-labelledby="flush-heading' + i + '" data-bs-parent="#accordionFlushExample">';

            // isi start
            html += '<div class="accordion-body">';

            // row
            html += '<div class="row g-2">';
            let show_id = $('.col_' + col_id).prop('checked');

            for (let c = 0; c < cols.length; c++) {
                html += '<div class="col-md-4 ' + (cols[c] == 'id' ? 'd-none' : (cols[c] == col_id && show_id == false ? 'd-none' : '')) + '">';
                html += '<div class="input-group input-group-sm">';
                html += '<span style="width:110px;font-size:12px;" class="input-group-text">' + upper_first(str_replace("_", " ", cols[c])) + '</span>';
                html += '<input type="text" style="font-size:12px;" class="form-control value_' + cols[c] + '_' + i + '" placeholder="' + upper_first(str_replace("_", " ", cols[c])) + '" name="' + cols[c] + '" value="' + data[i][cols[c]] + '">';
                html += '</div>';
                html += '</div>';
            }
            html += '</div>';
            // end row

            html += '</div>';
            // isi end

            html += '</div>';
            html += '</div>';
        }
        // end item

        html += '</div>';
        html += '</div>';

        $('.body_data').html(html);
    }

    const get_costume_cetak = () => {
        let judul = $('.judul').val();
        let lower_kiri = $('.lower_kiri').val();
        let lower_tengah = $('.lower_tengah').val();
        let lower_kanan = $('.lower_kanan').val();
        let jml_kolom = $('.jml_kolom').val();
        let custome_header = $('.get_custome_header').prop('checked');
        let headers = [];
        for (let i = 1; i <= jml_kolom; i++) {
            headers.push($('.judul_header_' + i).val());
        }

        let custome_cetak = {
            judul,
            lower_kiri,
            lower_tengah,
            lower_kanan,
            jml_kolom,
            custome_header,
            headers
        }

        return custome_cetak;

    }


    const get_data = (order) => {
        let db = $('input[name="database"]:checked').val();
        let tabel = $('input[name="table"]:checked').val();

        let cols = [];
        $('input[name="column"]:checked').each(function() {
            cols.push(this.value);
        })

        let filters = [];
        let filter = [];
        for (let i = 0; i < attr_filter.length; i++) {
            if (attr_filter[i].filter !== 'alamat') {
                filter.push(attr_filter[i].filter);
            }
            let val = [];

            if (attr_filter[i].filter == 'tahun' || attr_filter[i].filter == 'umur' || attr_filter[i].filter == 'durasi' || attr_filter[i].filter == 'pengabdian') {
                val.push({
                    value: $('input[name="' + attr_filter[i].filter + '"]:checked').val(),
                    dari: $('.dari_' + attr_filter[i].filter + '').val(),
                    sampai: $('.sampai_' + attr_filter[i].filter + '').val()
                })
            } else {
                $('input[name="' + attr_filter[i].filter + '"]:checked').each(function() {
                    val.push(this.value);
                })

            }

            filters.push({
                filter: attr_filter[i].filter,
                data: val
            });
        }

        let nama_gelar = $('.nama_gelar').prop('checked');
        let provinsi = $('.provinsi').val();
        let kabupaten = $('.kabupaten').val();
        let kecamatan = $('.kecamatan').val();
        let kelurahan = $('.kelurahan').val();

        post("cetak/get_data", {
            db,
            nama_gelar,
            tabel,
            cols,
            filter,
            filters,
            provinsi,
            kabupaten,
            kecamatan,
            kelurahan
        }).then((res) => {
            if (res.status == '200') {
                body_data(res.data.cols, res.data.data, res.data.col, tabel, res.data.is_sertifikat, res.data2);
                let myModal = document.getElementById('cetak');
                let modal = bootstrap.Modal.getOrCreateInstance(myModal)
                modal.show();
            } else {
                gagal(res.message);
            }
        })
    }

    const collect_data = () => {
        let data = [];

        let val = [];
        $('input[name="checklist"]:checked').each(function() {
            val.push(this.value);
        })
        for (let i = 0; i < val.length; i++) {
            let temp_data = {};
            for (let c = 0; c < arr_cols.length; c++) {
                let col = arr_cols[c];
                let value = $('.value_' + col + '_' + val[i]).val();

                temp_data[col] = value;

            }
            data.push(temp_data);

        }


        if (data.length == 0) {
            $('input[name="checklist"]').each(function() {
                val.push(this.value);
            })
            for (let i = 0; i < val.length; i++) {
                let temp_data = {};
                for (let c = 0; c < arr_cols.length; c++) {
                    let col = arr_cols[c];
                    let value = $('.value_' + col + '_' + val[i]).val();

                    temp_data[col] = value;

                }
                data.push(temp_data);

            }
        }

        return data;
    }

    get_table('karyawan');
    get_columns('karyawan');

    $(document).on('click', '.download', function(e) {
        e.preventDefault();
        let tabel = '';
        $('input[name="table"]:checked').each(function() {
            tabel = this.value;
        })
        let order = $(this).data('order');
        let index = $(this).data('i');
        let ttd = ($('.ttd').prop('checked') ? '2' : '1');

        let remove = $('.col_' + col_id).prop('checked');

        let datas = [];

        if (order == 'single_sertifikat') {

            let temp_data = {
                [col_id]: $(this).data('id')
            };
            datas.push(temp_data);
            order = 'sertifikat';
        } else if (order == 'single_pdf') {

            let temp_data = {};
            for (let c = 0; c < arr_cols.length; c++) {
                let col = arr_cols[c];
                let value = $('.value_' + col + '_' + index).val();

                temp_data[col] = value;

            }
            datas.push(temp_data);
            order = 'pdf';
        } else {
            datas = collect_data();
        }

        let data = {
            datas,
            remove,
            ttd,
            tabel,
            cols: arr_cols
        }

        post("encode", {
            data
        }).then((res) => {
            if (res.status == '200') {
                window.open('<?= base_url(); ?><?= menu()['controller']; ?>/cetak/' + order + '/' + res.data, '_blank');
            } else {
                gagal(res.message);
            }
        })
    });

    $(document).on('click', '.custome_cetak', function(e) {
        e.preventDefault();
        let headers = get_costume_cetak();
        let datas = collect_data();
        let tabel = '';
        $('input[name="table"]:checked').each(function() {
            tabel = this.value;
        })
        let ttd = ($('.ttd').prop('checked') ? '2' : '1');
        let remove = $('.col_' + col_id).prop('checked');
        let data = {
            headers,
            remove,
            ttd,
            tabel,
            cols: arr_cols,
            datas
        };


        post("encode", {
            data
        }).then((res) => {
            if (res.status == '200') {
                window.open('<?= base_url(); ?><?= menu()['controller']; ?>/cetak/custome/' + res.data, '_blank');
            } else {
                gagal(res.message);
            }
        })
    });

    $(document).on('click', '.cari_cetak', function(e) {
        e.preventDefault();
        $(this).text('');
    });
    $(document).on('blur', '.cari_cetak', function(e) {
        e.preventDefault();
        $(this).text('Cari data...');
    });
    $(document).on('click', '.show_all', function(e) {
        e.preventDefault();
        $('.list_data').filter(function() {
            $(this).toggle($(this).data('value').toLowerCase().indexOf('') > -1);
        });
    });

    $(document).on('keyup', '.cari_cetak', function(e) {
        e.preventDefault();
        let value = $(this).text().toLowerCase();

        $('.list_data').filter(function() {
            $(this).toggle($(this).data('value').toLowerCase().indexOf(value) > -1);
        });

    });

    $(document).on('change', '.get_db', function(e) {
        e.preventDefault();
        get_table($(this).val());
    });
    $(document).on('change', '.get_table', function(e) {
        e.preventDefault();
        get_columns($(this).val());
    });


    $(document).on('keyup', '.filter', function(e) {
        e.preventDefault();
        let filter = $(this).data('filter');
        let order = $(this).data('order');
        let value = $(this).val().toLowerCase();

        $('.value_filter_' + order).filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        $('.body_filter_' + order).addClass('d-block');

    });

    $(document).on('click', '.cancel_filter', function(e) {
        e.preventDefault();
        let filter = $(this).data('filter');
        let order = $(this).data('order');
        $('.filter_' + filter + '_' + order).val('');
        $('.body_filter_' + order).removeClass('d-block');
    });

    $(document).on('click', '.insert_filter', function(e) {
        e.preventDefault();
        let filter = $(this).data('filter');
        let order = $(this).data('order');
        let value = $(this).text();

        $('.filter_' + filter + '_' + order).val(value);
        $('.body_filter_' + order).removeClass('d-block');
    });

    $(document).on('change', '.filter_detail', function(e) {
        e.preventDefault();

        let filter = $(this).attr('name');
        let value = $(this).val();

        if (value == 'semua') {
            $('.body_filter_detail_' + filter).hide();
        } else {
            $('.body_filter_detail_' + filter).show();
        }
    });
    $(document).on('change', '.check_cetak', function(e) {
        e.preventDefault();
        if ($('.body_filter_cetak').hasClass('d-none')) {
            $('.body_filter_cetak').removeClass('d-none');
            $('.body_filter_cetak').addClass('d-block');
        } else {

            let val = [];
            $('input[name="checklist"]:checked').each(function() {
                val.push(this.value);
            })
            if (val.length == 0) {
                $('.body_filter_cetak').addClass('d-none');
                $('.body_filter_cetak').removeClass('d-block');

            }

        }
    });
    $(document).on('click', '.check_all', function(e) {
        e.preventDefault();
        if ($(this).hasClass('btn_bright_sm')) {
            $('input[name="checklist"]').prop('checked', true);
            $(this).removeClass('btn_bright_sm');
            $(this).addClass('btn_light_sm');
        } else {
            $('input[name="checklist"]').prop('checked', false);
            $(this).addClass('btn_bright_sm');
            $(this).removeClass('btn_light_sm');
            $('.body_filter_cetak').removeClass('d-block');
            $('.body_filter_cetak').addClass('d-none');
        }
    });
    $(document).on('click', '.remove_lists', function(e) {
        e.preventDefault();
        let val = 0;
        $('input[name="checklist"]:checked').each(function() {
            $('.list_data_' + this.value).remove();
            val++;
        })

        let jml_data = $(".jml_data").text();
        $('.jml_data').text(jml_data - val);
    });
    $(document).on('click', '.remove_list', function(e) {
        e.preventDefault();
        let i = $(this).data('i');
        let jml_data = $(".jml_data").text();

        $('.list_data_' + i).remove();
        $('.jml_data').text(jml_data - 1);
    });


    $(document).on('click', '.get_data', function(e) {
        e.preventDefault();
        get_data();
    })
    $(document).on('click', '.reset', function(e) {
        e.preventDefault();
        get_data();
    })
    $(document).on('click', '.btn_jml_kolom', function(e) {
        e.preventDefault();
        let html = '';

        html += '<div class="form-check form-check-inline form-switch">';
        html += '<input class="form-check-input get_custome_header" type="checkbox">';
        html += '<label class="form-check-label">Custome Header</label>';
        html += '</div>';

        $('.custome_header').html(html);
    })

    $(document).on('change', '.get_custome_header', function(e) {
        e.preventDefault();
        let jml_kolom = $('.jml_kolom').val();
        if ($(this).prop('checked')) {
            let html = '';

            for (let i = 1; i <= jml_kolom; i++) {
                html += '<div class="col-md-3">';
                html += '<div class="input-group input-group-sm">';
                html += '<input type="text" style="font-size:12px;" placeholder="Judul Header ' + i + '" class="form-control judul_header_' + i + '" value="">';
                html += '</div>';
                html += '</div>';
            }

            $('.body_custome_header').html(html);
        } else {
            $('.body_custome_header').html('');

        }
    })
</script>