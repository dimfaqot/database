<script>
    $(".input_date").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change");

    $(document).on('click', '.daftar_lagu', function(e) {
        e.preventDefault();
        let val = $('.value_daftar_lagu').val();
        let order = $(this).data('order');


        let values = [];
        $('.get_daftar_lagu').each(function() {
            values.push($(this).text());
        })


        let html = '';
        if (values.length == 0) {
            for (let i = 0; i < val; i++) {
                html += '<tr class="daftar_lagu_' + i + '">';
                html += '<td scope="row" style="width: 40px;">' + (i + 1) + '</td>';
                html += '<td contenteditable="true" class="get_daftar_lagu"></td>';
                html += '<td style="width: 20px;"><a href="" class="danger_color remove_daftar_lagu " data-i="' + i + '" style="font-size: medium;"><i class="fa-solid fa-circle-xmark danger_color"></i></a></td>';
                html += '</tr>';
            }
        } else {
            for (let i = 0; i < values.length; i++) {
                html += '<tr class="daftar_lagu_' + i + '">';
                html += '<td scope="row" style="width: 40px;">' + (i + 1) + '</td>';
                html += '<td contenteditable="true" class="get_daftar_lagu">' + values[i] + '</td>';
                html += '<td style="width: 20px;"><a href="" class="danger_color remove_daftar_lagu " data-i="' + i + '" style="font-size: medium;"><i class="fa-solid fa-circle-xmark danger_color"></i></a></td>';
                html += '</tr>';
            }


            for (let i = values.length; i < (values.length + parseInt(val)); i++) {
                html += '<tr class="daftar_lagu_' + i + '">';
                html += '<td scope="row" style="width: 40px;">' + (i + 1) + '</td>';
                html += '<td contenteditable="true" class="get_daftar_lagu"></td>';
                html += '<td style="width: 20px;"><a href="" class="danger_color remove_daftar_lagu" data-i="' + i + '" style="font-size: medium;"><i class="fa-solid fa-circle-xmark danger_color"></i></a></td>';
                html += '</tr>';
            }

        }

        $('.body_daftar_lagu').html(html);

    });
    $(document).on('click', '.remove_daftar_lagu', function(e) {
        e.preventDefault();
        let val = $(this).data('i');

        $('.daftar_lagu_' + val).remove();

    });
    $(document).on('click', '.update_daftar_lagu', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let values = [];
        $('.get_daftar_lagu').each(function() {
            values.push($(this).text());
        })

        post('<?= url(); ?>/update_lagu', {
                id,
                values
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
</script>