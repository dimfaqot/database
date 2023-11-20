<script>
    let controller = "<?= url(); ?>";
    let sub_menu = "<?= (url() == 'santri' && url(4) == 'detail' ? url(14) : url(13)); ?>";
    let cols_update = <?= (url(4) == 'detail' ? json_encode($cols) : json_encode([])); ?>

    let fields = [];
    if (controller == 'karyawan') {
        fields = ['tahun_masuk', 'nama', 'gender', 'sub'];
    }
    if (controller == 'recruitment') {
        fields = ['tahun_masuk', 'nama', 'hp', 'gender', 'sub', 'bidang_pekerjaan'];
    }
    if (controller == 'santri') {
        fields = ['tahun_masuk', 'nama', 'hp_ayah', 'gender', 'sub', 'pondok'];
    }
    if (controller == 'ppdb') {
        fields = ['tahun_masuk', 'nama', 'hp_ayah', 'gender', 'sub', 'pondok'];
    }

    if (sub_menu !== '') {
        if (sub_menu == 'Profile') {
            fields = cols_update;
            if (controller == 'santri') {
                fields = remove_array_by_value(fields, ['email', 'hp', 'nisn', 'no_induk', 'ikut_bpjs_kes', 'ikut_bpjs_ket', 'nik']);
            }
        }
        if (sub_menu == 'Perwalian') {
            fields = cols_update;
            fields = remove_array_by_value(fields, ['nisn', 'no_induk', 'no_induk', 'no_kk', 'nama', 'nama_wali', 'nik_ayah', 'nik_ibu', 'hp_wali', 'alamat_wali']);
        }
        if (sub_menu == 'Riwayat') {
            fields = cols_update;
            fields = remove_array_by_value(fields, ['no_id', 'nama', 'tahun_keluar']);
        }

    }

    // function untuk mngecek saat pertama kali load dan 
    // mengecek semua inputan saat salah satu inputan diproses
    const check_cols_to_change_submit = () => {

        let x = 0; //check setelah salah satu diinput

        // check pertama load
        for (let i = 0; i < fields.length; i++) {
            let val = $('.check_' + fields[i]).val();
            let placeholder = $('.check_' + fields[i]).attr('placeholder');

            if (val == '' || val == 0) {
                gagal_check(fields[i], placeholder + ' harus diisi!.');
                x = 1;
            } else {
                default_check(fields[i]);
            }
        }

        if (x == 0) {
            $('.btn_check').attr('type', 'submit');
        } else {
            $('.btn_check').attr('type', 'button');
        }

    }
    check_cols_to_change_submit();


    // triger input
    for (let i = 0; i < fields.length; i++) {
        let event = 'keyup';
        if (fields[i] == 'sub' || fields[i] == 'gender' || fields[i] == 'pondok' || fields[i] == 'bidang_pekerjaan') {
            event = 'change';
        }

        $(document).on(event, '.check_' + fields[i], function(e) {
            e.preventDefault();
            let val = $(this).val();

            if (val == '') {
                gagal_check(fields[i], $(this).attr('placeholder') + ' harus diisi!.');
            } else {
                check_cols_to_change_submit();
            }
        })

    }




    $(document).on('keyup', '.check_no_id', function(e) {
        e.preventDefault();
        let val = $(this).val();
        let db = '<?= get_db(menu()['tabel']); ?>';
        let tabel = $(this).data('tabel');
        let id = $(this).data('id');

        let digits = <?= (get_db(menu()['tabel']) == 'karyawan' ? 9 : 6); ?>;
        if (val.length !== digits) {
            gagal_check('no_id', 'No. id harus ' + digits + ' digit!.');
            return false;
        }
        post("check_no_id", {
            val,
            id,
            db,
            tabel
        }).then((res) => {
            if (res.status == '200') {
                check_sukses('no_id', 'No. id tersedia');
            } else {
                gagal_check('no_id', res.message);
            }
        })

    });

    let hps = ['hp', 'hp_ayah', 'hp_ibu', 'hp_wali'];

    for (let i = 0; i < hps.length; i++) {
        $(document).on('keyup', '.check_' + hps[i], function(e) {
            e.preventDefault();
            let val = $(this).val();
            if (val.charAt(0) !== "0") {
                gagal_check(hps[i], upper_first(str_replace("_", " ", hps[i])) + ' Digit pertama harus 0(nol)!.');
            } else {
                if (val.length < 10) {
                    gagal_check(hps[i], upper_first(str_replace("_", " ", hps[i])) + ' Jumlah digit kurang!.');
                } else {
                    sukses_check(hps[i], '');
                }

            }
        })

    }
    $(document).on('keyup', '.check_email', function(e) {
        e.preventDefault();
        let val = $(this).val();

        if (val == '') {
            default_check('email');
            return false;
        }

        if (validateEmail(val) === false) {
            gagal_check('email', 'Email tidak valid!.');
        } else {
            sukses_check('email', 'Email valid.');
        }
    })
    $(document).on('keyup', '.check_kode_pos', function(e) {
        e.preventDefault();
        let val = $(this).val();

        if (val.length !== 5) {
            gagal_check('kode_pos', 'Kode pos tidak valid!');
        } else {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
            sukses_check('kode_pos', 'Kode pos valid!');
            check_cols_to_change_submit();
        }
    })

    $(document).on('keyup', '.check_nama', function(e) {
        e.preventDefault();
        let val = $(this).val();

        if (val == '') {
            gagal_check('nama', 'Nama harus diisi!.');
        } else {
            default_check('nama');
        }
    })


    <?php if (url() !== 'home' && url() !== 'pemilu' && array_key_exists('tahun', $data)) : ?>
        let tahuns = ['tahun_masuk', 'tahun_keluar'];
        let tahun_masuk = '<?= (array_key_exists('tahun_masuk', $data) ? $data['tahun_masuk'] : null); ?>';

        for (let i = 0; i < tahuns.length; i++) {
            $(document).on('keyup', '.check_' + tahuns[i], function(e) {
                e.preventDefault();
                let val = $(this).val();

                if (check_tahun(tahuns[i], val, (tahun_masuk == null ? undefined : tahun_masuk)) == 0) {
                    check_cols_to_change_submit();
                    sukses_check(tahuns[i], '');
                }
            })

        }
    <?php endif; ?>




    $(document).on('keyup', '.check_kota_lahir', function(e) {
        e.preventDefault();
        let val = $(this).val();

        post('indonesia', {
                val,
                order: 'kota_lahir',
                id: 0
            })
            .then(res => {
                if (res.status == '200') {
                    let html = '';

                    html += '<li class="text-center text-dark" style="border-bottom:1px solid black;"><a class="dropdown-item clear_list" data-order="kota_lahir" href="#"><i class="fa-solid fa-xmark"></i> Cancel</a></li>'
                    if (res.data.length == 0) {
                        html += '<li class="text-danger" style="font-style:italic;"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!</li>';
                    } else {
                        for (let d = 0; d < res.data.length; d++) {
                            html += '<li><a class="dropdown-item insert_kota_lahir" data-id="' + res.data[d].id + '" data-order="kota_lahir" href="#">' + upper_first(res.data[d].name.toLowerCase()) + '</a></li>';
                        };
                    }
                    $('.body_list_kota_lahir').html(html);
                    $('.body_list_kota_lahir').addClass('d-block');

                } else {
                    gagal(res.message);
                }

            })
    })

    $(document).on('click', '.clear_list', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        $('.body_list_' + order).html('');
        $('.body_list_' + order).removeClass('d-block');

    })

    $(document).on('click', '.insert_kota_lahir', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        let val = $(this).text();

        $('.check_' + order).val(val);
        $('.body_list_' + order).html('');
        $('.body_list_' + order).removeClass('d-block');

    })


    // ALAMAT

    let tabel_id = undefined;
    let arr = ['alamat', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'];

    let check_all = () => {
        let x = 0;

        for (let i = 0; i < arr.length; i++) {
            if ($('.check_' + arr[i]).val() == '' || $('.check_' + arr[i]).val() == 0) {
                x = 1;
            }
        }

        return x;
    }

    for (let i = 0; i < arr.length; i++) {

        if ($('.check_' + arr[i]).val() == '') {
            gagal_check(arr[i], upper_first(str_replace("_", " ", arr[i])) + ' harus diisi!.');
        }

        $(document).on('keyup', '.check_' + arr[i], function(e) {
            e.preventDefault();

            let val = $(this).val();
            if (arr[i] == 'alamat') {
                if (val == '') {
                    gagal_check(arr[i], 'Alamat harus diisi!.');
                } else {
                    sukses_check(arr[i], '');
                }
            } else {


                if (val == '') {
                    gagal_check(arr[i], upper_first(str_replace("_", " ", arr[i])) + ' harus diisi!.');
                } else {




                    if (arr[i] == 'kabupaten' && tabel_id == undefined) {
                        gagal('Ulangi masukkan provinsi!.');
                    }
                    if (arr[i] == 'kecamatan' && tabel_id == undefined) {
                        gagal('Ulangi masukkan kabupaten!.');
                    }
                    if (arr[i] == 'kelurahan' && tabel_id == undefined) {
                        gagal('Ulangi masukkan kecamatan!.');
                    }

                    sukses_check(arr[i], '');

                    post('indonesia', {
                            val,
                            order: arr[i],
                            id: tabel_id
                        })
                        .then(res => {
                            if (res.status == '200') {
                                let html = '';

                                html += '<li class="text-center text-dark" style="border-bottom:1px solid black;"><a class="dropdown-item clear_search" data-order="' + arr[i] + '" href="#"><i class="fa-solid fa-xmark"></i> Cancel</a></li>'
                                if (res.data.length == 0) {
                                    html += '<li class="text-danger" style="font-style:italic;"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!</li>';
                                } else {
                                    for (let d = 0; d < res.data.length; d++) {
                                        html += '<li><a class="dropdown-item insert_indonesia" data-id="' + res.data[d].id + '" data-order="' + arr[i] + '" href="#">' + upper_first(res.data[d].name.toLowerCase()) + '</a></li>';
                                    };
                                }
                                $('.body_search_' + arr[i]).html(html);
                                $('.body_search_' + arr[i]).addClass('d-block');

                            } else {
                                gagal(res.message);
                            }

                        })
                }
            }

        })

    }


    $(document).on('click', '.clear_search', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        $('.body_search_' + order).html('');
        $('.body_search_' + order).removeClass('d-block');

        if (order == 'provinsi') {
            if ($('.check_provinsi').val() == '') {
                gagal_check('provinsi', 'Provinsi harus diisi!.');

                $('.check_kabupaten').prop('disabled', true);
                gagal_check('kabupaten', 'Kabupaten harus diisi!.');

                $('.check_kecamatan').prop('disabled', true);
                gagal_check('kecamatan', 'Kecamatan harus diisi!.');

                $('.check_kelurahan').prop('disabled', true);
                gagal_check('kelurahan', 'Kelurahan harus diisi!.');

                $('.btn_update').attr('type', 'button');
            } else {
                $('.check_kabupaten').prop('disabled', false);
                sukses_check('provinsi', '');
            }

            if ($('.check_provinsi').val() !== '' && $('.check_kabupaten').val() !== '' && $('.check_kecamatan').val() !== '' && $('.check_kelurahan').val() !== '' && $('.check_alamat').val() !== '' && $('.check_kode_pos').val() !== '') {
                $('.btn_update').attr('type', 'submit');
            }
        }
        if (order == 'kabupaten') {
            if ($('.check_kabupaten').val() == '') {
                gagal_check('kabupaten', 'Kabupaten harus diisi!.');

                $('.check_kecamatan').prop('disabled', true);
                gagal_check('kecamatan', 'Kecamatan harus diisi!.');

                $('.check_kelurahan').prop('disabled', true);
                gagal_check('kelurahan', 'Kelurahan harus diisi!.');

                $('.btn_update').attr('type', 'button');
            } else {
                $('.check_kecamatan').prop('disabled', false);
                sukses_check('kecamatan', '');
            }
        }
        if (order == 'kecamatan') {
            if ($('.check_kecamatan').val() == '') {
                gagal_check('kecamatan', 'Kecamatan harus diisi!.');

                $('.check_kelurahan').prop('disabled', true);
                gagal_check('kelurahan', 'Kelurahan harus diisi!.');

                $('.btn_update').attr('type', 'button');
            } else {
                $('.check_kelurahan').prop('disabled', false);
                sukses_check('kelurahan', '');
            }
        }

        if (order == 'kelurahan') {
            if ($('.check_kelurahan').val() == '') {
                gagal_check('kelurahan', 'Kelurahan harus diisi!.');

                $('.btn_update').attr('type', 'button');
            }
        }

    })

    $(document).on('click', '.insert_indonesia', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        let val = $(this).text();
        let id = $(this).data('id');
        tabel_id = id;


        $('.check_' + order).val(val);


        if (order == 'provinsi') {
            sukses_check('provinsi', '');
            $('.check_kabupaten').prop('disabled', false);
            $('.btn_update').attr('type', 'button');

        }
        if (order == 'kabupaten') {
            sukses_check('kabupaten', '');
            $('.check_kecamatan').prop('disabled', false);
            $('.btn_update').attr('type', 'button');

        }
        if (order == 'kecamatan') {
            sukses_check('kecamatan', '');
            $('.check_kelurahan').prop('disabled', false);

            $('.btn_update').attr('type', 'button');

        }
        if (order == 'kelurahan') {
            sukses_check('kelurahan', '');

            $('.btn_update').attr('type', 'button');

        }


        $('.body_search_' + order).html('');
        $('.body_search_' + order).removeClass('d-block');


        if ($('.check_provinsi').val() !== '' && $('.check_kabupaten').val() !== '' && $('.check_kecamatan').val() !== '' && $('.check_kelurahan').val() !== '' && $('.check_alamat').val() !== '' && $('.check_kode_pos').val() !== '') {
            $('.btn_update').attr('type', 'submit');
        }


    })

    if ($('.check_provinsi').val() == '') {
        $('.check_kabupaten').prop('disabled', true);
        $('.check_kecamatan').prop('disabled', true);
        $('.check_kelurahan').prop('disabled', true);
        $('.btn_update').attr('type', 'button');
    }



    if ($('.check_kode_pos').val() == '' || $('.check_kode_pos').val() == '0') {
        gagal_check('kode_pos', 'Kode pos harus diisi!.');
        $('.btn_update').attr('type', 'button');
    }


    // BERKAS
    $(document).on('change', '.file', function(e) {
        e.preventDefault();
        let col = $(this).data('col');
        let exe = get_file($(this).val(), 'exe');

        if (col == 'cv' || col == 'sp' || col == 'kontrak') {
            if (exe == 'pdf') {
                $('.line_warning_' + col).removeClass('line_danger');
                $('.body_warning_' + col).html('');
                $('.btn_' + col).attr('type', 'submit');
                if (this.files[0].size > 2000000) {
                    $('.line_warning_' + col).addClass('line_danger');
                    $('.body_warning_' + col).html('<i class="fa-solid fa-circle-exclamation"></i> File terlalu besar. Ukuran maksima 2 MB!.');
                    $('.btn_' + col).attr('type', 'button');
                }
            } else {
                $('.line_warning_' + col).addClass('line_danger');
                $('.body_warning_' + col).html('<i class="fa-solid fa-circle-exclamation"></i> File harus pdf!.');
                $('.btn_' + col).attr('type', 'button');
            }
        } else {
            if (exe !== 'jpg' && exe !== 'jpeg' && exe !== 'png') {
                $('.line_warning_' + col).addClass('line_danger');
                $('.body_warning_' + col).html('<i class="fa-solid fa-circle-exclamation"></i> File harus jpg atau jpeg atau png!.');
                $('.btn_' + col).attr('type', 'button');
            } else {
                $('.line_warning_' + col).removeClass('line_danger');
                $('.body_warning_' + col).html('');
                $('.btn_' + col).attr('type', 'submit');
                if (this.files[0].size > 2000000) {
                    $('.line_warning_' + col).addClass('line_danger');
                    $('.body_warning_' + col).html('<i class="fa-solid fa-circle-exclamation"></i> File terlalu besar. Ukuran maksima 2 MB!.');
                    $('.btn_' + col).attr('type', 'button');
                }
            }
        }


    })


    // PENDIDIKAN
    // load pertama kali jika kampus diisi maka jika lainnya kosong akan error
    for (let i = 1; i < 4; i++) {
        if ($('.check_kampus_s' + i).val() !== '' && $('.check_fakultas_s' + i).val() == '') {
            gagal_check('fakultas_s' + i, 'Fakultas S' + i + ' harus diisi!.');
        }
        if ($('.check_kampus_s' + i).val() !== '' && $('.check_jurusan_s' + i).val() == '') {
            gagal_check('jurusan_s' + i, 'Jurusan S' + i + ' harus diisi!.');
        }
        if ($('.check_kampus_s' + i).val() !== '' && $('.check_ipk_s' + i).val() == '0.00') {
            gagal_check('ipk_s' + i, 'Ipk S' + i + ' harus diisi!.');
        }
        if ($('.check_kampus_s' + i).val() !== '' && $('.check_gelar_s' + i).val() == '') {
            gagal_check('gelar_s' + i, 'Gelar S' + i + ' harus diisi!.');
        }
    }

    let label = ['kampus', 'fakultas', 'jurusan', 'ipk', 'gelar'];


    // jika keyup dan value tidak kosong maka berubah hijau
    for (let i = 0; i < label.length; i++) {
        for (let x = 1; x < 4; x++) {

            $(document).on('keyup', '.check_' + label[i] + "_s" + x, function(e) {
                e.preventDefault();
                let value = $(this).val();

                if (value == '') {
                    gagal_check(label[i] + '_s' + x, upper_first(label[i]) + ' S' + x + ' harus diisi!.');

                    // jika val kosong dan seluruhnya kosong maka kembali ke default
                    for (let l = 0; l < label.length; l++) {

                        for (let y = 1; y < 4; y++) {
                            if (x == y) {
                                let cek = 0;
                                if (label[i] !== label[l]) {
                                    let val = $('.check_' + label[l] + "_s" + y).val();

                                    if (label[l] == 'ipk' && val !== '0.00') {

                                        cek = 1;
                                    } else {
                                        if (val !== '') {
                                            cek = 1;

                                        }
                                    }
                                }


                                if (cek == 0) {
                                    for (let e = 0; e < label.length; e++) {
                                        default_check(label[e] + '_s' + y);
                                        $('.btn_update').attr('type', 'submit');
                                    }
                                }

                                return false;
                            }

                        }


                    }


                } else {
                    sukses_check(label[i] + '_s' + x, '');
                    $('.btn_update').attr('type', 'submit');
                    // jika keyup salah satu input maka jika yang lainnya kosong akan merah
                    for (let l = 0; l < label.length; l++) {

                        for (let y = 1; y < 4; y++) {
                            if (x == y) {
                                if (label[i] !== label[l]) {
                                    let val = $('.check_' + label[l] + "_s" + y).val();

                                    if (label[l] == 'ipk' && val == '0.00') {

                                        gagal_check(label[l] + '_s' + y, upper_first(label[l]) + ' S' + y + ' harus diisi!.');
                                    } else {
                                        if (val == '') {
                                            gagal_check(label[l] + '_s' + y, upper_first(label[l]) + ' S' + y + ' harus diisi!.');

                                        }
                                    }
                                }
                            }

                        }

                    }
                }
            });

        }
    }

    // check format ipk
    for (let i = 1; i < 4; i++) {

        $(document).on('keyup', '.check_ipk_s' + i, function(e) {
            e.preventDefault();
            let val = $(this).val();
            if (val.length !== 4) {
                gagal_check('ipk_s' + i, 'Format ipk salah!. Contoh yang benar: <span style="font-weight:bold">3.00</span>');
            }

            let split = val.split('.');
            if (split.length !== 2) {
                gagal_check('ipk_s' + i, 'Format ipk salah!. Harus angka desimal dengan pemisah titik. Contoh yang benar: <span style="font-weight:bold">3.00</span>');
            } else {
                if (split[0].length !== 1) {
                    gagal_check('ipk_s' + i, 'Format ipk salah!. Angka sebelum titik harus 1(satu) digit. Contoh yang benar: <span style="font-weight:bold">3.00</span>');
                }
                if (split[1].length !== 2) {
                    gagal_check('ipk_s' + i, 'Format ipk salah!. Angka setelah titik harus 2(dua) digit. Contoh yang benar: <span style="font-weight:bold">3.00</span>');
                }
                if (split[0] > 4) {
                    gagal_check('ipk_s' + i, 'Format ipk salah!. Angka sebelum titik maksimal 4(Empat). Contoh yang benar: <span style="font-weight:bold">3.00</span>');
                }
            }

            if (val.charAt(0) < 2) {
                gagal_check('ipk_s' + i, 'Format ipk salah!. Digit pertama minimal 2(dua). Contoh yang benar: <span style="font-weight:bold">3.00</span>');
            }

        })

    }

    // wali


    let cols = ['nama_wali', 'hp_wali', 'alamat_wali'];
    const check_wali = () => {
        let x = 0;
        for (let i = 0; i < cols.length; i++) {
            let val = $('.check_' + cols[i]).val();

            if (val == '' || val == 0) {
                gagal_check(cols[i], $('.check_' + cols[i]).attr('placeholder') + ' harus diisi!.');
                x = 1;
            }
        }
        if (x == 1) {
            $('.btn_check').attr('type', 'button');
        }

        return x;

    }

    for (let i = 0; i < cols.length; i++) {

        $(document).on('keyup', '.check_' + cols[i], function(e) {
            e.preventDefault();
            let val = $(this).val();

            if (val == '') {
                check_wali();
            } else {
                if (check_wali() == 0) {
                    default_check(cols[i]);
                    $('.btn_check').attr('type', 'submit');
                    check_cols_to_change_submit();
                }

            }

        })

    }


    // cek no sk no_sk
    $(document).on('keyup', '.check_no_sk', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let tabel = $(this).data('tabel');
        let order = $(this).data('order');
        let val = $('.update_no_sk_' + id).text();

        if (order == 'detail') {
            val = $(this).val();
        } else {
            $('.alert_' + id).removeClass('d-none');
            $('.alert_' + id).addClass('show_alert_sk');

        }
        post('check_no_sk', {
                id,
                val
            })
            .then(res => {
                let html = '';
                if (res.status == '200') {
                    if (order == 'detail') {
                        sukses_check('no_sk', 'No. Sk tersedia.');
                        $('.btn_check').attr('type', 'submit');
                    } else {
                        html += res.message;
                    }

                } else {
                    if (order == 'detail') {
                        gagal_check('no_sk', res.message);
                        return false;
                    } else {
                        html += '<small class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> ' + res.message + '</small>';
                    }
                }
                $('.body_alert_no_sk_' + id).html(html);
            })

    })
    // update_no_sk
    $(document).on('click', '.update_no_sk', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let value = $(this).data('value');

        post('<?= url(); ?>/update_no_sk', {
                id,
                value
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    gagal(res.message);
                }
            })

    })
</script>