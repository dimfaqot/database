<script>
    const cari_nama_db = (tabel, gender, order, col, val, id) => {
        post("cari_nama_db", {
            tabel,
            gender,
            val
        }).then((res) => {
            if (res.status == '200') {
                let html = '';
                html += '<li class="text-center text-dark" style="border-bottom:1px solid black;"><a class="dropdown-item clear_cari_nama_db" data-id="' + id + '" data-order="' + order + '" data-col="' + col + '" href="#"><i class="fa-solid fa-xmark"></i> Cancel</a></li>'
                if (res.data.length == 0) {
                    html += '<li class="text-danger" style="font-style:italic;"><i class="fa-solid fa-circle-exclamation"></i> Data tidak ditemukan!</li>';
                } else {
                    for (let d = 0; d < res.data.length; d++) {
                        html += '<li><a class="dropdown-item insert_cari_nama_db" data-id="' + id + '" data-col="' + col + '" data-order="' + order + '" href="#">' + res.data[d].nama + '</a></li>';
                    };
                }

                if (order == 'add') {
                    $('.body_' + order + '_' + col).html(html);
                    $('.body_' + order + '_' + col).addClass('d-block');
                }
                if (order == 'update') {
                    $('.body_' + order + '_' + col + '_' + id).html(html);
                    $('.body_' + order + '_' + col + '_' + id).addClass('d-block');
                }

            } else {
                gagal(res.message);
            }
        })

    }

    const clear_cari_nama_db = (order, col, id) => {
        if (order == 'add') {
            $('.body_' + order + '_' + col).html('');
            $('.body_' + order + '_' + col).removeClass('d-block');
        }
        if (order == 'update') {
            $('.body_' + order + '_' + col + '_' + id).html('');
            $('.body_' + order + '_' + col + '_' + id).removeClass('d-block');
        }
    }

    const insert_cari_nama_db = (val, order, col, id) => {
        if (order == 'add') {
            $('.' + order + '_' + col).val(val);
        }
        if (order == 'update') {
            $('.' + order + '_' + col + '_' + id).val(val);
        }

        clear_cari_nama_db(order, col, id);
    }

    $(document).on('keyup', '.cari_nama_db', function(e) {
        e.preventDefault();
        let tabel = $(this).data('tabel');
        let order = $(this).data('order');
        let col = $(this).attr('name');
        let id = $(this).data('id');
        let gender = $(this).data('gender');
        let val = $(this).val();

        cari_nama_db(tabel, gender, order, col, val, id);

    });
    $(document).on('click', '.insert_cari_nama_db', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        let col = $(this).data('col');
        let id = $(this).data('id');
        let val = $(this).text();

        insert_cari_nama_db(val, order, col, id);

    });
    $(document).on('click', '.clear_cari_nama_db', function(e) {
        e.preventDefault();
        let order = $(this).data('order');
        let col = $(this).data('col');
        let id = $(this).data('id');

        clear_cari_nama_db(order, col, id);

    });

    // anggota kelas
</script>