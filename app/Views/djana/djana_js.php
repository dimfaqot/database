<script>
    $(".input_date").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change");

    $(document).on('click', '.get_status', function(e) {
        e.preventDefault();
        let status = $(this).data('status');

        $('.body_get_status').html(status);
        $('.message_info').fadeIn();


        setTimeout(() => {
            $('.message_info').fadeOut();
        }, 1000);

    });
    $(document).on('change', '.pesanan_check', function(e) {
        e.preventDefault();
        let x = 0;
        $('input[name="pesanan_check"]:checked').each(function() {
            x++;
        });

        if (x == 0) {
            $('.check_all_pesanan').addClass('d-none');
        } else {
            $('.check_all_pesanan').removeClass('d-none');
        }
    });


    $(document).on('click', '.btn_check_all_pesanan', function(e) {
        e.preventDefault();
        if ($(this).hasClass('btn_bright_sm')) {
            $('input[name="pesanan_check"]').prop('checked', true);
            $(this).removeClass('btn_bright_sm');
            $(this).addClass('btn_light_sm');
        } else {
            $('input[name="pesanan_check"]').prop('checked', false);
            $(this).addClass('btn_bright_sm');
            $(this).removeClass('btn_light_sm');
            $('.check_all_pesanan').addClass('d-none');
        }

    });
    $(document).on('click', '.input_tgl', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let col = $(this).attr('name');
        let val = $(this).val();

        $('.body_btn_modal_input_tgl').html('<button class="btn_danger cancel_input_tgl" data-id="' + id + '" data-col="' + col + '" style="border-radius: 5px;"><i style="font-size:medium;" class="fa-solid fa-ban"></i></button><button class="btn_secondary insert_tgl" data-id="' + id + '" data-col="' + col + '" style="border-radius: 5px;"><i class="fa-regular fa-circle-check" style="font-size:medium;"></i></button>');
        $('.modal_input_tgl').fadeIn();

    });


    $(document).on('click', '.cancel_input_tgl', function(e) {
        let id = $(this).data('id');
        let col = $(this).data('col');

        $('.input_' + col + '_' + id).val('-');

        $('.body_btn_modal_input_tgl').html('');
        $('.modal_input_tgl').fadeOut();

    });
    $(document).on('click', '.insert_tgl', function(e) {

        let id = $(this).data('id');
        let col = $(this).data('col');
        let val = $('.val_input_tgl').val();
        let arr = val.split('-');
        let tgl = arr[2] + '/' + arr[1] + '/' + arr[0];
        $('.input_' + col + '_' + id).val(tgl);
        $('.body_btn_modal_input_tgl').html('');
        $('.modal_input_tgl').fadeOut();
    });


    // add
    $(document).on('click', '.input_deadline', function(e) {
        e.preventDefault();

        $('.body_btn_modal_input_tgl').html('<button class="btn_danger cancel_deadline" style="border-radius: 5px;"><i style="font-size:medium;" class="fa-solid fa-ban"></i></button><button class="btn_secondary insert_deadline" style="border-radius: 5px;"><i class="fa-regular fa-circle-check" style="font-size:medium;"></i></button>');
        $('.modal_input_tgl').fadeIn();

    });
    $(document).on('click', '.cancel_deadline', function(e) {
        e.preventDefault();
        $('.input_deadline').val('-');

        $('.body_btn_modal_input_tgl').html('');
        $('.modal_input_tgl').fadeOut();

    });
    $(document).on('click', '.insert_deadline', function(e) {
        e.preventDefault();
        let val = $('.val_input_tgl').val();
        let arr = val.split('-');
        let tgl = arr[2] + '/' + arr[1] + '/' + arr[0];
        $('.input_deadline').val(tgl);
        $('.body_btn_modal_input_tgl').html('');
        $('.modal_input_tgl').fadeOut();

    });
    $(document).on('change', '.selesai', function(e) {
        e.preventDefault();
        let id = $(this).data('id');

        post('<?= url(); ?>/selesai', {
                id
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


    });

    $(document).on('click', '.data_belum', function(e) {
        e.preventDefault();

        let order = '<?= url(); ?>';

        post('<?= url(); ?>/data_belum', {
                order
            })
            .then(res => {
                if (res.status == '200') {
                    let html = '';

                    for (let i = 0; i < res.data.length; i++) {
                        html += '<tr>';
                        html += '<td>' + (i + 1) + '</td>';
                        html += '<td>' + res.data[i].tgl_order + '</td>';
                        html += '<td>' + res.data[i].barang + '</td>';
                        html += '<td class="d-none d-md-table-cell">' + res.data[i].pemesan + '</td>';
                        html += '<td class="d-none d-md-table-cell">' + upper_first(res.data[i].penerima_order) + '</td>';
                        html += '<td>' + res.data[i].icon + '</td>';
                        html += '</tr>';
                    }

                    $('.body_modal_data_belum').html(html);
                    let myModal = document.getElementById('modal_data_belum');
                    let modal = bootstrap.Modal.getOrCreateInstance(myModal)
                    modal.show();


                } else {
                    gagal(res.message);
                }

            })


    });
    $(document).on('change', '.kondisi', function(e) {
        e.preventDefault();

        let val = $(this).val();
        let id = $(this).data('id');

        post('inventaris/update_kondisi', {
                id,
                val
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                } else {
                    gagal(res.message);
                }

            })


    });
    $(document).on('click', '.detail_djana', function(e) {
        e.preventDefault();
        let tabel = $(this).data('tabel');
        let id = $(this).data('id');

        post('pesanan/detail_js', {
                tabel,
                id
            })
            .then(res => {
                if (res.status == '200') {
                    let icons = <?= json_encode(get_icon(null, 'ok')); ?>;
                    console.log(icons);
                    let html = '';

                    html += '<div class="d-flex justify-content-between btn_main_inactive py-2 px-3" style="border-radius:0px;">';
                    html += '<div>';
                    html += '<div class="main_color"><i class="fa-solid fa-bag-shopping"></i> ' + res.data.barang + '</div>';
                    html += '</div>';
                    html += '<a href="" data-bs-dismiss="modal" class="danger_color">';
                    html += '<i class="fa-solid fa-circle-xmark"></i>';
                    html += '</a>';
                    html += '</div>';
                    html += '<div class="modal-body py-2">';

                    html += '<div class="card">';
                    html += '<div class="card-body bg_light">';
                    html += '<div class="d-flex gap-2 pt-0">';
                    for (let i = 0; i < icons.length; i++) {
                        html += '<div class="d-flex gap-2">';
                        html += (i > 0 ? '<span><i class="fa-solid fa-arrow-right-long light_color"></i></span>' : '') + ' ' + '<span class="' + (res.data.status == icons[i].status ? 'success_color' : 'light_color') + '">' + icons[i].icon + '</span>';
                        html += '</div>';
                    }

                    html += '</div>';

                    html += '<div class="card mb-2">';
                    html += '<div class="card-body">';
                    html += '<div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">';
                    html += '<div>ORDER</div>';

                    html += '</div>';
                    html += '<div class="row g-2">';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<input type="text" class="form-control" value="Inv. Djana">';
                    html += '<div class="input-group-text">';
                    html += '<input disabled class="form-check-input mt-0" name="is_inv" type="checkbox" ' + (res.data.is_inv == 1 ? 'checked' : '') + '>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Tgl. Order</label>';
                    html += '<input disabled class="form-control" value="' + (res.data.tgl_order == 0 ? '-' : res.data.tgl_order) + '">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Barang</span>';
                    html += '<input disabled type="text" name="barang" class="form-control" value="' + res.data.barang + '" placeholder="Barang">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Penerima Order</label>';
                    html += '<input disabled type="text" class="form-control" value="' + upper_first(res.data.penerima_order) + '" placeholder="Penerima Order" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Pj Order</label>';
                    html += '<input disabled type="text" class="form-control" value="' + upper_first(res.data.pj_order) + '" placeholder="Pj Order" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Tgl. Deadline</label>';
                    html += '<input disabled class="form-control" value="' + (res.data.deadline == 0 ? '-' : res.data.deadline) + '">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Pemesan</span>';
                    html += '<input disabled type="text" name="pemesan" value="' + res.data.pemesan + '" class="form-control" placeholder="Pemesan" required>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Catatan</span>';
                    html += '<input disabled type="text" name="catatan_order" value="' + res.data.catatan_order + '" class="form-control" placeholder="Catatan">';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="card mb-2">';
                    html += '<div class="card-body">';
                    html += '<div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">DP</div>';
                    html += '<div class="row g-2">';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Tgl. Dp</label>';
                    html += '<input disabled class="form-control" value="' + (res.data.tgl_dp == 0 ? '-' : res.data.tgl_dp) + '" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Jml. Dp</span>';
                    html += '<input disabled type="text" name="jml_dp" class="form-control uang" value="' + rupiah(res.data.jml_dp) + '" placeholder="Jumlah Dp" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Pj Dp</label>';
                    html += '<input disabled type="text" class="form-control" value="' + upper_first(res.data.pj_dp) + '" placeholder="Pj Dp" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Catatan</span>';
                    html += '<input disabled type="text" name="catatan_dp" value="' + res.data.catatan_dp + '" class="form-control" placeholder="Catatan" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="card mb-2">';
                    html += '<div class="card-body">';
                    html += '<div class=" mb-1 mb-1" style="border-radius: 4px 4px 0px 0px;">LUNAS</div>';
                    html += '<div class="row g-2">';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Tgl. Lunas</label>';
                    html += '<input disabled class="form-control" value="' + (res.data.tgl_lunas == 0 ? '-' : res.data.tgl_lunas) + '" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Jml. Lunas</span>';
                    html += '<input disabled type="text" name="jml_lunas" class="form-control" value="' + rupiah(res.data.jml_lunas) + '" placeholder="Jumlah lunas" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Pj Lunas</label>';
                    html += '<input disabled type="text" class="form-control" value="' + upper_first(res.data.pj_lunas) + '" placeholder="Pj Lunas" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Catatan</span>';
                    html += '<input disabled type="text" name="catatan_lunas" value="' + res.data.catatan_lunas + '" class="form-control" placeholder="Catatan" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="card">';
                    html += '<div class="card-body">';
                    html += '<div class="btn_secondary mb-1" style="border-radius: 4px 4px 0px 0px;">UANG MASUK</div>';
                    html += '<div class="row g-2">';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Tgl. Uang Masuk</label>';
                    html += '<input disabled class="form-control" value="' + (res.data.tgl == 0 ? '-' : res.data.tgl) + '" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Jml. Uang Masuk</span>';
                    html += '<input disabled type="text" name="jml" class="form-control uang" value="' + rupiah(res.data.jml) + '" placeholder="Jumlah Uang Masuk" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<label style="width: 120px;" class="input-group-text">Penerima</label>';
                    html += '<input disabled type="text" class="form-control" value="' + upper_first(res.data.penerima) + '" placeholder="Penerima Uang" readonly>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="col-md-6">';
                    html += '<div class="input-group input-group-sm">';
                    html += '<span style="width: 120px;" class="input-group-text">Catatan</span>';
                    html += '<input disabled type="text" name="catatan" value="' + res.data.catatan + '" class="form-control" placeholder="Catatan" readonly';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    $('.body_detail').html(html);
                    $('.body_modal_data_belum').html(html);
                    let myModal = document.getElementById('detail');
                    let modal = bootstrap.Modal.getOrCreateInstance(myModal)
                    modal.show();


                } else {
                    gagal(res.message);
                }

            })


    });

    $(document).on('blur', '.qty', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let harga = $(this).data('harga');
        let val = $(this).text();
        let harga_baru = Math.round(harga / val);
        post('nota/update_qty', {
                id,
                harga,
                val
            })
            .then(res => {
                if (res.status == '200') {
                    $('.harga_' + id).text(rupiah(harga_baru.toString()));
                    sukses();
                } else {
                    gagal(res.message);
                }

            })


    });
    $(document).on('keyup', '.cari_barang', function(e) {
        e.preventDefault();

        let text = $(this).val();
        post('nota/cari_barang', {
                text
            })
            .then(res => {
                if (res.status == '200') {
                    let html = '';
                    html += '<table class="table table-bordered table-sm table-striped">';
                    html += '<thead>';
                    html += '<tr>';
                    html += '<th scope="col">#</th>';
                    html += '<th scope="col">Tgl</th>';
                    html += '<th scope="col">Barang</th>';
                    html += '<th scope="col">Pembeli</th>';
                    html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';
                    for (let i = 0; i < res.data.length; i++) {

                        html += '<tr>';
                        html += '<td>' + (i + 1) + '</td>';
                        html += '<td>' + res.data[i].tgl_order + '</td>';
                        html += '<td><a class="btn_bright_sm insert_barang" data-id="' + res.data[i].id + '" data-barang="' + res.data[i].barang + '" data-harga="' + res.data[i].jml_lunas + '" data-tgl="' + res.data[i].tgl_order + '" href="">' + res.data[i].barang + '</a></td>';
                        html += '<td>' + res.data[i].pemesan + '</td>';
                        html + '</tr>';

                    }
                    html += '</tbody>';
                    html += '</table>';
                    $('.body_cari_barang').html(html);
                } else {
                    gagal(res.message);
                }

            })


    });

    let nomor = 0;
    $(document).on('click', '.insert_barang', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let harga = $(this).data('harga');
        let tgl = $(this).data('tgl');
        let barang = $(this).data('barang');
        let n = $('#tabel_nota tr').length - 1;

        no = 1;
        if (nomor == 0 && n == 1) {
            nomor = 1;
        } else {
            no += n;
        }

        // let no = n;

        let html = '';
        html += '<tr class="list_nota_' + no + '">';
        html += '<td>' + no + '</td>';
        html += '<td>' + tgl + '</td>';
        html += '<td>' + barang + '</td>';
        html += '<td style="text-align: center;" contenteditable="true" class="qty_nota" data-id="' + id + '" data-harga="' + harga + '" data-no="' + no + '">1</td>';
        html += '<td class="harga_nota_' + no + '">' + rupiah(harga.toString()) + '</td>';
        html += '<td><a class="remove_row text-danger" data-no="' + no + '" href=""><i class="fa-solid fa-circle-minus"></i></a></td>';
        html += '</tr>';

        $('.body_insert_nota tr:last').after(html);
        $('.body_cari_barang').html('');
        $('.remove_tr').remove();
    });
    $(document).on('click', '.remove_row', function(e) {
        e.preventDefault();

        let no = $(this).data('no');

        $('.list_nota_' + no).remove();
    });
    $(document).on('blur', '.qty_nota', function(e) {
        e.preventDefault();

        let no = $(this).data('no');
        let harga = $(this).data('harga');
        let val = $(this).text();
        let harga_baru = Math.round(harga / val);
        $('.harga_nota_' + no).text(rupiah(harga_baru.toString()));

    });
    $(document).on('click', '.create_nota', function(e) {
        e.preventDefault();

        let data = [];
        $('.qty_nota').each(function() {
            let id = $(this).data('id');
            let qty = $(this).text();
            let temp = {
                id,
                qty
            };
            data.push(temp);
        });
        post('nota/create', {
                data
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
    });

    $(document).on('click', '.btn_check_all_pesanan', function(e) {
        e.preventDefault();

        if ($(this).data('status') == 'no') {
            $('input[name="pesanan_list"]').prop('checked', true);
            $(this).removeClass('btn_bright_sm');
            $(this).addClass('btn_light_sm');
            $(this).data('status', 'yes');
        } else {
            $('input[name="pesanan_list"]').prop('checked', false);
            $(this).addClass('btn_bright_sm');
            $(this).removeClass('btn_light_sm');
            $('.check_all_pesanan').addClass('d-none');
            $(this).data('status', 'no');
        }

    });

    $(document).on('change', '.pesanan_list', function(e) {
        e.preventDefault();

        let x = 0;
        $('input[name="pesanan_list"]:checked').each(function() {
            x++;
        });

        if (x == 0) {
            $('.check_all_pesanan').addClass('d-none');
        } else {
            $('.check_all_pesanan').removeClass('d-none');
        }

    });
    $(document).on('click', '.btn_laporan', function(e) {
        e.preventDefault();

        let data = [];
        $('input[name="pesanan_list"]:checked').each(function() {
            data.push($(this).val());
        });
        post('pesanan/insert_to_laporan', {
                data
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                } else {
                    gagal(res.message);
                }

            })
    });


    <?php if (url() == 'public') : ?>
        const show_statistik = () => {

            let data = <?= json_encode($statistik); ?>;
            let options = {
                title: {
                    text: "DJANASQUAD"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y})",
                    yValueFormatString: "#,##0.#" % "",
                    dataPoints: data
                }]
            };
            $("#chartContainer").CanvasJSChart(options);
        }
        show_statistik();
    <?php endif; ?>
</script>