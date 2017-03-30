<script type="text/javascript">
    function select2($class,$ajaxUrl){
        $($class).select2({
            placeholder: 'Enter Text to Search',
            ajax: {
                dataType: 'json',
                theme: "bootstrap",
                url: '{{ url('') }}'+$ajaxUrl,
                delay: 400,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                    //console.log(data);
                    return {
                        results: data
                    };
                }
            },
            minimumInputLength: 2,
            theme: "bootstrap",
            language: "zh-CN",
            escapeMarkup: function (markup) { return markup; },
            templateResult: formatRepo
        });
    }
    function formatRepo (repo) {
        var markup = "<div>" + repo.text + "</div>";

        if (repo.descr) {
            markup += "<div>" + repo.descr + "</div>";
        }

        return markup;
    }
</script>