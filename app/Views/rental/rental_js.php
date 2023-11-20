<script>
    $(".input_date").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
            .format(this.getAttribute("data-date-format"))
        )
    }).trigger("change");


    $(document).on('blur', '.update_blur_rental', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let col = $(this).data('col');
        let val = $(this).text();
        let tabel = '<?= (url(6) == '' ? 'Bus' : url(6)); ?>';

        post('<?= url(); ?>/update_blur', {
                id,
                col,
                tabel,
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
</script>